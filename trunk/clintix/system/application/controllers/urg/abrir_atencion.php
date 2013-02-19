<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Reingreso de un paciente al servicio de urgencias
 *Tipo: Controlador
 *Descripcion:Permite efectuar el reingreso de un paciente en el servicio de urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 30 de mayo de 2011
*/
class Abrir_atencion extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model');
		$this -> load -> model('core/usuario');
		$this -> load -> model('hce/hce_model'); 	 	 		
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
function main($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['urlRegresar'] 	= site_url('urg/salas/index');
	//----------------------------------------------------------
	$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
	
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	$uid = $this -> session -> userdata('id_usuario');
	$d['usuario'] = $this -> usuario -> obtener($uid);
	
	$id_servicio = $d['atencion']['id_servicio'];
	if($id_servicio >= 11 && $id_servicio <= 15){
		$d['id_estado'] = 4;
	}else if($id_servicio >= 16 && $id_servicio <= 19){
		$d['id_estado'] = 5;
	}
		
	
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('urg/urg_abrirAtencion', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function abrirAtencion()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['id_atencion'] = $this->input->post('id_atencion');
	$d['id_estado'] = $this->input->post('id_estado');
	$d['id_atencion'] = $this->input->post('id_atencion');
	$d['motivo'] = mb_strtoupper($this->input->post('motivo'),'utf-8');
	$password = $this->input->post('password');
	$id_usuario = $this -> session -> userdata('id_usuario');
	$obs = $this ->hce_model -> obtenerObservacion($d['id_atencion']);
	$atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
	$d['fecha_egreso'] = $atencion['fecha_egreso'];
	if($obs != 0){
		$epicrisis = $this -> urgencias_model -> obtenerEpicrisis($d['id_atencion']);
		$d['id_medico'] = $epicrisis['id_medico'];
	}else{
		
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($atencion['id_usuario']);
	}
	if($this->usuario->validarPassword($id_usuario,$password)){
		$this->urgencias_model->abrirAtencionDb($d);
		
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'urg',__CLASS__,__FUNCTION__
			,'aplicacion',"Se ha realizado la apertura de la atencion ".$d['id_atencion']);

		$dt['mensaje']  = "Se ha realizado exitosamente la operación!!";
    	$dt['urlRegresar']  = site_url("core/home");
    	$this -> load -> view('core/presentacionMensaje', $dt);
    	return; 
	}else{
		$dt['mensaje']  = "La operación no se ha realizado\\nContraseña de verificación incorrecta!!";
    	$dt['urlRegresar']  = site_url("urg/abrir_atencion/main/".$d['id_atencion']);
    	$this -> load -> view('core/presentacionMensaje', $dt);
    	return; 
	}
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
}
?>
