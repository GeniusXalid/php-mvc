<?php
// +---------------------------------------------------------------------------+
// | This file is part of the CIRCUIT MVC Framework. >> LICENSE for bullshit.  |
// +---------------------------------------------------------------------------+
// Circuit-App:			Default 
// Model:				UserStatusBar 
// Description: 		Return an array of statusbars pre-formatted. 
// Author:		   		kaia9 <kaia@gaiaonline.com>
// Start Date:			08.10.06 

/*
  Usage:
	$model =& $contrller->getModel('Default.UserStatusBar');
	$model->loadUserIds( $string_or_array );
	$model->changeViewPrefs( $string_or_array_of_custom_fields_to_display );
	$model->getAllStatusBarData( ); 
 */
class Default_UserStatusBar_CircuitModel extends CircuitModel
{
	// load the fcuking observer as an object to use internally
	function __construct( $c, $n )
	{	
		$this->o =& $c->getObserver();
		$this->o->append('Default.debug.steps', __CLASS__ . '.' . __FUNCTION__ );
		
		$this->set('viewprefs',array('status','profile','housing','journal','pm','store','trade','www','aim','yim','msn','icq'));
		parent::__construct($c, $n);
    }

    function loadUserIds( $loadids )
    {
		$this->o->append('Default.debug.steps', __CLASS__ . '.' . __FUNCTION__ );
		
		// clean up string input or just use an array.
		if ( !is_array($loadids) ) 
		{
			$loadids = ereg_replace('\'','',$loadids);
			$loadids = ereg_replace('\"','',$loadids);
			$loadids = ereg_replace(' ','',$loadids);
			$loadids_arr = split(',',$loadids);
		}
		else 
		{
			$loadids_arr = $loadids;
		}
		
		$this->set('ids',$loadids_arr);
		
		return true;
    }
	
	function changeViewPrefs( $newprefs )
    {
		$this->o->append('Default.debug.steps', __CLASS__ . '.' . __FUNCTION__ );
		
		// clean up string input or just use an array.
		if ( !is_array($newprefs) ) 
		{
			$newprefs = ereg_replace('\'','',$newprefs);
			$newprefs = ereg_replace('\"','',$newprefs);
			$newprefs = ereg_replace(' ','',$newprefs);
			$newprefs_arr = split(',',$newprefs);
		}
		else 
		{
			$newprefs_arr =& $newprefs;
		}
		
		$newviewprefs = array();
		foreach( $newprefs_arr as $newpref )
		{
			// validate that each new preference is a valid one.
			if ( in_array($newpref,$this->get('viewprefs')) )
			{
				$newviewprefs[] = $newpref;
			}
			else
			{
				$this->o->append('Default.debug.invalid_prefs', $newpref );
			}
		}
		
		
		$this->set('viewprefs',$newviewprefs);
		return true;
    }
	
