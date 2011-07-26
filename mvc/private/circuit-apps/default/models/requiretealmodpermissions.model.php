<?

//require to be teal and above 
// laine@gaiaonline.com

class Default_RequireTealModPermissions_CircuitModel
{
    function execute( & $observer )
    {
		
        if( SC::isEmpty('userdata.user_id') || ! require_level(USERLEVEL_GLOBALMOD)) 
        {
            $message = "This page is not available under the current configuration, or ";
            $message .= "you are not authorized to view this page.";
            $observer->set('error.message', $message);
            $observer->set('error.code', GENERAL_MESSAGE);
            $observer->set('error.title', 'Not Authorized');
            $observer->set('error.line', __LINE__);
            $observer->set('error.file', __FILE__);
            return FALSE;
        }
        return TRUE;
    }
}
?>