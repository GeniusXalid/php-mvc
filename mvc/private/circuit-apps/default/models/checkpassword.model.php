<?
// Circuit-App			Default 
// Model				CheckPassword 
// Description: 		Check user's password from a form to confirm their identity
// Author:		   		darknrgy darknrgy@gaiaonline.com 
// Start Date:			03-07-2007 

class Default_CheckPassword_CircuitModel extends CircuitModel{

	/** setMessenger
	 * set a reference to messenger object
	 * @param Default_Messenger_CircuitModel $messenger
	 **/
    function setMessenger($messenger){  $this->messenger = $messenger; }


	/** execute
	 * check the password the user provided against their userdata and set an error if it is not correct
	 * @param $password
	 * @return true/false on correct password
	 **/
    function execute($password){
        
        if ($this->encryptPassword($password) != SC::get('userdata.user_password')) {
            
			if( $this->messenger) {
				$this->messenger->addMessage("The password you entered does not match our records. Please try again.");
			}
			
            $this->set('nopassword', true);
            return false;
		}
        
        return true;
	}
    
    /** encryptPassword
    * authrotative method for encrypting password so that special chars work
    * stolen from account manager *steal steal*
    **/
    protected function encryptPassword($v)
	{
		return md5(addslashes(trim(stripslashes($v))));
	}
}