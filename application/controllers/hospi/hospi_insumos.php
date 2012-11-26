<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: Hospi_insumos
 *Tipo: controlador
 *Descripcion: Permite gestionar el ordenamiento de insumos para el suministro de médicamentos hospitalizacion
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 11 de marzo de 2012
*/
class Hospi_insumos extends CI_Controller 
{
///////////////////////////////////////////////////////////////////
function __construct()
{
	parent::__construct();			
	$this->load->model('urg/urgencias_model');
	$this->load->model('hospi/hospi_model');
	$this->load->model('hospi/hospi_insumos_model');
	$this->load->model('core/paciente_model');
	$this->load->model('core/tercero_model');
}
///////////////////////////////////////////////////////////////////
/*
* Vista con el formato de ingreso de la orden de insumos
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120314
* @version		20120314
*/
function index()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	//----------------------------------------------------------
	$d['servicios'] = $this ->hospi_model->obtenerServicios();
	$this->load->view('core/core_inicio');
	$this->load-> view('hospi/hospi_piso_insu_principal', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////	
/*
* Vista con el formato de ingreso de la orden de insumos
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120314
* @version		20120314
*/
function listadoOrdenesServicio()
{
	//----------------------------------------------------------
	$id_servicio = $this->input->post('id_servicio');
	if($id_servicio == 0){
		$id_servicio = $this->session->userdata('id_servicio_insu_hosp');
	}else{
		$this->session->unset_userdata('id_servicio_insu_hosp');
		$this->session->set_userdata('id_servicio_insu_hosp',$id_servicio);
	}
	$d['lista'] = $this->hospi_insumos_model->obtenerOrdenesServicio($id_servicio);
	//----------------------------------------------------------
	$this->load->view('hospi/hospi_piso_insu_detalle',$d);
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Vista con el formato de ingreso de la orden de insumos
*
* @author William Alberto Ospina Zapata <wospina@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120314
* @version		20120314
*/	
function main($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['urlRegresar'] 	= site_url('hospi/hospi_enfermeria/main/'.$id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['ordenes'] = $this->urgencias_model->obtenerOrdenesInsumos($id_atencion,$d['atencion']['id_servicio']);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('urg/urg_insListado', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Vista con el formato de ingreso de la orden de insumos
*
* @author William Alberto Ospina Zapata <wospina@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120314
* @version		20120314
*/	
function crearOrdenIns($id_orden)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['orden'] = $this->hospi_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
    $d['urlRegresar']   = site_url('hospi/hospi_insumos/index');
    $d['ordenDietas'] = $this->hospi_model->obtenerDietasOrden($id_orden);
    $d['ordenMedi'] = $this->hospi_model->obtenerMediOrdenInsu($id_orden);
    $d['ordenCups'] = $this->hospi_model->obtenerCupsOrden($id_orden);
	$d['ordenCupsLab'] = $this->hospi_model->obtenerCupsLaboratorios($id_orden);
	$d['ordenCupsImg'] = $this->hospi_model->obtenerCupsImagenes($id_orden);
    $d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
    $d['dietas'] = $this->urgencias_model->obtenerDietas();
    $d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this->urgencias_model->obtenerMedico($d['orden']['id_medico']);
    $d['ordenCuid'] = $this->hospi_model->obtenerCuidadosOrden($id_orden);
    $d['id_orden'] = $id_orden;
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this->load->view('hospi/hospi_piso_insu_crear', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
	function crearOrdenInsumoIndepe($id_atencion)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['urlRegresar']   = site_url('urg/enfermeria/main/'.$id_atencion);
 
    $d['atencion'] = $this->urgencias_model->obtenerAtencion($id_atencion);
	$id_medico = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
    $d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this->urgencias_model->obtenerMedico($id_medico);
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this->load->view('urg/urg_ordInsumosCrearIndepe', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
  
  function crearOrdenInsumosIndepe_()
  {
	  //---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_atencion'] 	= $this->input->post('id_atencion');
		$d['id_medico'] 	= $this->input->post('id_medico');
		$d['codigo_insumo'] = $this->input->post('id_insumo_');
		$d['cantidad'] 		= $this->input->post('cantidad_');
		$d['observaciones'] = $this->input->post('observaciones_');
		$atencion = $this->urgencias_model->obtenerAtencion($d['id_atencion']);
		$d['id_servicio'] 	= $atencion['id_servicio']; 
		$d['id_orden']  	= $this->input->post('id_orden');
		//----------------------------------------------------------
		$r = $this->urgencias_model->crearOrdenInsumosIndepeDb($d);
		if($r['error'])
		{
			$this->Registro->agregar($this->session->userdata('id_usuario'),'urg',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación de La orden de insumos médica en la ".$d['id_atencion']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('urg/insumos/index');
			$this->load->view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------
		$dt['mensaje']  = "La orden de insumos médica ha sido almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("urg/insumos/index");
		$this->load->view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
	function listaInsumos($l)
	{
		$l = preg_replace("/[^a-z0-9 ]/si","",$l);
		$this->load->database();
		$this->db->like('insumo',$l);
		$r = $this->db->get('core_insumos');
		$dat = $r->result_array();
		foreach($dat as $d)
		{
			echo $d["id_insumo"]."###".$d["insumo"]."|";
		}    
	}
///////////////////////////////////////////////////////////////////
	function agregarInsumo()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['cantidad'] = $this->input->post('cantidad');
		$d['pagador'] = $this->input->post('pagador');
		$d['observaciones'] = $this->input->post('observaciones');
		$d['id_insumo'] = $this->input->post('insumo_ID');
		$d['insumo'] = $this->urgencias_model->obtenerNomInsumo($d['id_insumo']);
		echo $this->load->view('hospi/hospi_piso_insu_info_insumo',$d);
		
	}
///////////////////////////////////////////////////////////////////
	function crearOrdenInsumos_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_atencion'] 	= $this->input->post('id_atencion');
		$d['id_usuario'] 	= $this->input->post('id_medico');
		$d['codigo_insumo'] = $this->input->post('id_insumo_');
		$d['cantidad'] 		= $this->input->post('cantidad_');
		$d['observaciones'] = $this->input->post('observaciones_');
		$d['pagador'] 		= $this->input->post('pagador_');
		$atencion = $this->hospi_model->obtenerAtencion($d['id_atencion']);
		$d['id_servicio'] 	= $atencion['id_servicio']; 
		$d['id_orden']  	= $this->input->post('id_orden');
		$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
		//----------------------------------------------------------
		$r = $this->hospi_model->crearOrdenInsumosDb($d);
		if($r['error'])
		{
			$this->Registro->agregar($this->session->userdata('id_usuario'),'hospi',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación de La orden de insumos médica en la ".$d['id_atencion']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('hospi/hospi_insumos/index');
			$this->load->view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------
		$dt['mensaje']  = "La orden de insumos médica ha sido almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("hospi/hospi_insumos/index");
		$this->load->view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
		
	}
///////////////////////////////////////////////////////////////////
	function consultarOrdenInsumos($id_orden_insumos)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['orden'] = $this->urgencias_model->obtenerOrdenInsumosDetalle($id_orden_insumos);
	}
///////////////////////////////////////////////////////////////////
/*
* Asignar pagador a los cups ordenados
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120331
* @version		20120331
*/
function asignarPagadorCups($tipo,$id,$pagador)
{
	$res = $this->hospi_insumos_model->asignarPagadorCups($tipo,$id,$pagador);
	
	return $res;
}
///////////////////////////////////////////////////////////////////
}
?>
