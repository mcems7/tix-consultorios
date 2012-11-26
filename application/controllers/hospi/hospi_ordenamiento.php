<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hospi_ordenamiento
 *Tipo: controlador
 *Descripcion: Permite la gestion de ordenes medicas
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 10 de marzo de 2012
*/
class Hospi_ordenamiento extends CI_Controller
{
///////////////////////////////////////////////////////////////////
function __construct()
{
	parent::__construct();			
	$this->load->model('urg/urgencias_model');
	$this->load->model('hospi/hospi_model');
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
* @since		20120310
* @version		20120310
*/	
function main($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hospi/hospi_gestion_atencion/main/'.$id_atencion);
	//----------------------------------------------------------
	$d['id_atencion'] = $id_atencion;
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);	
	$d['ordenes'] = $this->hospi_model->obtenerOrdenes($id_atencion);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_ord_listado', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Crear una nueva orden de insumos médicos
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120311
* @version		20120311
*/	
function crearOrden($id_atencion)
{
	//---------------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hospi/hospi_ordenamiento/main/'.$id_atencion);
	//---------------------------------------------------------------
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	//---------------------------------------------------------------
	$d['med']['vias'] = $this->urgencias_model->obtenerVarMedi('vias');
	$d['med']['unidades'] = $this->urgencias_model->obtenerVarMedi('unidades');
	$d['med']['frecuencia'] = $this->urgencias_model->obtenerVarMedi('frecuencia');
	$d['cuidados'] = $this->urgencias_model->obtenerCuidadosE();
	$d['tipo_cups'] = $this->urgencias_model->obtenerTiposCupsUrg(); 
	$d['dietas'] = $this->urgencias_model->obtenerDietas();
	$d['o2'] = $this->urgencias_model->obtenerOxigeno();
	//---------------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this ->load->view('hospi/hospi_piso_ord_crear', $d);
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
* @since		20120311
* @version		20120311
*/		
function crearOrden_()
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['id_atencion'] = $this->input->post('id_atencion');
	$d['id_medico'] = $this->input->post('id_medico');
	$d['id_dieta'] = $this->input->post('id_dieta');
	$d['cama_cabeza'] = $this->input->post('cama_cabeza');
	$d['cama_pie'] = $this->input->post('cama_pie');
	$d['oxigeno'] = $this->input->post('oxigeno');
	$d['id_oxigeno'] = $this->input->post('id_oxigeno');
	$d['id_oxigeno_valor'] = $this->input->post('id_oxigeno_valor');
	$d['liquidos'] = $this->input->post('liquidos');
	$d['id_cuidado'] = $this->input->post('id_cuidado_');
	$d['frecuencia_cuidado'] = $this->input->post('frecuencia_cuidado_');
	$d['id_frecuencia_cuidado'] = $this->input->post('id_frecuencia_cuidado_');
	$d['cuidados_generales'] = mb_strtoupper($this->input->post('cuidados_generales'),'utf-8');
	
	$d['id'] = $this->input->post('id_');
	$d['atc'] = $this->input->post('atc_');
	$d['dosis'] = $this->input->post('dosis_');
	$d['id_unidad'] = $this->input->post('id_unidad_');
	$d['frecuencia'] = $this->input->post('frecuencia_');
	$d['id_frecuencia'] = $this->input->post('id_frecuencia_');
	$d['id_via'] = $this->input->post('id_via_');
	$d['pos'] = $this->input->post('pos_');
	$d['observacionesMed'] 	= $this->input->post('observacionesMed_');
	$d['bandera'] 	= $this->input->post('bandera');
	$d['cups'] 	= $this->input->post('cups_');
	$d['observacionesCups'] 	=$this->input->post('observacionesCups_');
	$d['cantidadCups'] 	= $this->input->post('cantidadCups_');
	$d['fecha_ini_ord'] 	= $this->input->post('fecha_ini_ord');
	$d['id_servicio'] = $this->input->post('id_servicio');
	//----------------------------------------------------------
	$cont = 0;
	$n = count($d['pos']);
	for($i=0;$i<$n;$i++)
	{
		if($d['pos'][$i] == 'NO')
			$cont++;
	}
	//----------------------------------------------------------
	$r = $this->hospi_model->crearOrdenDb($d);
	if($r['error'])
	{
		$this->Registro->agregar($this->session->userdata('id_usuario'),'hospi',__CLASS__,__FUNCTION__
		,'aplicacion',"Error en la creación de la orden en la atencion".$d['id_atencion']);
		$dat['mensaje'] = "La operación no se realio con exito.";
		$dat['urlRegresar'] = site_url('hospi/hospi_ordenamiento/main/'.$d['id_atencion']);
		$this->load->view('core/presentacionMensaje', $dat);
		return;
	}
	//----------------------------------------------------
	if($cont > 0){
		redirect('hospi/hospi_ordenamiento/formatoNoPos/'.$r['id_orden']);		
	}else{
		$dt['mensaje']  = "La orden médica ha sido almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("hospi/hospi_ordenamiento/main/".$d['id_atencion']);
		$this->load->view('core/presentacionMensaje', $dt);
		return;
	}
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Crear una nueva orden basada en el tratamiento anterior
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120311
* @version		20120311
*/
function crearOrdenEdit($id_atencion)
{
	//---------------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hospi/hospi_ordenamiento/main/'.$id_atencion);
	//---------------------------------------------------------------
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	//---------------------------------------------------------------
	$d['med']['vias'] = $this->urgencias_model->obtenerVarMedi('vias');
	$d['med']['unidades'] = $this->urgencias_model->obtenerVarMedi('unidades');
	$d['med']['frecuencia'] = $this->urgencias_model->obtenerVarMedi('frecuencia');
	//---------------------------------------------------------------
	$d['cuidados'] = $this->urgencias_model->obtenerCuidadosE();
	$d['dietas'] = $this->urgencias_model->obtenerDietas();
	$d['o2'] = $this->urgencias_model->obtenerOxigeno();
	$d['tipo_cups'] = $this->urgencias_model->obtenerTiposCupsUrgGine();
	//---------------------------------------------------------------
	$d['orden'] = $this->hospi_model->obtenerUltOrden($id_atencion);
	$d['id_oxigeno_valor'] = $this->urgencias_model->obtenerTipoOxigeno($d['orden']['id_tipo_oxigeno']);
	$d['ordenDietas'] = $this->hospi_model->obtenerDietasOrden($d['orden']['id_orden']);
	$d['ordenCuid'] = $this->hospi_model->obtenerCuidadosOrden($d['orden']['id_orden']);
	$d['ordenMedi'] = $this->hospi_model->obtenerMediOrdenNueva($d['orden']['id_orden']);
	$d['ordenCups'] = $this->hospi_model->obtenerCupsOrden($d['orden']['id_orden']);
	$d['ordenCupsLaboratorios'] = $this->hospi_model->obtenerCupsLaboratorios($d['orden']['id_orden']);
	$d['ordenCupsImagenes'] = $this->hospi_model->obtenerCupsImagenes($d['orden']['id_orden']);
	//---------------------------------------------------------------
	// Calculo de tiempo para orden totalmente nueva;
	$fecha_ord = explode(" ", $d['orden']['fecha_creacion']);
	list($anno, $mes, $dia) = explode( '-', $fecha_ord[0] );
	list($hora, $min, $seg)= explode( ':', $fecha_ord[1] );
	$fecha_orden = mktime( $hora , $min , $seg , $mes , $dia , $anno );
	$hora_limite = mktime('6','00' ,'00' ,date('m'),date('d'),date('Y'));
	$fecha = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
	
	
	if($fecha >= $hora_limite){
		if($hora_limite >= $fecha_orden){
			$d['bandera'] = 'Nuevo';
		}else{
			$d['bandera'] = 'Continua';
		}
	}else{
		$d['bandera'] = 'Continua';
	}

	//---------------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_ord_crear_edit', $d);
	$this->load->view('core/core_fin');	
	//---------------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Consultar una orden medica
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120311
* @version		20120311
*/
function consultarOrden($id_orden)
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['orden'] = $this->hospi_model->obtenerOrden($id_orden);
	$d['id_oxigeno_valor'] = $this->urgencias_model->obtenerTipoOxigeno($d['orden']['id_tipo_oxigeno']);
	$d['ordenDietas'] = $this->hospi_model->obtenerDietasOrden($d['orden']['id_orden']);
	$d['ordenCuid'] = $this->hospi_model->obtenerCuidadosOrden($d['orden']['id_orden']);
	$d['ordenMedi'] = $this->hospi_model->obtenerMediOrdenNueva($d['orden']['id_orden']);
	$d['ordenCups'] = $this->hospi_model->obtenerCupsOrden($d['orden']['id_orden']);
	$d['ordenCupsLaboratorios'] = $this->hospi_model->obtenerCupsLaboratorios($d['orden']['id_orden']);
	$d['ordenCupsImagenes'] = $this->hospi_model->obtenerCupsImagenes($d['orden']['id_orden']);  
	$id_atencion = $d['orden']['id_atencion'];
	$d['urlRegresar']   = site_url('hospi/hospi_ordenamiento/main/'.$id_atencion);
	
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['dietas'] = $this->urgencias_model->obtenerDietas();
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['orden']['id_medico']);
	$d['ordenCuid'] = $this->hospi_model->obtenerCuidadosOrden($id_orden);
	$d['ordenInsumos'] = $this->hospi_model->obtenerOrdenInsumos($id_orden);
	//---------------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_ord_consultar', $d);
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
