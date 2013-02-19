<?php

class Cambios_cita extends Controller
{
	function __construct()
  {
    parent::Controller(); 
    $this->load->model('citas/citas_model');
    $this->load->helper('array');
    $this->load->helper('intervalos');
    $this->load->helper('url');
    $this->load->helper('date');
    $this->load->helper('array');
    $this->load->helper('datos_listas');
    $this->load->helper('intervalos');
	
  }
////////////////////////////////////////////////////////////////////////////////
//

	function index()
	{
	     $d = array();
     $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+
     //----------------------------------------------------------
   
    $this->load->view('core/core_inicio');
    $this -> load -> view('citas/cambio_cita_entidad');
    $this->load->view('core/core_fin');
	
	}


	function buscar()
    {
        $d = array();    //--------------------------------------------------------------------------
    $d['urlRegresar'] 	= site_url('core/home/index');	
    //--------------------------------------------------------------------------		
    $d['pin']                   = $this->input->post('pin2');
    $d['citas']                 = $this->citas_model->buscar_cita_modificar($d);
	$d['entidades_remision'] = $this -> citas_model -> obtenerEntidadesRemision();
    $this->load->view('citas/cita_modificar_entidad',$d);
    }
	
    function modificar_entidad()
    {
        $d = array();
    //--------------------------------------------------------------------------
    $d['urlRegresar'] 	= site_url('core/home/index');	
    //--------------------------------------------------------------------------		
    $d['pin'] = $this->input->post('pin');
	$d['id_entidad'] = $this->input->post('id_entidad');
	
	$this->citas_model->cambiar_entidad_cita($d);
	
	
	
    $d['citas'] = $this->citas_model->buscar_cita_modificar($d);
	$d['entidades_remision'] = $this -> citas_model -> obtenerEntidadesRemision();
    $this->load->view('citas/cita_modificar_entidad',$d);
    }

}



?>