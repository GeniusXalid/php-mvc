<?

class Default_Gim_CircuitModel extends CircuitModel{

	public function load($id){
		
		// run this block if user id is set
		if (!empty($id)) {
			// get location from usermanager
			$gim = UserManager::instance()->lookupGimNames($id);
			$gim = $gim[$id]['im_name'];
			$this->set( $id, $gim);
		}
	}
}

?>