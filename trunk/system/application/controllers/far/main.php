<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Main extends Controller
{
///////////////////////////////////////////////////////////////////
function __construct()
{
	parent::Controller();     
	$this -> load -> model('far/farmacia_model'); 
	$this -> load -> model('urg/urgencias_model'); 
	$this -> load -> model('core/paciente_model');
}

///////////////////////////////////////////////////////////////////
function index()
{
//----------------------------------------------------------
$d = array();
$d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+
//----------------------------------------------------------

$this->load->view('core/core_inicio');
$this -> load -> view('far/far_medicamentosSalas', $d);
$this->load->view('core/core_fin');
//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function listadoPacientesSala()
{

//----------------------------------------------------------
$id_servicio  = $this->input->post('salasMed');
$id_estado  = $this->input->post('estado');
$d['lista'] = $this -> farmacia_model -> obtenerPacientesMedicamentos($id_servicio);
$this -> load -> view('far/far_medicamentosListado',$d);
//----------------------------------------------------------
}
/////////////////////////////////////////////////////////////////

function consultarOrden($id_orden)
{
//---------------------------------------------------------------
$d = array();
//---------------------------------------------------------------
$d['orden'] = $this->farmacia_model->obtenerOrden($id_orden);
$id_atencion = $d['orden']['id_atencion'];
$d['urlRegresar']   = site_url('far/main/index');
$d['ordenMedi'] = $this -> farmacia_model -> obtenerMediOrden($id_orden);
$d['ordenInsu'] = $this->farmacia_model-> obtenerInsumosOrden($id_orden);
$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
$d['tercero'] = $this -> paciente_model ->obtenerTercero($d['paciente']['id_tercero']);

$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
$d['diagnostico'] = $this->farmacia_model->obtenerDxFarmacia($id_atencion);
$d['cama'] = $this->farmacia_model->obtenerCamaFarmacia($id_atencion);
//print_r($d['atencion']);die();
//---------------------------------------------------------------
$this->load->view('core/core_inicio');
$this -> load -> view('far/far_ordConsultar', $d);
$this->load->view('core/core_fin'); 
//---------------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function consultarOrden_()
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
$this->farmacia_model->despachoMedicamentosOrden($d);

//----------------------------------------------------------
$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'far',__CLASS__,__FUNCTION__
		,'aplicacion',"Se le han agregado insumos a la orden id ".$d['id_orden']);


/*//----------------------------------------------------------
$dt['mensaje']  = "Los datos se han almacenado correctamente!!";
$dt['urlRegresar'] 	= site_url("far/main/index");
$this -> load -> view('core/presentacionMensaje', $dt);
return;	
//----------------------------------------------------------*/

redirect('far/main/consultaOrdenDespacho/'.$d['id_orden']);
}
/////////////////////////////////////////////////////	
function consultaOrdenDespacho($id_orden)
{
	 //---------------------------------------------------------------
$d = array();
$d['id_orden'] = $id_orden;
//---------------------------------------------------------------
$d['orden'] = $this->farmacia_model->obtenerOrden($id_orden);
$id_atencion = $d['orden']['id_atencion'];
$d['urlRegresar']   = site_url('far/main/index');
$d['ordenMedi'] = $this -> farmacia_model -> obtenerMediOrdenDespa($id_orden);
//print_r($this->db->last_query());
//die();
$d['ordenInsu'] = $this->farmacia_model-> obtenerInsumosOrden($id_orden);
$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
$d['tercero'] = $this -> paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
$d['diagnostico'] = $this->farmacia_model->obtenerDxFarmacia($id_atencion);
$d['cama'] = $this->farmacia_model->obtenerCamaFarmacia($id_atencion);
//print_r($d['atencion']);die();
//---------------------------------------------------------------
$this->load->view('core/core_inicio');
$this -> load -> view('far/far_ordConsultarDesp', $d);
$this->load->view('core/core_fin'); 
//---------------------------------------------------------------
}
/////////////////////////////////////////////////////
function historiaMedicamento($id_atencion,$atc)
{
	$d['lista'] = $this->farmacia_model->obtenerHistoMedica($id_atencion,$atc);
	$this -> load -> view('far/far_ordInfoHistoMedicamento', $d);
}
/////////////////////////////////////////////////////
function ordenesdespachadas()
{
	//---------------------------------------------------------------
	$d = array();
	$d['urlRegresar']   = site_url('core/home/index');
	//---------------------------------------------------------------
	$d['lista'] = $this -> farmacia_model -> obtenerOrdenesDespachadas();
	$this->load->view('core/core_inicio');
	$this -> load -> view('far/far_medicamentosDespaSalas.php', $d);
	$this->load->view('core/core_fin'); 
	//---------------------------------------------------------------
}
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////	
function consultaOrdenDespachoCon($id_orden)
{
	 //---------------------------------------------------------------
$d = array();
$d['id_orden'] = $id_orden;
//---------------------------------------------------------------
$d['orden'] = $this->farmacia_model->obtenerOrden($id_orden);
$id_atencion = $d['orden']['id_atencion'];
$d['urlRegresar']   = site_url('far/main/ordenesdespachadas');
$d['ordenMedi'] = $this -> farmacia_model -> obtenerMediOrden($id_orden);
//print_r($this->db->last_query());
//die();
$d['ordenInsu'] = $this->farmacia_model-> obtenerInsumosOrden($id_orden);
$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
$d['tercero'] = $this -> paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
$d['diagnostico'] = $this->farmacia_model->obtenerDxFarmacia($id_atencion);
$d['cama'] = $this->farmacia_model->obtenerCamaFarmacia($id_atencion);
//print_r($d['atencion']);die();
//---------------------------------------------------------------
$this->load->view('core/core_inicio');
$this -> load -> view('far/far_ordConsultarDesp', $d);
$this->load->view('core/core_fin'); 
//---------------------------------------------------------------
}

/////////////////////////////////////////////////////
}
?>
