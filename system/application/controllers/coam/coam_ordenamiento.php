<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Coam_ordenamiento
 *Tipo: controlador
 *Descripcion: Permite la gestion de ordenes medicas consulta ambulatoria
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 09 de abril de 2012
*/
class Coam_ordenamiento extends Controller
{
///////////////////////////////////////////////////////////////////
function __construct()
{
	parent::Controller();			
	$this->load->model('urg/urgencias_model');
	$this->load->model('coam/coam_model');
	$this->load->model('core/paciente_model');
	$this->load->model('core/tercero_model');
}
///////////////////////////////////////////////////////////////////
/*
* Vista de gestion de ordenes medicas
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120409
* @version		20120409
*/	
function main($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('coam/coam_gestion_atencion/main/'.$id_atencion);
	//----------------------------------------------------------
	$d['id_atencion'] = $id_atencion;
	$d['atencion'] = $this->coam_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);	
	$d['ordenes'] = $this->coam_model->obtenerOrdenes($id_atencion);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_consulta_ord_listado', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Crear una nueva orden médica
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120409
* @version		20120409
*/	
function crearOrden($id_atencion)
{
	//---------------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('coam/coam_ordenamiento/main/'.$id_atencion);
	//---------------------------------------------------------------
	$d['atencion'] = $this->coam_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	//---------------------------------------------------------------
	$d['med']['vias'] = $this->urgencias_model->obtenerVarMedi('vias');
	$d['med']['unidades'] = $this->urgencias_model->obtenerVarMedi('unidades');
	$d['med']['frecuencia'] = $this->urgencias_model->obtenerVarMedi('frecuencia');
	//---------------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this ->load->view('coam/coam_consulta_ord_crear', $d);
	$this->load->view('core/core_fin');	
	//---------------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Crear una nueva orden de insumos médicos
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120409
* @version		20120409
*/		
function crearOrden_()
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['id_atencion'] = $this->input->post('id_atencion');
	$d['id_medico'] = $this->input->post('id_medico');
	
	$d['id'] = $this->input->post('id_');
	$d['atc'] = $this->input->post('atc_');
	$d['dosis'] = $this->input->post('dosis_');
	$d['id_unidad'] = $this->input->post('id_unidad_');
	$d['frecuencia'] = $this->input->post('frecuencia_');
	$d['id_frecuencia'] = $this->input->post('id_frecuencia_');
	$d['id_via'] = $this->input->post('id_via_');
	$d['pos'] = $this->input->post('pos_');
	$d['observacionesMed'] 	= $this->input->post('observacionesMed_');
	$d['cups'] 	= $this->input->post('cups_');
	$d['observacionesCups'] 	=$this->input->post('observacionesCups_');
	$d['cantidadCups'] 	= $this->input->post('cantidadCups_');
	$d['fecha_ini_ord'] 	= $this->input->post('fecha_ini_ord');
	//----------------------------------------------------------
	$cont = 0;
	$n = count($d['pos']);
	for($i=0;$i<$n;$i++)
	{
		if($d['pos'][$i] == 'NO')
			$cont++;
	}
	//----------------------------------------------------------
	$r = $this->coam_model->crearOrdenDb($d);
	if($r['error'])
	{
		$this->Registro->agregar($this->session->userdata('id_usuario'),'coam',__CLASS__,__FUNCTION__
		,'aplicacion',"Error en la creación de la orden en la atencion".$d['id_atencion']);
		$dat['mensaje'] = "La operación no se realio con exito.";
		$dat['urlRegresar'] = site_url('coam/coam_ordenamiento/main/'.$d['id_atencion']);
		$this->load->view('core/presentacionMensaje', $dat);
		return;
	}
	//----------------------------------------------------
	if($cont > 0){
		redirect('coam/coam_ordenamiento/formatoNoPos/'.$r['id_orden']);		
	}else{
		$dt['mensaje']  = "La orden médica ha sido almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("coam/coam_ordenamiento/consultarOrden/".$r['id_orden']);
		$this->load->view('core/presentacionMensaje', $dt);
		return;
	}
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Consultar una orden medica
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120411
* @version		20120411
*/
function consultarOrden($id_orden)
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['orden'] = $this->coam_model->obtenerOrden($id_orden);
	$d['ordenMedi'] = $this->coam_model->obtenerMediOrden($d['orden']['id_orden']);
	$d['ordenCups'] = $this->coam_model->obtenerCupsOrden($d['orden']['id_orden']);
	$id_atencion = $d['orden']['id_atencion'];
	$d['urlRegresar']   = site_url('coam/coam_ordenamiento/main/'.$id_atencion);
	
	$d['atencion'] = $this->coam_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['orden']['id_medico']);
	//---------------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_consulta_ord_consultar', $d);
	$this->load->view('core/core_fin'); 
	//---------------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
	function formatoNoPos($id_orden)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['orden'] = $this->urgencias_model->obtenerOrden($id_orden);
		$id_atencion = $d['orden']['id_atencion'];
		$d['ordenMedi'] = $this->urgencias_model->obtenerMediOrdenNoPos($id_orden);
		$d['atencion'] = $this->urgencias_model->obtenerAtencion($id_atencion);
		$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
		$d['medico'] = $this->urgencias_model->obtenerMedico($d['orden']['id_medico']);
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this->load->view('urg/urg_ordNoPos', $d);
		$this->load->view('core/core_fin'); 
		//---------------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function agregarPosSustituto()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$cont   = $this->input->post('cont');
		$d['atc_pos']   = $this->input->post($cont.'atc_pos');		
		$d['atcNoPos']   = $this->input->post($cont.'atcNoPos');
		$d['dias_tratamientoPos']   = $this->input->post($cont.'dias_tratamientoPos');
		$d['dosis_diariaPos']   = $this->input->post($cont.'dosis_diariaPos');
		$d['cantidad_mes']   = $this->input->post($cont.'cantidad_mes');
		$d['resp_clinica']   = $this->input->post($cont.'resp_clinica');
		$d['resp_clinica_cual']   = $this->input->post($cont.'resp_clinica_cual');
		$d['contraindicacion']   = $this->input->post($cont.'contraindicacion');
		$d['contraindicacion_cual']   = $this->input->post($cont.'contraindicacion_cual');
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc_pos']);
		$this->load->view('urg/urg_ordInfoMedicamentoNoPos', $d);
		//--------------------------------------------------------------- 
	}
