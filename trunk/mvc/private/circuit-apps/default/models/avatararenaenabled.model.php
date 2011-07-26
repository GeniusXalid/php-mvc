<?php

/**
 * Make sure avatararena is not disabled.
 *
 * @param observer
 * @return bool    TRUE if the avatar arena section is enabled, else FALSE.
 */
class Default_AvatarArenaEnabled_CircuitModel
{
   /**
    * Execute the model
    * @param Container    The Observer object.
    * @return bool        TRUE if successful, else FALSE.
    * @access public
    */
    function execute( & $observer )
    {
        if( SC::isEmpty('board_config.avatararena_disable') ) return TRUE;
        $observer->set('error.code', GENERAL_MESSAGE);
        $observer->set('error.title', 'Arena Disabled');
        $observer->set('error.message', 'The avatar arena section of the site is currently disabled.');
        $observer->set('error.line', __LINE__);
        $observer->set('error.file', __FILE__);
        $observer->set('error.debug', backtrace() );
        return FALSE;
    }
 }
 
?>