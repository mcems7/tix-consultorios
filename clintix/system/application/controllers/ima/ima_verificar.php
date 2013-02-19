<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: Ima_verificar
 *Tipo: controlador
 *Descripcion: Permite verificar las ordenes de inaginologia que han sido transcribidas.
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 12 de junio de 2012
*/
class Ima_verificar extends Controller
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
    $d['lista'] = $this -> imagenologia_model -> obtenerListadoImagenesVerificar();
	
    $this->load->view('core/core_inicio');
    $this -> load -> view('ima/ima_imagenesListadoVerificar', $d);
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

 function consultarTranscripcion($id)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    
    $d['procedimiento'] = $this->imagenologia_model->obtenerProcedimiento($id);
    $id_atencion = $d['procedimiento']['id_atencion'];
    $d['urlRegresar']   = site_url('ima/ima_verificar/index');
    
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model ->obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['procedimiento']['id_medico']);
    $d['diagnostico'] = $this->imagenologia_model->obtenerDxFarmacia($id_atencion);
	
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('ima/ima_ordVerificar', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }

///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////

function guardar_verificacion()
{

  $d = array();
    //---------------------------------------------------------------
  //id principal de la tabla urg_orde_imagenes
  $d['id'] = $this->input->post('id');
  //id de la tabla urg_ordenamiento
  $d['id_orden'] = $this->input->post('id_orden');
  $d['id_medico'] = $this->input->post('id_medico');
  $d['informe']=$this->input->post('informe');
  
  // guardamos los datos de la verificacion de la trasncripcion y actualiamos.
		$this->imagenologia_model->registra_verificacion_ima($d);
		//----------------------------------------------------------
			
			
			$dt['mensaje']  = "Verificacion generada con exito!!";
			
			
			$this -> load -> view('core/presentacionMensaje', $dt);
		 
		 
  redirect('/ima/ima_verificar/index', 'refresh');
	
	
}






 /////////////////////////////////////////////////////////////////////
}





?>