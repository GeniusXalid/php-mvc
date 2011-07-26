<?

class Default_Location_CircuitModel extends CircuitModel{

	public function load($id){

		// we only want to show users to teleport to friends if their friend is in a flash space or forums
		$allowed_teleportations = array('in forums',
                                        'in towns',
                                        'in vj',
                                        'in mtv the hills',
										'in prom',
                                        'in zomg',
                                        'in rally',
                                        'in jigsaw',
                                        'in fishing',
                                        'in slots',
                                        'in cards',
                                        'in word bump',
                                        'in pinball',
                                        'in cinema',
                                        'in kung-fu panda',
										'in cinema 2 theater',
										'in electric love factory'
                                        );

		$allowed_arenas = array('/arenas/art/',
                                        '/arenas/writing/',
                                        '/arenas/gaia/'
                                        );


		// if you don't have id, just return landing
		$location = 'http://' . $_SERVER['HTTP_HOST'];


		// run this block if user id is set
		if (!empty($id)) {
			// get location from usermanager
			$location = UserManager::instance()->getUserLocation($id);

			// check if location is allowed
			if (in_array(strtolower($location['title']), $allowed_teleportations)
				||  strpos($location['url'], '/arena/') !== FALSE
				||  strpos($location['url'], '/launch/zomg') !== FALSE ||  strpos($location['url'], '/marketplace/itemdetail/') !== FALSE) {

				// if found arena
				if ( strpos($location['url'], '/arena/') !== FALSE) {
					//check if matches any of the following
					if ( strpos($location['url'], '/arena/art/') !== FALSE || strpos($location['url'], '/arena/writing/') !== FALSE || strpos($location['url'], '/arena/gaia/') !== FALSE ) {}
					else {
						$location['url'] = '/arena/';
					}
				}


				$location = $location['url'];
				$location = str_replace(MAIN_SERVER, $_SERVER['HTTP_HOST'], $location);
				$location = str_replace("settabcookie/", '', $location);

				// for security reasons, we do not want to expose our dev domains
				// usermanager should have given a better URL output
				$location = preg_replace('/http:\/\/(.)+\.'.DN.'\.'.TLD.'/i', 'http://'.$_SERVER['HTTP_HOST'], $location);
			}
			else {
				// if location is not permitted
				$location = 'http://' . $_SERVER['HTTP_HOST'];
			}
		}

		$this->set( $id, $location);
	}
}

?>