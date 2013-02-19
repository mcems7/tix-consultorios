<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: Imaginologia
 *Tipo: controlador
 *Descripcion: Permite gestionar las ordenes que llegan a imaginologia.
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 12 de junio de 2012
*/
class Imaginologia extends Controller
{
///////////////////////////////////////////////////////////////////
  function __construct()
  {
    parent::Controller();     
      $this -> load -> model('ima/imagenologia_model'); 
    $this -> load -> model('urg/urgencias_model'); 
    $this -> load -> model('core/paciente_model');
	$this->load->helper(array('form', 'url'));
  }
  
///////////////////////////////////////////////////////////////////
   function index()
  {
    //----------------------------------------------------------
    $d = array();
    $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+-
    //----------------------------------------------------------
    $d['lista'] = $this -> imagenologia_model -> obtenerListadoImagenesTranscribir();
	
    $this->load->view('core/core_inicio');
    $this -> load -> view('ima/ima_imagenesListadoTranscribir', $d);
    $this->load->view('core/core_fin');
    //----------------------------------------------------------
  }
         	/* 
* @Descripcion: Consulta un procedimiento de imagen 
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111024
* @version		20111024
*/

 function consultarOrden($id)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    
    $d['procedimiento'] = $this->imagenologia_model->obtenerProcedimiento($id);
    $id_atencion = $d['procedimiento']['id_atencion'];
    $d['urlRegresar']   = site_url('ima/imaginologia/index');
    
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['procedimiento']['id_medico']);
    $d['diagnostico'] = $this->imagenologia_model->obtenerDxFarmacia($id_atencion);
	
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('ima/ima_ordTranscribir', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }


function guardar_transcripcion()
{

  $d = array();
    //---------------------------------------------------------------
  //id principal de la tabla urg_orde_imagenes
  $d['id'] = $this->input->post('id');
  //id de la tabla urg_ordenamiento
  $d['id_orden'] = $this->input->post('id_orden');
  $d['realizado'] = $this->input->post('realizado');
  
  if($d['realizado']=='SI'){
	  $d['motivo']='';
	  }else{
			$d['motivo']=$this->input->post('motivo');	  
		   }
  $d['informe']=$this->input->post('informe');
  
  // guardamos los datos de la transcripcion y actualiamos.
		$this->imagenologia_model->registra_transcripcion_ima($d);
		//----------------------------------------------------------
			
			
			$dt['mensaje']  = "Transcripcion generada con exito!!";
			
			
			$this -> load -> view('core/presentacionMensaje', $dt);
		 
		 
  redirect('/ima/imaginologia/index', 'refresh');
	
	
}







 /////////////////////////////////////////////////////////////////////
}





?>