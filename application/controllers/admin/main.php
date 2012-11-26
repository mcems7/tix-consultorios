<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Main
 *Tipo: controlador
 *Descripcion: Permite realizar la gestión administrativa de los pacientes
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 20 de agosto de 2011
*/
class Main extends CI_Controller
{  
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('admin/admin_model');
		$this -> load -> model('urg/urgencias_model');	
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 
	}
///////////////////////////////////////////////////////////////////
/*
* Servicios hospitalarios
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110820
* @version		20110820
*/
function index()
{
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('admin/admin_servicios', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Listado de pacientes por servicio
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110820
* @version		20110820
*/
function listadoPacientesServicio()
{	
	//----------------------------------------------------------
	$id_servicio 	= $this->input->post('id_servicio');
	
	if($id_servicio == 0){
			$id_servicio = $this->session->userdata('id_servicioAdmin');
	}else{
	
		$this->session->unset_userdata('id_servicioAdmin');
		$this->session->set_userdata('id_servicioAdmin',$id_servicio);
	}
	$d['camas'] = $this -> admin_model -> obtenerCamasServicio($id_servicio);
	//----------------------------------------------------------
	$this -> load -> view('admin/admin_servicioDetalle',$d);
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Gestión administrativa de la atención
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110820
* @version		20110820
*/
function gestion_atencion($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('admin/main/index');
	//----------------------------------------------------------
	$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
	$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
	$d['observacion'] = $this -> urgencias_model -> obtenerObservacionAtencion($id_atencion);
	$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['observacion']['id_medico_remite']);
	$d['dxCon'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['dxEvo'] = $this -> urgencias_model ->obtenerDxEvoluciones($id_atencion);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('admin/admin_gestionAtencion', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------		
}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>
