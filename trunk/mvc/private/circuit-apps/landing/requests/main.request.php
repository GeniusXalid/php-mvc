<?php

  class Landing_Main_CircuitRequest extends CircuitRequest{
	  public function load(){	
	  }

     public function selectAction(){
        return 'Landing.Land';
	 }

	 public function selectView()
	 {
        return 'Landing.Land';
	 }
  }

?>