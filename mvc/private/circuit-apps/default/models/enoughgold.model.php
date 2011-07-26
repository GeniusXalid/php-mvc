<?
// Circuit-App			Default  
// Model			    ItemDetail  
// Description: 		Look up basic item data based on a list of ids. 
// Author:		   	 laine@gaiaonline.com
// Start Date:			03-07-2007 

//this model sees if the logged in user has enough gold versus a provided gold value
//use it if you want to see if a user has enough gold to buy something, for example.
class Default_EnoughGold_CircuitModel extends CircuitModel{

	//does the comparison 
	//ACCEPTS: (int) gold
	//RESULTS: returns true if user has >= gold amount provided
	//         returns false if user does not have enough gold
	public function execute( $gold, $messenger = false){
                	                
	        $gold = intval($gold);	        
                
                if( SC::get("userdata.user_gold") < $gold)
                {
                        if( $messenger)
                        $messenger->addMessage('You do not have enough gold. <a href="/info/gold">Click here to find out more about getting gold</a>.');
                        return FALSE;     
                }
                                        
                        
                return TRUE;
	}
	
}