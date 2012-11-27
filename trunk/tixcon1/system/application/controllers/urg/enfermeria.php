<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Enfermeria
 *Tipo: controlador
 *Descripcion: Gestiona la atención inicial del personal de enfermeria
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 04 de marzo de 2011
*/
class Enfermeria extends Controller
{
//////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('urg/enfermeria_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 	
	}
///////////////////////////////////////////////////////////////////
/*
* Listado pacientes por servicio de la atención inicial de urgencias
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110304
* @version		20110304
*/		
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_enferSalas', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Listado pacientes en el servicio seleccionado
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110304
* @version		20110304
* @return		HTLM
*/	
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
		
		$d['lista'] = $this -> enfermeria_model -> obtenerPacientesSala($id_servicio);
		//----------------------------------------------------------
		$this -> load -> view('urg/urg_enferSalasDetalle',$d);
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Gestión de la atención de un paciente por parte del personal de enfermería
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110304
* @version		20110304
* @return		HTLM
*/
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('urg/enfermeria/index');
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_enferGestionAtencion', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
/*
* Consulta TRIAGE enfermería
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110307
* @version		20110307
*/	
	function consultaTriage($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('urg/enfermeria/main/'.$id_atencion);
		//----------------------------------------------------------
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_gesConTriage',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
/*
* Consulta Atención inicial enfermería
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110307
* @version		20110307
*/	
	function consultaAtencion($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('urg/enfermeria/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['consulta_ant'] = $this -> urgencias_model -> obtenerConsulta_ant($d['consulta']['id_consulta']);
		$d['consulta_exa'] = $this -> urgencias_model -> obtenerConsulta_exa($d['consulta']['id_consulta']);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['consulta']['id_medico']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_gesConAtencion',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con el formato de ingreso de la orden de insumos médicos
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110512
* @version		20110512
*/	
	function consultarOrdenes($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['urlRegresar'] 	= site_url('urg/enfermeria/main/'.$id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ordenes'] = $this -> urgencias_model -> obtenerOrdenes($id_atencion);
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hce/ordenesListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function consultarOrden($id_orden)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['orden'] = $this->urgencias_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
    $d['urlRegresar']   = site_url('urg/enfermeria/consultarOrdenes/'.$id_atencion);
    $d['ordenDietas'] = $this -> urgencias_model -> obtenerDietasOrden($id_orden);
    $d['ordenMedi'] = $this -> urgencias_model -> obtenerMediOrden($id_orden);
    $d['ordenCups'] = $this -> urgencias_model -> obtenerCupsOrden($id_orden);
    $d['ordenCupsLaboratorios'] = $this -> urgencias_model -> obtenerCupsLaboratorios($id_orden);
    $d['ordenCupsImagenes'] = $this -> urgencias_model -> obtenerCupsImagenes($id_orden);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['dietas'] = $this -> urgencias_model -> obtenerDietas();
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
    $d['ordenCuid'] = $this -> urgencias_model -> obtenerCuidadosOrden($id_orden);
    $d['ordenInsumos'] = $this -> urgencias_model -> obtenerOrdenInsumos($id_orden);
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('urg/urg_ordConsultar', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
}
?>
