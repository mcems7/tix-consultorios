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
    $this -> load -> model('ima/imagenologia_model'); 
    $this -> load -> model('urg/urgencias_model'); 
    $this -> load -> model('core/paciente_model');
  }
  
///////////////////////////////////////////////////////////////////
  function index()
  {
    //----------------------------------------------------------
    $d = array();
    $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+-
    //----------------------------------------------------------
   
    $this->load->view('core/core_inicio');
    $this -> load -> view('ima/ima_imagenesSalas', $d);
    $this->load->view('core/core_fin');
    //----------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
  function listadoPacientesSala()
  
  {
    
    //----------------------------------------------------------
    $id_servicio  = $this->input->post('salasMed');
    $id_estado  = $this->input->post('estado');
    $d['servicio'] = $this -> imagenologia_model -> obtenerInfoServicio($id_servicio);
    $d['lista'] = $this -> imagenologia_model -> obtenerPacientesImagenes($id_servicio);
    $this -> load -> view('ima/ima_imagenesListado',$d);
    //----------------------------------------------------------
  }
  /////////////////////////////////////////////////////////////////
  
  function consultarOrden($id_orden)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    
    $d['orden'] = $this->imagenologia_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
    $d['urlRegresar']   = site_url('lab/main/index');
    $d['ordenIma'] = $this -> imagenologia_model -> obtenerImagenOrden($id_orden);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
    $d['diagnostico'] = $this->imagenologia_model->obtenerDxFarmacia($id_atencion);
    $d['cama'] = $this->imagenologia_model->obtenerCamaFarmacia($id_atencion);
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('ima/ima_ordConsultar', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
  
  function registraIma_()
  {
  //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
  
  
  $d['id_orden'] = $this->input->post('id_orden');
  $d['cups'] = $this->input->post('cups');
  $d['idIma'] = $this->input->post('idIma');
  
  for($i=0;$i<count($d['idIma']);$i++)
    {
    $d['realiza'][$i] = $this->input->post('realiza'.$d['idIma'][$i]);   
    }
  
  $d['razon'] = $this->input->post('razon');
  $this->imagenologia_model->registraRealizaIma($d);
  
  //----------------------------------------------------------
  $this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'ima',__CLASS__,__FUNCTION__
      ,'aplicacion',"Se le han agregado insumos a la orden id ".$d['id_orden']);
  //----------------------------------------------------------
  $dt['mensaje']  = "Los datos se han almacenado correctamente!!";
  $dt['urlRegresar']  = site_url("ima/main/index");
  $this -> load -> view('core/presentacionMensaje', $dt);
  return; 
  //----------------------------------------------------------
  
  }
  
  
  
///////////////////////////////////////////////////////////////////
}
?>