	function getAllStatusBarData()
	{
		$this->getCacheData();
		$this->getLiveData();
		return true;
	}
	
	
	function getCacheData()
	{
		$this->o->append('Default.debug.steps', __CLASS__ . '.' . __FUNCTION__ );
		
		// check memcache for the data.		
		$memcache = MemcacheFactory::construct('query_memcache');
		foreach ($this->ids as $id) 
		{
			$memcache_keys[$id] = 'UserStatusBar_'.$id;
		}
		$cache = $memcache->get( $memcache_keys );
		
		// check memcache for which keys we got and which we need.
		$records_found = $records_missing = array();
		foreach ($cache as $mem_cache)
		{
			$records_found[] = $mem_cache['user_id'];
		}
		
		// figure out which we still need to get.
		$records_missing = array_diff($records_found,$this->ids);
		
		if ( count($records_missing)==0 && count($this->ids)==count($cache) )
		{
			$this->setResponse( $cache );
			return TRUE;
		}
		
		$this->set('missing',$records_missing);
		
		// we have a few queries to get the correct dataset.
		$dao = DAOFactory::create('users');
		$dao->setWhat("`user_id`, `username`, `user_allow_viewonline`, `user_session_time`, `user_journal_id`, ".
					"`user_receive_pm`, `user_viewemail`, `user_email`, `user_vend`, `user_website`, `user_icq`, ".
					"`user_aim`,`user_msnm`, `user_yim`");
		$dao->byIds( $records_missing );
		$rs = $dao->execute();
		if(!$rs->isSuccess())
		{
			throw new CircuitDatabaseException( 'Unable to retrieve userdata for statusbar.', $rs );
		}
		
		$newdata = array();
		while ( $row = $rs->fetchRow(DB_ASSOC) )
		{
			$newdata[$row['user_id']] = $row;
		}
		
		// also get the home location and house preferences
		$dao = DAOFactory::create('gaiahousing');
		$dao->setWhat("`user_id`, `home_zip`, `home_privacy`");
		$dao->byIds( $records_missing );
		$rs = $dao->execute();
		if(!$rs->isSuccess())
		{
			throw new CircuitDatabaseException( 'Unable to retrieve housingdata for statusbar.', $rs );
		}

		while ( $row = $rs->fetchRow(DB_ASSOC) )
		{
			$newdata[$row['user_id']]['home_zip'] = $row['home_zip'];
			$newdata[$row['user_id']]['home_privacy'] = $row['home_privacy'];
		}
		
			
		// go through each user';s data and get what's appropriate.	
		$me = SC::get('userdata.user_id');
		$cutoff = SC::get('board_config.time_now') - 600;
		foreach ($newdata as $uid=>$user)
		{
			// init the stat array
			$stats = array();
			
			// online offline status. will get edited later.		
			if (isset($user['user_session_time']) && $user['user_session_time'] > $cutoff) 
			{
				$stats['status'] = 'online';
			} 
			else 
			{
				$stats['status'] = 'offline';
			}
			
			
			// profile
			$stats['profile_url'] = append_sid("/profile/index.php?view=profile.ShowProfile&amp;item=" . $uid);
			
			
			// housing
			if ( isset($user['home_zip']) ) 
			{ 
				$stats['home_zip'] = $user['home_zip'];
				$stats['home_privacy'] = $user['home_privacy']; 
			}
			
			
			// journal
			if (isset($user['user_journal_id'])) 
			{ 
				$stats['journal_id'] = $user['user_journal_id']; 
				$stats['journal_view'] = $user['journal_view'];
			} 
			
			
			// private messages
			if (isset($user['user_receive_pm']))
			{
				$stats['pm_receive'] = $user['user_receive_pm'];
			}
			
			
			// guilds
			if (isset($user['user_guild_count']))
			{	
				$stats['guilds_url'] = append_sid("/guilds/index.php?gmode=search&user_id=" . $uid);
			}
			
			
			// store (vend)
			if (isset($user['user_vend']))
			{	
				$stats['vend_url'] = append_sid('http://'.VEND_SERVER."/gaia/vend.php?mystore=" . $user_id);
			}
			
			
			// trade
			$stats['trade_url'] = append_sid('http://'.BANK_SERVER."/gaia/bank.php?mode=trade&uid=".$user_id);
			
						
			// www
			if (isset($user['user_website']))
			{	
				$stats['www_url'] = external_url($user['user_website']);
			}
			
			
			// aim
			if (isset($user['user_aim']))
			{	
				$stats['aim_url'] = 'aim:goim?screenname='.htmlspecialchars($user['user_aim']).'&amp;message=FHello+Are+you+there?';
			}
			
			
			// icq
			if (isset($user['user_icq']))
			{	
				$stats['icq_url'] = external_url('http://wwp.icq.com/scripts/search.dll?to='.htmlspecialchars($user['user_icq']));
			}
			
			
			// yim
			if (isset($user['user_yim']))
			{	
				$stats['yim_url'] = external_url('http://edit.yahoo.com/config/send_webmesg?.target='.htmlspecialchars($user['user_yim']).'&amp;.src=pg');
			}
			
			
			// msn
			if (isset($user['user_msnm']))
			{	
				$stats['msnm_url'] = append_sid("/profile/index.php?view=profile.ShowProfile&amp;item=" . $uid);
			}
			
			// add to memcache and cache
			$memcache->set( $memcache_keys[$uid], $stats, MEMCACHE_COMPRESSED, 300 );
			$cache[$uid] = $stats;
		}
		
		
		// set into the observer for further usage
		$this->set('cachedata',$cache);
		return true;
	}
	
	
	function getLiveData( )
	{
		$this->o->append('Default.debug.steps', __CLASS__ . '.' . __FUNCTION__ );
		
		// woohoo! GET THE CACHE DATA
		$cachedata =& $this->get('cachedata');
		$missing =& $this->get('missing');
	
		// so now, we check the friendlist to figure shit out, 
		// and have a final set of data to cache.
		$fu =& new FriendUtility();
		$fu->getFriendLists( $missing );
		$fu->getBothLists( );
		
		$final_stats = array();
		$me = SC::get('userdata.user_id');
		$is_mod = require_level(USERLEVEL_MODERATOR_TEAM);
		$cutoff = SC::get('board_config.time_now') - 600;
		foreach ($cachedata as $uid=>$user_cache)
		{
			// init the stat array
			$stats = $user_cache;

			// determine friend bullshit.
			$is_my_friend = $fu->isFriend( $uid );
			$am_i_their_friend = $fu->isFriend( $me, $uid );
			$am_i_ignored = $fu->isIgnored( $me, $uid );
			
			// first. online status.
			if ( $me == $uid )
			{
				$stats['status'] = 'online';
			}
			else if ( $user_cache['status'] == 'online' 
				&& $is_mod==false && $am_i_their_friend==false ) 
			{
				// If : user does not allow others to view status and viewer is not a mod and 
				// viewer is not in the user's friends list - hidden
				$stats['status'] = 'hidden';
			}
			
						
			// housing
			if ( isset($user['home_zip']) ) 
			{ 
				
				$locked = false;
				if ( $uid == $me || $is_mod == true )
				{
					$locked = false;
				}
				else if ( ($user['home_privacy'] == 2 && $am_i_their_friend==false )) 
				{
					$locked = true;
				} 
				else if ( $am_i_ignored==true || $user['home_privacy'] == 0 )
				{
					$locked = true;
				}
				
				if ( $locked == false)
				{
					$stats['housing_url'] = append_sid("/launch/towns?home=" . $user['home_zip']);
				}
			}
			
			
			// journal
			if (isset($user['journal_view'])) 
			{ 
				$journalview = true;
				if ( $uid == $me['user_id'] || $is_mod == true )
				{
					$journalview = true;
				}
				else if ( $user['journal_view'] == 2 && $am_i_their_friend==false ) 
				{
					$journalview = false;
				} 
				else if ( $am_i_ignored==true || $user['journal_view'] == 0 )
				{
					$journalview = false;
				}
				
				if ( $journalview == true)
				{
					$stats['journal_url'] = append_sid("/journal/?u=" . $uid);
				}
			} 
			
			
			// private messages
			if (isset($user['pm_receive']))
			{
				$receive = true;
				if ( $uid == $me['user_id'] || $is_mod == true )
				{
					$receive = true;
				}
				else if ( $user['pm_receive'] == 2 && $am_i_their_friend==false ) 
				{
					$receive = false;
				} 
				else if ( $am_i_ignored==true || $user['pm_receive'] == 0 )
				{
					$receive = false;
				}
				
				if ( $receive == true)
				{
					$stats['pm_url'] = append_sid("/profile/privmsg.php?mode=post&amp;" . POST_USERS_URL . "=".$uid);
				}
			}
			
			$final_stats[$uid] = $stats;
		}
	
		unset($fu);
		$this->remove('cachedata');
		$this->set('statusbar',$final_stats);
		return true;
	
	
	}
}
 
?>