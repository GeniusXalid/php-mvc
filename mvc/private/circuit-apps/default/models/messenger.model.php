<?
// Circuit-App			Default 
// Model				Messenger 
// Description: 		Authoritative entry point to the Messenger object
// the messenger object queues up messages that can be consumed in the view
// Author:		   		darknrgy darknrgy@gaiaonline.com 
// Start Date:			03-07-2007 

require_once(DIR_CLASSES . '/messenger.php');

class Default_Messenger_CircuitModel extends CircuitModel{
     
	/** getMessenger
	 * obtain a handle to a messenger object and put it in local model data so it can later be consumed by the view
	 * @return (Messenger) $messenger
	 **/
    public function getMessenger(){
        if (!$this->exists('messenger')) $this->set('messenger', new Messenger());
        return $this->get('messenger');
	}
}