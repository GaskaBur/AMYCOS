<?php

class ExcellController {

	
	public function create()
	{
		$q = $_GET['q'];
		$n = $_GET['n'];
		CreateExcell::create($q,$n);
	}

		

}

?>