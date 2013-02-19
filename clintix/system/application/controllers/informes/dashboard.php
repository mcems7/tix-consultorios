<?php
//error_reporting(0);
class Dashboard extends Controller {

	
	
	function index()
	{
		
	$this->load->view('core/core_inicio');
   
	$this -> load -> view('informes/informeUrgTriage');
	
    $this->load->view('core/core_fin');
		
	}
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */