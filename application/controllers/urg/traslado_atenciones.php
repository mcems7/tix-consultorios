<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Traslado_atenciones
 *Tipo: Controlador
 *Descripcion: Traslado de una atención de un paciente a otro y unificación de historias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 18 de octubre de 2011
*/
class Traslado_atenciones extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();
		$this -> load -> model('hce/hce_model');	
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/usuario');		
		$this -> load -> model('core/Registro');  	 		
	}
///////////////////////////////////////////////////////////////////
/*
* Apertura de la atención
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110530
* @version		20110530
*/	
function index()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['urlRegresar'] 	= site_url('core/home/index');
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('urg/urg_trasladoHistoriaMain', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function buscar_atenciones_paciente()
{
//----------------------------------------------------------
	$d = array();
	
	$d['atencionesUrg'] = array();
	//----------------------------------------------------------
	$d['primer_apellido'] 	= $this->input->post('primer_apellido');
	$d['primer_nombre'] 	= $this->input->post('primer_nombre');
	$d['segundo_apellido'] 	= $this->input->post('segundo_apellido');
	$d['segundo_nombre'] 	= $this->input->post('segundo_nombre');
	$d['numero_documento'] 	= $this->input->post('numero_documento');	
	$d['atencionesUrg'] = $this ->hce_model->obtenerAtencionesUrgPacientes($d);
	echo $this->load->view('urg/urg_listadoPacientes',$d);	
}
///////////////////////////////////////////////////////////////////
function buscar_atenciones($id_paciente)
{	
	//----------------------------------------------------------
	$d = array();
	$d['atencionesUrg'] = array();
	$d['urlRegresar'] 	= site_url('hce/main/index');	
	$atenciones = $this ->hce_model -> obtenerAtencionesUrg($id_paciente);
	if($atenciones != 0){
		$d['atencionesUrg'] = $atenciones;
	}
	echo $this->load->view('urg/urg_trasladoListadoAtenciones',$d);
}
///////////////////////////////////////////////////////////////////
function trasladar_atencion($id_atencion,$operacion){
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['urlRegresar'] 	= site_url('urg/traslado_atenciones/index');
	//----------------------------------------------------------
	$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
	
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	$uid = $this -> session -> userdata('id_usuario');
	$d['usuario'] = $this -> usuario -> obtener($uid);
	$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
	$d['operacion'] = $operacion;
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('urg/urg_trasladoHistoria', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function buscar_paciente_traslado($numero_documento)
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['primer_apellido'] 	= '';
	$d['primer_nombre'] 	= '';
	$d['segundo_apellido'] 	= '';
	$d['segundo_nombre'] 	= '';
	$d['numero_documento'] 	= $numero_documento;
	$d['atencionesUrg'] = $this ->hce_model->obtenerAtencionesUrgPacientes($d);
	echo $this->load->view('urg/urg_trasladoInfoPac',$d);
	
}
///////////////////////////////////////////////////////////////////
function trasladar_atencion_()
{
	$d = array();
	$d['id_atencion'] 			= $this->input->post('id_atencion');
	$d['id_paciente_origen'] 	= $this->input->post('id_paciente_origen');
	$d['id_paciente_destino'] 	= $this->input->post('id_paciente_destino');
	$d['justificacion'] 		= $this->input->post('justificacion');
	$d['operacion'] 			= $this->input->post('operacion');
	$password = $this->input->post('password');
	$id_usuario = $this -> session -> userdata('id_usuario');
	if($this->usuario->validarPassword($id_usuario,$password)){
		
		$this->urgencias_model->trasladar_atencionDb($d);
		
		$borrar = $this->urgencias_model->borrarPacienteSinAtenciones($d['id_paciente_origen']);
		if($borrar){
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'urg',__CLASS__,__FUNCTION__
			,'aplicacion',"Se ha eliminado el paciente id ".$d['id_paciente_origen']);
		}

		$dt['mensaje']  = "Se ha realizado exitosamente la operación!!";
    	$dt['urlRegresar']  = site_url("core/home");
    	$this -> load -> view('core/presentacionMensaje', $dt);
    	return; 
	}else{
		$dt['mensaje']  = "La operación no se ha realizado\\nContraseña de verificación incorrecta!!";
    	$dt['urlRegresar']  = site_url("urg/traslado_atenciones/index");
    	$this -> load -> view('core/presentacionMensaje', $dt);
    	return; 
	}
	//----------------------------------------------------------
	
}
///////////////////////////////////////////////////////////////////
}
?>