///////////////////////////////////////////////////////////////////	
	function formatoNoPos_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_atencion']   = $this->input->post('id_atencion');
		$d['id_orden']   = $this->input->post('id_orden');
		$d['atcNoPos']   = $this->input->post('atcNoPos');
		$d['resumen_historia']   = $this->input->post('resumen_historia');
		$d['dias_tratamiento']   = $this->input->post('dias_tratamiento');
		$d['dosis_diaria']   = $this->input->post('dosis_diaria');
		$d['cantidad_mes']   = $this->input->post('cantidad_mes');
		$d['ventajas']   = $this->input->post('ventajas');
		
		$d['atc_pos']   = $this->input->post('atc_pos_');
		$d['atcNoPosSus']   = $this->input->post('atcNoPos_');
		$d['dias_tratamientoPos']   = $this->input->post('dias_tratamientoPos_');
		$d['dosis_diariaPos']   = $this->input->post('dosis_diariaPos_');
		$d['cantidad_mesPos']   = $this->input->post('cantidad_mesPos_');
		$d['resp_clinica']   = $this->input->post('resp_clinica_');
		$d['resp_clinica_cual']   = $this->input->post('resp_clinica_cual_');
		$d['contraindicacion']   = $this->input->post('contraindicacion_');
		$d['contraindicacion_cual']   = $this->input->post('contraindicacion_cual_');
		//--------------------------------------------------------------- 
		$this->urgencias_model->formatoNoPosDb($d);
		//---------------------------------------------------------------
		redirect("urg/ordenamiento/main/".$d['id_atencion']);
	}
///////////////////////////////////////////////////////////////////
}
?>
