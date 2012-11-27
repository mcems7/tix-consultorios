<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: Insumos
 *Tipo: controlador
 *Descripcion: Permite gestionar el ordenamiento de insumos para el suministro de médicamentos
 *Autor: William Alberto Ospina Zapata <wospina@opuslibertati.org>
 *Fecha de creación: 05 de enero de 2011
*/
class Insumos extends Controller 
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('hce/hce_model');
		$this -> load -> model('urg/insumos_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model');
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con el formato de ingreso de la orden de insumos
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110502
* @version		20110502
*/
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load-> view('urg/urg_insuPrincipal', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////	
	function listadoOrdenesServicio()
	{
		
		//----------------------------------------------------------
		$id_servicio 	= $this->input->post('id_servicio');
		
		if($id_servicio == 0){
				$id_servicio = $this->session->userdata('id_servicio_insu');
		}else{
		
			$this->session->unset_userdata('id_servicio_insu');
			$this->session->set_userdata('id_servicio_insu',$id_servicio);
		}
		
		
		
		$d['lista'] = $this -> insumos_model -> obtenerOrdenesServicio($id_servicio);
		//print_r($this->db->last_query());die();
		//----------------------------------------------------------
		if($id_servicio == 16 || $id_servicio == 17 || $id_servicio == 18){
			$this -> load -> view('urg/urg_insuServicioObsDetalle',$d);
		}else{
			$this -> load -> view('urg/urg_insuServicioDetalle',$d);
		}
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
/*
* Vista con el formato de ingreso de la orden de insumos
*
* @author William Alberto Ospina Zapata <wospina@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110105
* @version		20110105
*/	
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		
		$id_serv = $d['atencion']['id_servicio'];
		if($id_serv == 16 || $id_serv == 17 || $id_serv == 18){
		$d['urlRegresar'] 	= site_url('urg/enfer_observacion/main/'.$id_atencion);
		}else{
		$d['urlRegresar'] 	= site_url('urg/enfermeria/main/'.$id_atencion);
		}
		
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);

		$d['ordenes'] = $this -> urgencias_model -> obtenerOrdenesInsumos($id_atencion,$d['atencion']['id_servicio']);
 
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_insListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}


function crearOrdenIns($id_orden)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['orden'] = $this->urgencias_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
    $d['urlRegresar']   = site_url('urg/insumos/index');
    $d['ordenDietas'] = $this -> urgencias_model -> obtenerDietasOrden($id_orden);
    $d['ordenMedi'] = $this -> urgencias_model -> obtenerMediOrdenInsu($id_orden);
    $d['ordenCups'] = $this -> urgencias_model -> obtenerCupsOrden($id_orden);
	$d['ordenCupsLab'] = $this -> urgencias_model -> obtenerCupsLaboratorios($id_orden);
	$d['ordenCupsImg'] = $this -> urgencias_model -> obtenerCupsImagenes($id_orden);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['dietas'] = $this -> urgencias_model -> obtenerDietas();
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
    $d['ordenCuid'] = $this -> urgencias_model -> obtenerCuidadosOrden($id_orden);
    $d['id_orden'] = $id_orden;
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('urg/urg_ordInsumosCrear', $d);
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
 
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
	$id_medico = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($id_medico);
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('urg/urg_ordInsumosCrearIndepe', $d);
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
		$atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
		$d['id_servicio'] 	= $atencion['id_servicio']; 
		$d['id_orden']  	= $this->input->post('id_orden');
		//----------------------------------------------------------
		$r = $this -> urgencias_model -> crearOrdenInsumosIndepeDb($d);
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'urg',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación de La orden de insumos médica en la ".$d['id_atencion']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('urg/insumos/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------
		$dt['mensaje']  = "La orden de insumos médica ha sido almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("urg/insumos/index");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
	function listaInsumos($l)
	{
		$l = preg_replace("/[^a-z0-9 ]/si","",$l);
		$this->load->database();
		$this->db->like('insumo',$l);
		$this->db->or_like('codigo_interno',$l);
		$r = $this->db->get('core_insumos');
		$dat = $r -> result_array();
		foreach($dat as $d)
		{
			echo $d["id_insumo"]."###".$d["codigo_interno"]." ".$d["insumo"]."|";
		}    
	}
///////////////////////////////////////////////////////////////////
	function agregarInsumo()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['cantidad'] = $this->input->post('cantidad');
		$d['observaciones'] = $this->input->post('observaciones');
		$d['id_insumo'] = $this->input->post('insumo_ID');
		$d['insumo'] = $this->urgencias_model->obtenerNomInsumo($d['id_insumo']);
		//echo "R".$d['id_insumo'];
		echo $this->load->view('urg/urg_ordInfoInsumos',$d);
		
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
		$atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
		$d['id_servicio'] 	= $atencion['id_servicio']; 
		$d['id_orden']  	= $this->input->post('id_orden');
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		//----------------------------------------------------------
		$r = $this -> urgencias_model -> crearOrdenInsumosDb($d);
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'urg',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación de La orden de insumos médica en la ".$d['id_atencion']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('urg/insumos/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------
		$dt['mensaje']  = "La orden de insumos médica ha sido almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("urg/insumos/index");
		$this -> load -> view('core/presentacionMensaje', $dt);
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
}
?>
