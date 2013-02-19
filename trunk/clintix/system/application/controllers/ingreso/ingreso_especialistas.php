<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: programar_agenda
 *Tipo: controlador
 *Descripcion: Permite la gestión de la agenda de los consultorios con los médicos
 *             disponibles.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
class Ingreso_especialistas extends Controller
{
 function __construct()
  {
    parent::Controller(); 
    $this->load->model('agenda/agenda_model');
    $this->load->model('agenda/consultorios_model');
    $this->load->model('agenda/disponibilidades_model');
	 $this->load->model('ingreso/ingreso_model');
    $this->load->helper('array');
    $this->load->helper('intervalos');
	
	   $this->load->model('agenda/agenda_model');
    $this->load->model('citas/citas_model');
    $this->load->model('citas/asignacion_model');
    $this->load->model('atenciones/atenciones_model');
    $this->load->model('core/ubicacion_model');
    $this->load->model('core/medico_model');
    $this->load->model('urg/urgencias_model');
    $this->load->library('lib_edad');
    $this->load->helper('url');
    $this->load->helper('date');
    $this->load->helper('array');
    $this->load->helper('datos_listas');
    $this->load->helper('intervalos');
	
	
	
	
	
  }
////////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
  function index()
  {
      $parametros_agenda=$this->agenda_model->cargar_parametros();
      
      $d=array();
      $d['listadoEspecialidades']=$this->consultorios_model->lista_especialidades_consultorios();
	  $d['listadoEspecialidades1']=$this->consultorios_model->lista_especialidades_consultorios();
      $especialidades_temporal=array();
	  $especialidades_temporal1=array();
      $especialidades_temporal['-1']="Todas";
	  $especialidades_temporal1['-1']="Todas";
      foreach($d['listadoEspecialidades'] as $item)
        $especialidades_temporal[$item['id_especialidad']]=$item['descripcion'];
  foreach($d['listadoEspecialidades1'] as $item)
        $especialidades_temporal1[$item['id_especialidad']]=$item['descripcion'];     
      $d['listadoEspecialidades']=$especialidades_temporal;
	  $d['listadoEspecialidades1']=$especialidades_temporal1;
      $d['horarios']=arreglo_horas($parametros_agenda);
      $d['horarios_hasta']=array();
      foreach($d['horarios'] as $key=>$item)
           $d['horarios_hasta'][$key]=$item+1;
      
      $consultorios=$this->consultorios_model->listaConsultorios();
      $options_array=array();
      foreach($consultorios as $item)
          $options_array[$item['id_consultorio']]=$item['descripcion'];  
      $d['options_array_consultorio_selected']=$options_array;
      $this->load->view('core/core_inicio');
      $this->load->view('ingreso/registro_ingreso', $d);
      $this->load->view('core/core_fin');
  }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////
	/* 
* @Descripcion: Guarda el registro de los signos vitales.
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20111115
* @version		20111115
*/
	function crearNota_()
	{
		//---------------------------------------------------------------
		$d = array();
		$d['fecha'] = $this->input->post('fecha_agenda');
		$d['id_especialidad']  =$this->input->post('id_especialidad');
		$d['id_especialista']  = $this->input->post('medico_disponibilidad');
		$d['hora_llegada']  = $this->input->post('hora_llegada');
		$d['hora_agendada']  = $this->input->post('hora_agendada');
		echo $d['hora_llegada'];
		
		$verificar = $this -> ingreso_model -> VerificarExistencia($d['fecha'],$d['id_especialista']);
	
		if ($verificar==1){
			//----------------------------------------------------
		$dt['mensaje']  = "Los datos de horario para esta fecha ya habian sido almacenados anteriormente!!";
		$dt['urlRegresar'] 	= site_url("ingreso/ingreso_especialistas/index");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;
			}else{
			$this -> ingreso_model -> crearNotaDb($d);	
		//----------------------------------------------------
		$dt['mensaje']  = "Se a almacenado la hora de ingreso correctamente!!";
		$dt['urlRegresar'] 	= site_url("ingreso/ingreso_especialistas/index");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
			} 
		//----------------------------------------------------------
	}


////////////////////FIN/////////////////////////////////////////


}
?>