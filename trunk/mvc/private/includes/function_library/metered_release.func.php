<?php
/**
 * Metered Release Script
 * Checks the URL against the current metered release scripts
 * and returns a boolean indicating if the user has access to
 * this item
 **/

define('METERED_RELEASE_MIGRATION_SIZE', 65536);

/**
 * Metered Release Function
 * Looks at the global site config, and determines if a user is
 * eligible to access a particular URL. This is used for metered
 * rollouts and page access.
 * @return bool
 **/
function FUNCLIB_metered_release($key, $incoming_key = NULL) {
//     $val = <<<HEREDOC
// 1 exactuser /community 0
// HEREDOC;
    // SC::set('board_config.metered_release', $val);

    if ($key == 'http://'.MAIN_SERVER.'/comingsoon' ||
        $key == '/comingsoon' ||
        $key == '/comingsoon/' ||
        $key == 'comingsoon') {
        return true;
    }

    // check for any metered value
    $meter = SC::get('board_config.metered_release');
    if (!$meter) {
        return true;
    }
    
    $meters = explode('#', $meter);
    foreach ($meters as $meter) {
        $meter = trim($meter);
        
        $m_pieces = explode(' ', $meter);
        if (!$m_pieces[3]) {
            $m_pieces[3] = 0;
        }
        list($threshold, $method, $regex, $offset) = $m_pieces;
        
        if (!$offset) {
            $offset = 0;
        }
        
        $regex = str_replace(array('*', '?'), array('.*', '\?'), $regex);
        if (!preg_match('#'.$regex.'#i', $key)) {
            continue;
        }
        
        switch ($method) {
            case 'session':
                if ($incoming_key) {
                    $value = $incoming_key + $offset;
                }
                else {
                    $data = session_cookie();
                    $value = hexdec(substr($data[1], 0, 4)) + $offset;
                }
                return (($value % METERED_RELEASE_MIGRATION_SIZE) < $threshold) ? true : false;
                
            case 'userid':
                if ($incoming_key) {
                    $value = $incoming_key + $offset;
                }
                else {
                    $data = session_cookie();
                    $user_id = $data[0];

                    // anon blocked
                    if ($user_id <= 0) {
                        return false;
                    }
                    $value = $user_id + $offset;
                }
                return (($value % METERED_RELEASE_MIGRATION_SIZE) < $threshold) ? true : false;
            
            case 'exactuser':
                if ($incoming_key) {
                    $user_id = $incoming_key;
                }
                else {
                    $data = session_cookie();
                    $user_id = $data[0];
                }
                
                // anon blocked
                if ($user_id <= 0) {
                    return false;
                }
                
                return ($user_id == $threshold) ? true : false;
        }
        
        // unknown method
        return false;
    }
    
    // didn't get denied
    return true;
}

?>