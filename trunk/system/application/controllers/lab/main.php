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
    $this -> load -> model('lab/laboratorio_model'); 
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
    $this -> load -> view('lab/lab_examenesSalas', $d);
    $this->load->view('core/core_fin');
    //----------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
  function listadoPacientesSala()
  {
    
    //----------------------------------------------------------
    $id_servicio  = $this->input->post('salasMed');
    $id_estado  = $this->input->post('estado');
    $d['servicio'] = $this -> laboratorio_model -> obtenerInfoServicio($id_servicio);
    $d['lista'] = $this -> laboratorio_model -> obtenerPacientesExamenes($id_servicio);
    $this -> load -> view('lab/lab_examenesListado',$d);
    //----------------------------------------------------------
  }
  /////////////////////////////////////////////////////////////////
  
  function consultarOrden($id_orden)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
   
    $d['orden'] = $this->laboratorio_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
	
	
    $d['urlRegresar']   = site_url('lab/main/index');
    $d['ordenLab'] = $this -> laboratorio_model -> obtenerLaboraOrden($id_orden);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
    $d['diagnostico'] = $this->laboratorio_model->obtenerDxFarmacia($id_atencion);
    $d['cama'] = $this->laboratorio_model->obtenerCamaFarmacia($id_atencion);
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('lab/lab_ordConsultar', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
  
  function registraLab_()
  {
  //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
  
  
  $d['id_orden'] = $this->input->post('id_orden');
  $d['cups'] = $this->input->post('cups');
  $d['idLab'] = $this->input->post('idLab');
  
  for($i=0;$i<count($d['idLab']);$i++)
    {
    $d['realiza'][$i] = $this->input->post('realiza'.$d['idLab'][$i]);   
    }
  
  $d['razon'] = $this->input->post('razon');
  $this->laboratorio_model->registraRealizaLab($d);
  
  //----------------------------------------------------------
  $this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'lab',__CLASS__,__FUNCTION__
      ,'aplicacion',"Se le han agregado insumos a la orden id ".$d['id_orden']);
  //----------------------------------------------------------
  $dt['mensaje']  = "Los datos se han almacenado correctamente!!";
  $dt['urlRegresar']  = site_url("lab/main/index");
  $this -> load -> view('core/presentacionMensaje', $dt);
  return; 
  //----------------------------------------------------------
  
  }
  
  
  
///////////////////////////////////////////////////////////////////
}
?>
