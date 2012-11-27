<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Main extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('urg/urgencias_model'); 		
		$this -> load -> helper( array('url','form') );
	}
	
///////////////////////////////////////////////////////////////////
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index'); //Asiognar al menu principal -+-+-+-+-+-+-+-+-+-+-+-
		//----------------------------------------------------------
		$d['categorias'] =  $this -> db_model_principal -> consultarCategorias();
		//----------------------------------------------------------
		$this->load->view('header_2');
		$this -> load -> view('db/db_adminArchivos', $d);
		$this -> load -> view('logos_mipyme');//logos de mipyme///////////////////////////////////////////
		$this->load->view('footer_2');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	
///////////////////////////////////////////////////////////////////
}
?>
