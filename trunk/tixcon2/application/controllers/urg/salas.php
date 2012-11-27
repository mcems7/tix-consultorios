<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Salas
 *Tipo: controlador
 *Descripcion: Gestiona la atención de los pacientes en cada una de las salas de espera
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 01 de septiembre de 2010
*/
class Salas extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model');
		$this->load->library('session');	 		
	}
///////////////////////////////////////////////////////////////////
/*
* Pantalla principal con listado de salas de espera
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100901
* @version		20100901
*/	
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load-> view('urg/urg_salaUrgencias', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function listadoPacientesSala()
	{
		//----------------------------------------------------------
		$id_servicio 	= $this->input->post('id_servicio');
		
		if($id_servicio == 0){
				$id_servicio = $this->session->userdata('id_servicio');
		}else{
		
			$this->session->unset_userdata('id_servicio');
			$this->session->set_userdata('id_servicio',$id_servicio);
		}
		
		$d['lista'] = $this -> urgencias_model -> obtenerPacientesSala($id_servicio);
		
		//----------------------------------------------------------
		$this -> load -> view('urg/urg_salasDetalle',$d);
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
}
?>
