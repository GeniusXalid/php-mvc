<?
// +---------------------------------------------------------------------------+
// | This file is part of the CIRCUIT MVC Framework. >> LICENSE for bullshit.  |
// +---------------------------------------------------------------------------+
// Circuit-App:			Default 
// Mold:				UserStatusBar 
// Description: 		Return an array of statusbars pre-formatted. 
// Author:		   		kaia9 <kaia@gaiaonline.com>
// Start Date:			08.10.06 

/*
  Usage:
	$mold =& $contrller->getMold('Default.UserStatusBar');
	$keyed_array = $mold->execute( $controller->getModelData('UserStatusBar') ); 
 */


class Default_UserStatusBar_CircuitMold
{

    // load the fcuking observer as an object to use internally
	function __construct( $c, $n )
	{	
		$this->o =& $c->getObserver();
		$this->o->append('Default.debug.steps', __CLASS__ . '.' . __FUNCTION__ );
    }
	
	function execute( $statusbardata )
	{
		$return_bars = array();
		foreach ($statusbardata as $status_user)
		{
			$return_bars[$status_user['user_id']] = $this->singleBar($status_user);
		}
		return $return_bars;
	}
	
	function singleBar( $sb_userdata )
	{
		$is_mod = require_level(USERLEVEL_SITEASSISTANCE1);
    
		$images       =& SC::get('images');
		$userdata     =& SC::get('userdata');
		$board_config =& SC::get('board_config');
		
		# Default indicators
		if (empty($use_rows)) { 
		$use_rows = array("status","profile","housing","journal","pm","store","trade","www","aim","yim","msn","icq");
		}
		
		# ON/OFFLINE INDICATOR
		# -----------------------------------
		
		# Make the default cutoff for on/off status 10 minutes
		if (!isset($online_offline_cutoff)) { $online_offline_cutoff = SC::get('board_config.time_now') - 600; }
		
		# If : user does not allow others to view status and viewer is not a mod and viewer is not in the user's friends list - hidden
		$fu = new FriendUtility();
		if (isset($user_data['user_allow_viewonline']) && $user_data['user_allow_viewonline']==0 && $is_mod==false && !$fu->isFriend($userdata['user_id']) ) {
		$status_bar['status_img'] = '<img src="http://' . GRAPHICS_SERVER . '/images/template/icons/icon_hidden.gif" height="22" width="72" border="0">';
		$status_bar['status'] = 'Hidden';
		} 
		# Elseif : user's last recorded session time is greater than the cutoff time - online
		elseif (isset($user_data['user_session_time']) && $user_data['user_session_time'] > $online_offline_cutoff) {
		$status_bar['status_img'] = '<img src="http://' . GRAPHICS_SERVER . '/images/template/icons/icon_online.gif" height="22" width="72" border="0" />';
		$status_bar['status'] = 'Online';
		} 
		# Else : fails above conditions - offline
		else {
		$status_bar['status_img'] = '<img src="http://' . GRAPHICS_SERVER . '/images/template/icons/icon_offline.gif" height="22" width="72" border="0" />';
		$status_bar['status'] = 'Offline';
		}
		# -----------------------------------
		
		# PROFILE
		# -----------------------------------
		if (isset($user_data['user_id'])) { $user_id = $user_data['user_id']; } else { $user_id = ''; }
		if (isset($user_data['username'])) { $user_name = $user_data['username']; } else { $user_name = ''; }
		
		$temp_url = append_sid("/profile/index.php?view=profile.ShowProfile&amp;item=" . $user_id);
		
		$status_bar['profile_img'] = '<a href="' . $temp_url . '"><img src="http://' . GRAPHICS_SERVER . '/images/template/icons/icon_profile_2.gif" alt="View '.addslashes($user_name).'\'s Profile" title="View '.addslashes($user_name).'\'s Profile" border="0" /></a>';
		$status_bar['profile'] = '<a href="' . $temp_url . '">' . "Profile" . '</a>'; 
		# -----------------------------------
		
		# HOUSING
		# -----------------------------------
		//$daoGH =& DaoFactory::create('gaiahousing.detailById');
		//$userHouseDetails =& $daoGH->fetch($user_data['user_id']);
		if (isset($user_data['user_home'])) { $user_home = $user_data['user_home']; } else { $user_home = 0; }
		if ($user_home==1) {
		$temp_url = append_sid("/games/housing/index.php?mode=viewer&amp;" . POST_USERS_URL . "=".$user_id);
		$status_bar['housing_img'] = '<a href="' . $temp_url . '"><img src="http://' . GRAPHICS_SERVER . '/images/template/icons/icon_housing_2.gif" alt="View '.addslashes($user_name).'\'s Home" title="View '.$user_name.'\'s Home" border="0" /></a>';
		$status_bar['housing'] = '<a href="' . $temp_url . '">' . "My Home" . '</a>'; 
		} 
		# -----------------------------------
		
		# JOURNAL
		# -----------------------------------
		if (isset($user_data['user_journal_id'])) { $user_journal_id = $user_data['user_journal_id']; } else { $user_journal_id = 0; }
		$temp_url = append_sid("/journal/?u=" . $user_id);
		$status_bar['journal_img'] = ($user_journal_id!=0) ? '<a href="' . $temp_url . '"><img src="http://' . GRAPHICS_SERVER . '/images/template/icons/icon_journal_2.gif" alt="Read '.addslashes($user_name).'\'s Journal" title="Read '.addslashes($user_name).'\'s Journal" border="0" /></a>' : '';
		$status_bar['journal'] = ($user_journal_id!=0) ? '<a href="$temp_url">Journal</a>' : '';
		# -----------------------------------
		
		# PM
		# -----------------------------------
		if (isset($user_data['user_receive_pm'])) { $user_receive_pm = $user_data['user_receive_pm']; } else { $user_receive_pm = 0; }
		$temp_url = append_sid("/profile/privmsg.php?mode=post&amp;" . POST_USERS_URL . "=".$user_id);
		$status_bar['pm_img'] 
		= ($user_receive_pm != 0) 
		? '<a href="'.$temp_url.'"><img src="http://' . GRAPHICS_SERVER . '/images/template/icons/icon_pm_2.gif" alt="Send '.addslashes($user_name).' a PM" title="Send '.addslashes($user_name). ' a PM" border="0" /></a>' : '';
		$status_bar['pm'] = ($user_receive_pm!=0) ? '<a href="$temp_url">PrivateMsg</a>'  : ''; 
		# -----------------------------------
		
		# EMAIL
		# -----------------------------------
		if (isset($user_data['user_viewemail'])) { $user_viewmail = $user_data['user_viewemail']; } else { $user_viewmail = 0; }
		if (isset($user_data['user_email'])) { $user_email = $user_data['user_email']; } else { $user_email = NULL; }
		if (! isset($poster_id)) { $poster_id = NULL; }
		if ( !empty($user_viewmail) || $is_mod==true ) {
		$temp_url = ( $board_config['board_email_form'] ) ? append_sid("/profile/profile.php?mode=email&amp;" . POST_USERS_URL .'=' . $poster_id) : 'mailto:' . htmlspecialchars($user_email);
		$status_bar['email_img'] = '<a href="' . $temp_url . '"><img src="http://' . GRAPHICS_SERVER . '/images/template/icons/icon_email_2.gif" alt="Send '.addslashes($user_name).'\ an Email" title="Send '.addslashes($user_name).'\ an Email" border="0" /></a>';
		$status_bar['email'] = '<a href="$temp_url">Email</a>'; 
		} 
		else {
		$status_bar['email_img'] = '';
		$status_bar['email'] = '';
		}
		# -----------------------------------
		
		# STORE (VEND)
		# -----------------------------------
		if (isset($user_data['user_vend'])) { $user_vend = $user_data['user_vend']; } else { $user_vend = 0; }
		$temp_url = append_sid('http://'.VEND_SERVER."/gaia/vend.php?mystore=" . $user_id);
		$status_bar['store_img'] = ( $user_vend ) ? '<a href="' . $temp_url . '"><img src="http://' . GRAPHICS_SERVER . '/images/template/icons/icon_mystore_2.gif" alt="'.addslashes($user_name).'\'s store has '.$user_vend.' item(s)" title="'.addslashes($user_name).'\'s store has '.$user_vend.' item(s)" border="0" /></a>' : '';
		$status_bar['store'] = ( $user_vend ) ? '<a href="' . $temp_url . '">'."Store".'</a>' : '';
		# -----------------------------------
		
		# TRADE
		# -----------------------------------
		$temp_url = append_sid('http://'.BANK_SERVER."/gaia/bank.php?mode=trade&uid=".$user_id);
		$status_bar['trade_img'] = '<a href="' . $temp_url . '"><img src="http://' . GRAPHICS_SERVER . '/images/template/icons/icon_trade_2.gif" alt="Trade with '.addslashes($user_name).'" title="Trade with '.addslashes($user_name).'" border="0" /></a>';
		$status_bar['trade'] = '<a href="$temp_url">Trade</a>';
		# -----------------------------------
		
		# WWW (homepage)
		# -----------------------------------
		if (isset($user_data['user_website'])) { $user_website = $user_data['user_website']; } else { $user_website = NULL; }
		$status_bar['www_img'] 
		= ($user_website) 
		? '<a href="'.htmlspecialchars($user_website).'" target="_userwww"><img src="'.$images['icon_www'].'" alt="Visit posters website" title="Visit posters website" border="0" /></a>' : '';
		$status_bar['www'] = ($user_website) ? '<a href="'.htmlspecialchars($user_website).'" target="_userwww">Visit posters website</a>' : '';
		# -----------------------------------
		
		# ICQ
		# -----------------------------------
		if (isset($user_data['user_icq'])) { $user_icq = $user_data['user_icq']; } else { $user_icq = NULL; }
		$status_bar['icq_status_img'] 
		= ($user_icq) 
		? '<a href="http://wwp.icq.com/'.htmlspecialchars($user_icq).'#pager"><img src="http://web.icq.com/whitepages/online?icq='.htmlspecialchars($user_icq).'&img=5" width="18" height="18" border="0" /></a>' : '';
		$status_bar['icq_img'] 
		
		= ($user_icq) 
		? '<a href="http://wwp.icq.com/scripts/search.dll?to='.htmlspecialchars($user_icq).'"><img src="'.$images['icon_icq'].'" alt="ICQ Number" title="'.htmlspecialchars($user_icq).'" border="0" /></a>' : '';
		$status_bar['icq'] = ($user_icq) ? '<a href="http://wwp.icq.com/scripts/search.dll?to='.htmlspecialchars($user_icq).'">ICQ Number</a>' : ''; 
		# -----------------------------------
		
		# AIM
		# -----------------------------------M
		if (isset($user_data['user_aim'])) { $user_aim = $user_data['user_aim']; } else { $user_aim = NULL; }
		$status_bar['aim_img'] 
		= ($user_aim) 
		? '<a href="aim:goim?screenname='.htmlspecialchars($user_aim).'&amp;message=Hello+Are+you+there?"><img src="'.$images['icon_aim'].'" alt="AIM Address" title="'.htmlspecialchars($user_aim).'" border="0" /></a>' : '';
		$status_bar['aim'] = ($user_aim) ? '<a href="aim:goim?screenname='.htmlspecialchars($user_aim).'&amp;message=Hello+Are+you+there?">AIM</a>' : '';
		# -----------------------------------
		
		# MSN
		# -----------------------------------
		if (isset($user_data['user_msnm'])) { $user_msnm = $user_data['user_msnm']; } else { $user_msnm = NULL; }
		$temp_url = append_sid("/profile/profile.php?mode=viewprofile&" . POST_USERS_URL . "=".$user_id);
		$status_bar['msn_img'] = ( $user_msnm ) ? '<a href="'.$temp_url.'"><img src="'.$images['icon_msnm'].'" alt="MSN Messenger" title="'.htmlspecialchars($user_msnm).'" border="0" /></a>' : '';
		$status_bar['msn'] = ($user_msnm) ? '<a href="'.$temp_url.'">MSN Messenger</a>' : '';
		# -----------------------------------
		
		# YIM
		# -----------------------------------
		if (isset($user_data['user_yim'])) { $user_yim = $user_data['user_yim']; } else { $user_yim = NULL; }
		$status_bar['yim_img'] 
		= ($user_yim) 
		? '<a href="http://edit.yahoo.com/config/send_webmesg?.target='.htmlspecialchars($user_yim).'&amp;.src=pg"><img src="'.$images['icon_yim'].'" alt="Yahoo Messenger" title="'.htmlspecialchars($user_yim).'" border="0" /></a>' 
		: '';
		$status_bar['yim'] = ($user_yim) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target='.htmlspecialchars($user_yim).'&amp;.src=pg">Yahoo Messenger</a>' : '';
		# -----------------------------------
		
		# BUILD THE BAR
		# -----------------------------------
		if (! isset($output_bar) ) { $output_bar = NULL; }
		if ($img_or_txt=='img') {
		$start_cap = "<img src=\"http://" . GRAPHICS_SERVER . "/images/template/s.gif\" width=1 height=2><br><img src=\"http://" . GRAPHICS_SERVER . "/images/template/icons/icon_fend_t.gif\" height=22 width=7 border=0>";
		$end_cap = "<img src=\"http://" . GRAPHICS_SERVER . "/images/template/icons/icon_end_t.gif\" height=22 width=9 border=0><br><img src=\"http://" . GRAPHICS_SERVER . "/images/template/s.gif\" width=1 height=2>";
		} 
		else {
		$start_cap = "[&nbsp;";
		$end_cap = "&nbsp;]";
		}
		
		foreach ($use_rows as $show_row) {
		if ($img_or_txt=='img') {
			$show_row_img = $show_row."_img";
			if ( isset($status_bar[$show_row_img]) ) { $output_bar .= $status_bar[$show_row_img]; }
		} 
		else {
			$output_bar .= $status_bar[$show_row];
			if ($status_bar[$show_row]!="") $output_bar .= "&nbsp;&middot;&nbsp;";
		   }
		}
		# -----------------------------------
		
		# Display as image or text
		if ($img_or_txt=="txt" && substr($output_bar,-20)=="&nbsp;&middot;&nbsp;") $output_bar = substr($output_bar,0,-20);
		
		return "\n\n<!-- new profile bar :: ".$_SERVER["HTTP_HOST"]." -->\n" . $start_cap . $output_bar . $end_cap;
	}
	
	
}
?>