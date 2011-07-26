<?php

/**
 * Returns FALSE if the username in observer is not valid (eg. has NPC name, admin imitation etc.)
 * Returns TRUE if the username is ok.
 * This model is used when a new character is created (we check the username)
 * This model is also used when an existing user is attempting to login.
 * 
 * For more information, see the usernamefilter.class included below.
 * 
 * @param observer
 * @return bool
 * @author laine <laine@gaiaonline.com>
 */

require_once( DIR_CLASSES . 'wordfilter/usernamefilter.class.php');

class Default_ValidateUserName_CircuitModel{
	
	function execute(&$observer){
		
			$username=$observer->get('default.validation.username');
			
			// length check
			if (strlen(trim($username)) > 25) {
					$observer->set('error.title', 'Username Error');
					$observer->set('error.message', 'Your username must be no more than 25 characters long.');
					$observer->set('default.validation.status', 'LONG');
					$observer->set('login.request.status', 'LONG');
					return FALSE;
			}
		
			//get the entire list of disallowed words. In the future we might have
			//more specific queries eg. get only swear words, get only NPC, etc. 
			$filterList=UsernameFilter::filterList(1);			
			
			if (count($filterList) <= 0) return TRUE; //nothing to filter against lol
			

			// are they logged in -- Jakob
			// if so, we don't bother doing the NPC check
			// rxes defines the array of regular expressions
			$rxes = array();

			// MATCH 1.  Variants of [NPC] using nonword characters
			$delim = "[\W\s_]";		// Nonword, whitespace, underscore
			$rx =	"^(.*?)" .		// match the start but don't be greedy
					"$delim *?" .	// match 0+ opening delimiters but don't be greedy
					"[N]" . 		// match N
					"$delim *?" . 	// match 0 or more delimiters but don't get greedy
					"[P]" . 		// match P
					"$delim *?" . 	// match 0 or more delimiters but don't get greedy
					"[C]" . 		// match C
					"$delim +" . 	// match an 1+ closing delimiter (be greedy)
					"(.*)";			// match as much as possible to end of string
			$rx = "/" . $rx . "/xi";
			$rxes[] = $rx;

			// MATCH 2,  inpci, lnpcl, l_n-p_c and word variants.  Much stricter so as not
			// to break actual words
			$delim = "[il\|]";		// i, l, pipe
			$rx = 	"^(.*?)" .		// match the start but don't be greedy
					"$delim" .		// delim exact match
					"[\s\-_]*" .	// 0 or more whitespace
					"n[\s\-_]*" .	// n followed by some whitespace or - or _
					"p[\s\-_]*" .	// p followed by some whitespace or - or _
					"c[\s\-_]*" .	// c followed by some whitespace or - or _
					"$delim ?" .	// delim exact match (0 or 1)
					"(.*)";			// grab the rest by being greedy
			$rx = "/" . $rx . "/xi";
			$rxes[] = $rx;
			
			$matched = false;
			foreach ($rxes as $rx)
			{
				if (preg_match($rx, $username)) {
					$matched = true;
				}
			}
			if ($matched)
			{
				/// name found, logged in?
				if (SC::get("userdata.user_level") <= 0) {
					$observer->set('error.title', 'Username Error');
					$observer->set('error.message', 'Your username is in conflict because it is the name of a NPC (Non-Playable Character). For storyline purposes, we kindly ask you to choose another username. Thank you!');
					$observer->set('default.validation.status', 'NPC');
					$observer->set('login.request.status', 'NPC');
					return FALSE;
				}
			}

//-------------------------------------------------------------------------------------
//this is pretty ghetto but we don't have a consesus for handling all the names in the database
//so there is some hack-ish stuff going on eg. with checking ElfTech names it is extra
//strict that previous NPC names

			//do a case insensitive check against each of the NPC names. 
			foreach ($filterList['NPC'] as $f){
				
				//in the future if we want to do other checks like against l33t names we can modify this.
				$pattern="/\b$f\b/i";  //this is more lenient than below
			
				if($f=='ElfTech') //speschul super strict check for elftechs omg ;o;
				{
					$pattern="/.*Elf.*Tech.*/i"; //nothing allowed!!! omg:O
				}
				
				$result=preg_match($pattern, $username);
				
				if(!empty($result))
				{
				$observer->set('error.title', 'Username Error');
				$observer->set('error.message', 'Your username is in conflict because it is the name of a NPC (Non-Playable Character). For storyline purposes, we kindly ask you to choose another username. Thank you!');
				$observer->set('default.validation.status', 'NPC');
				$observer->set('login.request.status', 'NPC');
				return FALSE;
				}	
				
			}
//----------------------------------------------------------------------------------------
			//do a case insensitive check against each of the Admin names. 
			foreach ($filterList['Admin'] as $f){
				
				//in the future if we want to do other checks like against l33t names we can modify this.
				$pattern="/$f/i"; 
			
				$result=preg_match($pattern, $username);
				
				if(!empty($result))
				{
				$observer->set('error.title', 'Username Error');
				$observer->set('error.message', 'Your username is in conflict with administration names. We kindly ask you to choose another username that will not confuse other user.');
				$observer->set('default.validation.status', 'Admin');
				$observer->set('login.request.status', 'Admin');
				return FALSE;	
				}	
				
			}

//----------------------------------------------------------------------------------------
			//do a case insensitive check against each of the Swear names. 
			foreach ($filterList['Swear'] as $f){
				
				//in the future if we want to do other checks like against l33t names we can modify this.
				$pattern="/$f/i"; 
			
				$result=preg_match($pattern, $username);
				
				if(!empty($result))
				{
				$observer->set('error.title', 'Username Error');
				$observer->set('error.message', 'Your username is in conflict with PG-13 guidelines! We kindly ask you to choose another username that is more appropriate.');
				$observer->set('default.validation.status', 'Swear');
				$observer->set('login.request.status', 'Swear');
				return FALSE;	
				}	
				
			}
			
//----------------------------------------------------------------------------------------

			// username approximate matching
			// we need to munge the name now and attempt to standardize the lookups
		    $userdata =& SC::get('userdata');
	
			$username = str_replace("\'", "''", $username);
		    $checkname = strtolower(preg_replace("/^[_\-\+\=\)\(\^\#\!\~\'\s\.]+/",'',$username));
		    $checkname = preg_replace("/[_\-\+\=\)\(\^\#\!\~\'\s\.]+$/",'',$checkname);
		    $checkname = preg_replace("/[\-\+\=\^\#\!\~\s\.]/",'_',$checkname);

			// compressed length check
		    if (strlen(trim($username)) <= 2) {
				$observer->set('error.title', 'Username Error');
				$observer->set('error.message', 'Your username must be at least 3 characters.');
				return FALSE;	
		    }
		
			// invalid character check
		    if (! preg_match('/^[a-zA-z0-9_\-\+\=\)\(\^\#\!\~\s\.]+$/',$username) ) {
				$observer->set('error.title', 'Username Error');
				$observer->set('error.message', 'Your username contains invalid characters.');
				return FALSE;
			}
			
			// check for at least one letter
		    if (! preg_match("/[a-zA-Z]/",$username) ) {
				$observer->set('error.title', 'Username Error');
				$observer->set('error.message', 'Your username must have at least one letter.');
				return FALSE;
			}
			
			// check for double spaces
		    if ( preg_match("/  /",$username) ) {
				$observer->set('error.title', 'Username Error');
				$observer->set('error.message', 'Your username cannot have 2 spaces in a row.');
				return FALSE;
			}
			
			// Don't allow " in username.
			if ( strstr($username, '"') || strstr($username, ',') )
			{
				$observer->set('error.title', 'Username Error');
				$observer->set('error.message', 'Your username cannot contain quotations or commas.');
				return FALSE;
			}

			
			// check for exact username
			$dao =&DaoFactory::create('users');
		    $dao->byExactUsername(strtolower($username));
		    $rs =& $dao->execute();
			if(!$rs->isSuccess())
			{
				$observer->set('error.title', 'Username Error');
				$observer->set('error.message', 'Unable to validate username.');
				$observer->set('error.line', __LINE__);
				$observer->set('error.file', __FILE__);
				$observer->set('error.debug', $rs);
				return FALSE;
			}


			while ( $row = $rs->sql_fetchrow(DB_ASSOC) )
			{
				if ( ( $userdata['session_logged_in'] && $row['username'] != $userdata['username'] ) || !$userdata['session_logged_in'] )
				{
					if ( strtolower($row['username']) == strtolower($username) ) {
						$observer->set('error.title', 'Username Error');
						$observer->set('error.message', 'That username is already taken.');
						return FALSE;
					} else {
						$observer->set('error.title', 'Username Error');
						$observer->set('error.message', 'Your username is too similar to the username of '.$row['username']);
						return FALSE;
					}
				}
			}


			// perform a wildcard search for special character matching
		    if (strtolower($username) != $checkname) 
		    {
		        $dao =&DaoFactory::create('users');
		        $dao->byUsername(preg_replace('/_/','\_',$checkname));
		        $rs =& $dao->execute();

		        while ( $row = $rs->sql_fetchrow(DB_ASSOC) )
		        {
		            if ( ( $userdata['session_logged_in'] && $row['username'] != $userdata['username'] ) || !$userdata['session_logged_in'] )
		            {
		                if ( strtolower($row['username']) == strtolower($username) ) {
							$observer->set('error.title', 'Username Error');
							$observer->set('error.message', 'That username is already taken.');
							return FALSE;
						} else {
							$observer->set('error.title', 'Username Error');
							$observer->set('error.message', 'Your username is too similar to the username of '.$row['username']);
							return FALSE;
						}
		            }
		        }
		    }

			// check wordlist filter
			$dao =& DaoFactory::create('words');
			$dao->setWhat('word');
			$rs =& $dao->execute();
			while( $row = $rs->sql_fetchrow(DB_ASSOC) )
			{
				if ( preg_match("#\b(" . str_replace("\*", ".*?", phpbb_preg_quote($row['word'], '#')) . ")\b#i", $username) )
				{
					$observer->set('error.title', 'Username Error');
					$observer->set('error.message', 'Your username contains invalid characters.');
					return FALSE;
				}
			}
		
		
		return TRUE;
	}//end of function
	
} //end of class

?>