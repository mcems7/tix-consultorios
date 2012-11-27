<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: Far_hospi
 *Tipo: controlador
 *Descripcion: Permite despachar medicamentos  e insumos ordenados
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 16 de marzo de 2012
*/
class Far_hospi extends CI_Controller
{
///////////////////////////////////////////////////////////////////
function __construct()
{
	parent::__construct();     
	$this->load->model('far/farmacia_model'); 
	$this->load->model('hospi/hospi_model'); 
	$this->load->model('urg/urgencias_model'); 
	$this->load->model('core/paciente_model');
}

///////////////////////////////////////////////////////////////////
function index()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar']   = site_url('core/home/index');
	$d['servicios'] = $this ->hospi_model->obtenerServicios();
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('far/far_medicamentosHospi', $d);
	$this->load->view('core/core_fin');
//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function listadoPacientesPiso()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$id_servicio  = $this->input->post('id_servicio');
	$id_estado  = $this->input->post('estado');
	$d['lista'] = $this->farmacia_model->obtenerPacientesMedicamentosHosp($id_servicio);
	//print_r($this->db->last_query());die();
	$this->load->view('far/far_medicamentosListadoHosp',$d);
	//----------------------------------------------------------
}
/////////////////////////////////////////////////////////////////

function consultarOrden($id_orden)
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['orden'] = $this->farmacia_model->obtenerOrdenHospi($id_orden);
	$id_atencion = $d['orden']['id_atencion'];
	$d['urlRegresar']   = site_url('far/far_hospi/index');
	$d['ordenMedi'] = $this->farmacia_model->obtenerMediOrdenHospi($id_orden);
	$d['ordenInsu'] = $this->farmacia_model-> obtenerInsumosOrdenHospi($id_orden);
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['orden']['id_medico']);
	$d['diagnostico'] = $this->farmacia_model->obtenerDxFarmaciaHospi($id_atencion);
	$d['cama'] = $this->farmacia_model->obtenerCamaFarmaciaHospi($id_atencion);
	//---------------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('far/far_ordConsultarHospi', $d);
	$this->load->view('core/core_fin'); 
	//---------------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function consultarOrdenHospi_()
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['id_orden'] = $this->input->post('id_orden');
	$d['atc'] = $this->input->post('atc');
	$d['idMed'] = $this->input->post('idMed');
	
	for($i=0;$i<count($d['idMed']);$i++){
	 $d['despachoMed'][$i] = $this->input->post('despachoMed'.$d['idMed'][$i]); 	
	}
	
	$d['cantidadMed'] = $this->input->post('cantidadMed');
	$d['atc_despa'] = $this->input->post('atc_despa');
	$d['observacionMed'] = $this->input->post('observacionMed');
	$d['idInsu'] = $this->input->post('idInsu');
	$d['id_insumo'] = $this->input->post('id_insumo');
	for($i=0;$i<count($d['idInsu']);$i++){
	 $d['despacho'][$i] = $this->input->post('despacho'.$d['idInsu'][$i]); 	
	}
	
	$d['cantidad_despachada'] = $this->input->post('cantidad_despachada');
	$d['obsDespacho'] = $this->input->post('observacion');
	$this->farmacia_model->despachoMedicamentosOrdenHospi($d);
	
	//----------------------------------------------------------
	$this->Registro->agregar($this->session->userdata('id_usuario'),'far',__CLASS__,__FUNCTION__
			,'aplicacion',"Se le han agregado insumos  hospi a la orden id ".$d['id_orden']);
	
	redirect('far/far_hospi/consultaOrdenDespachoHospi/'.$d['id_orden']);
}
/////////////////////////////////////////////////////	
function consultaOrdenDespachoHospi($id_orden)
{
	 //---------------------------------------------------------------
$d = array();
$d['id_orden'] = $id_orden;
//---------------------------------------------------------------
$d['orden'] = $this->farmacia_model->obtenerOrdenHospi($id_orden);
$id_atencion = $d['orden']['id_atencion'];
$d['urlRegresar']   = site_url('far/far_hospi/index');
$d['ordenMedi'] = $this->farmacia_model->obtenerMediOrdenDespaHospi($id_orden);
//print_r($this->db->last_query());
//die();
$d['ordenInsu'] = $this->farmacia_model-> obtenerInsumosOrdenHospi($id_orden);
$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
$d['tercero'] = $this->paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
$d['medico'] = $this->urgencias_model->obtenerMedico($d['orden']['id_medico']);
$d['diagnostico'] = $this->farmacia_model->obtenerDxFarmaciaHospi($id_atencion);
$d['cama'] = $this->farmacia_model->obtenerCamaFarmaciaHospi($id_atencion);
//print_r($d['atencion']);die();
//---------------------------------------------------------------
$this->load->view('core/core_inicio');
$this->load->view('far/far_ordConsultarDespHospi', $d);
$this->load->view('core/core_fin'); 
//---------------------------------------------------------------
}
/////////////////////////////////////////////////////
function historiaMedicamento($id_atencion,$atc)
{
	$d['lista'] = $this->farmacia_model->obtenerHistoMedica($id_atencion,$atc);
	$this->load->view('far/far_ordInfoHistoMedicamento', $d);
}
/////////////////////////////////////////////////////
function ordenesdespachadas()
{
	//---------------------------------------------------------------
	$d = array();
	$d['urlRegresar']   = site_url('core/home/index');
	//---------------------------------------------------------------
	$d['lista'] = $this->farmacia_model->obtenerOrdenesDespachadasHospi();
	$this->load->view('core/core_inicio');
	$this->load->view('far/far_medicamentosDespaSalas.php', $d);
	$this->load->view('core/core_fin'); 
	//---------------------------------------------------------------
}
/////////////////////////////////////////////////////	
function consultaOrdenDespachoCon($id_orden)
{
	//---------------------------------------------------------------
	$d = array();
	$d['id_orden'] = $id_orden;
	//---------------------------------------------------------------
	$d['orden'] = $this->farmacia_model->obtenerOrdenHospi($id_orden);
	$id_atencion = $d['orden']['id_atencion'];
	$d['urlRegresar']   = site_url('far/far_hospi/ordenesdespachadas');
	$d['ordenMedi'] = $this->farmacia_model->obtenerMediOrdenHospi($id_orden);
	$d['ordenInsu'] = $this->farmacia_model-> obtenerInsumosOrdenHospi($id_orden);
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['orden']['id_medico']);
	$d['diagnostico'] = $this->farmacia_model->obtenerDxFarmaciaHospi($id_atencion);
	$d['cama'] = $this->farmacia_model->obtenerCamaFarmaciaHospi($id_atencion);
	//---------------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('far/far_ordConsultarDesp', $d);
	$this->load->view('core/core_fin'); 
	//---------------------------------------------------------------
}

/////////////////////////////////////////////////////
}
?>
