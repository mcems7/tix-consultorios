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
class Programar_agenda extends Controller
{
 function __construct()
  {
    parent::Controller(); 
    $this->load->model('agenda/agenda_model');
    $this->load->model('agenda/consultorios_model');
    $this->load->model('agenda/disponibilidades_model');
    $this->load->helper('array');
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
      $d['consultorios']=$this->columnas_consultorios();
      $consultorios=$this->consultorios_model->listaConsultorios();
      $options_array=array();
      foreach($consultorios as $item)
          $options_array[$item['id_consultorio']]=$item['descripcion'];  
      $d['options_array_consultorio_selected']=$options_array;
      $this->load->view('core/core_inicio');
      $this->load->view('agenda/programacion_agenda', $d);
      $this->load->view('core/core_fin');
  }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function programacion_agenda($fecha)
{
    $parametros_agenda=$this->agenda_model->cargar_parametros();
    $d['horas']=arreglo_intervalo($parametros_agenda);
    $d['datos_agenda']=$rangos_asignados=$this->agenda_model->datosAgenda($fecha);
    $d['fecha']=$fecha;
    $consultorios=$this->consultorios_model->listaConsultorios();
    $options_array=array();
    foreach($consultorios as $item)
          $options_array[$item['id_consultorio']]=$item['descripcion'];  
      $d['options_array_consultorio_selected']=$options_array;
    $this->load->view('agenda/agenda',$d);
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
  private function columnas_consultorios()
  {
      $consultorios=$this->consultorios_model->listaConsultorios();
      if(count($consultorios)==0)
          return '';
      $cadena='';
      foreach($consultorios as $item)
      {
          $cadena.=',{';
          $cadena.='header: "'.$item['descripcion'].'", ';
          $cadena.='dataIndex: "consultorio_'.$item['id_consultorio'].'", ';
          $cadena.='dataType:"string"';
          $cadena.='}';
      }
      return $cadena;
  }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
  function datos_agenda($fecha)
  {
      //print_r($fecha);
      $rangos_asignados=$this->agenda_model->datosAgenda($fecha);
      $d=$this->arreglo_agenda(1);
      foreach($rangos_asignados as $item)
      {
          $medico=$item['primer_nombre'].' '.$item['primer_apellido'].'<BR>'.$item['especialidad'];
          $d[$item['orden_intervalo']]['consultorio_'.$item['id_consultorio']]=$medico;
      }
      $d = array("page"=>1, "total"=>count($d), "data"=>$d);
      echo json_encode($d);
  }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
  private function arreglo_agenda($id_parametro)
  {
      $d=array();
      $parametros_agenda=$this->agenda_model->cargar_parametros();
      for($i=0;$i<=$parametros_agenda[0]['horaFin']-$parametros_agenda[0]['horaInicio'];$i++)
      {
            $d[$i]['help_category_id']=$i+$parametros_agenda[0]['horaInicio'];
      }
      return $d;
  }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
  function agregar_dato_agenda($id_medico,$id_consultorio,$fecha,$intervalo)
  {
      $d=array();
      $d=$this->agenda_model->agenda_dia($fecha);
      if(count($d)!=0)
        $parametros_agenda=$this->agenda_model->cargar_parametros($d[0]['id_parametro_agenda']);
      else
         $parametros_agenda=$this->agenda_model->cargar_parametros();
         $duracion=$parametros_agenda[0]['duracion_intervalo'];
         
         $dia=$fecha;
         $hora=2;
      $this->agenda_model->agregar_detalle_agenda($id_medico, $id_consultorio, $intervalo, $dia,$hora,$duracion);     
      
  }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
  function listar_especialidades_por_consutorio($id_consultorio)
  {
      $disponibilidades=$this->agenda_model->disponibilidades_medicos($id_consultorio);
      $options_array=array();
      foreach($disponibilidades as $item)
          $options_array[$item['id_core_medico']]=$item['nombre_medico'].' Horas Disponibles: '.$item['horas_disponibles'];  
      echo form_dropdown('medico_disponibilidad',$options_array,'','id="medico_disponibilidad"');
      
  }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function esta_disponible_consultorio($id_consultorio,$intervalo, $fecha)
{
 if(count($this->agenda_model->buscar_detalle_agenda($fecha, $intervalo,$id_consultorio)))
        {
            echo 'Consultorio no Disponible';
            return;
        }
  echo "Si";
}
////////////////////////////////////////////////////////////////////////////
//Obtiene la especialidad de un médico y devuelve los consultorios asociaciados
//a esa especialidad
////////////////////////////////////////////////////////////////////////////
function consultorios_especialidad($id_especialista)
{
   $especialidad=$this->disponibilidades_model->especialidad_medico($id_especialista);
   if(count($especialidad)==0)
       $especialidad=-10;
   else
       $especialidad=$especialidad[0]['id_especialidad'];
   $resultado=$this->consultorios_model->lista_consultorios_especialidad($especialidad);
   $arreglo_consultorios=array();
   foreach($resultado as $item)
   {
       $arreglo_consultorios[$item['id_consultorio']]=$item['descripcion'];
   }
  echo form_dropdown('consultorio',$arreglo_consultorios,'','id="consultorio"');
}
//////////////////////////////////////////////////////////////////
function consultorios_especialidad1($id_especialista)
{
   $especialidad=$this->disponibilidades_model->especialidad_medico($id_especialista);
   if(count($especialidad)==0)
       $especialidad=-10;
   else
       $especialidad=$especialidad[0]['id_especialidad'];
   $resultado=$this->consultorios_model->lista_consultorios_especialidad($especialidad);
   $arreglo_consultorios=array();
   foreach($resultado as $item)
   {
       $arreglo_consultorios[$item['id_consultorio']]=$item['descripcion'];
   }
  echo form_dropdown('consultorio1',$arreglo_consultorios,'','id="consultorio1"');
}
////////////////////////////////////////////////////////////////////////////
//lista los médicos especialistas de una determinada especialidad y retorna 
//un select para su impresión en la interfaz de usuario que la requiera.
///////////////////////////////////////////////////////////////////////////
function listar_especialistas_por_especialidad($id_especialidad)
{
  $disponibilidades=$this->agenda_model->disponibilidades_medicos_especialidad($id_especialidad);
  $options_array=array();
  foreach($disponibilidades as $item)
      $options_array[$item['id_core_medico']]=$item['nombre_medico'].' || Horas Disponibles: '.$item['horas_disponibles'].' || '. $item['especialidad'];  
  echo form_dropdown('medico_disponibilidad',$options_array,'','id="medico_disponibilidad" onchange="actualizarConsultorios()"');
}
function listar_especialistas_por_especialidad1($id_especialidad)
{
  $disponibilidades=$this->agenda_model->disponibilidades_medicos_especialidad($id_especialidad);
  $options_array=array();
  foreach($disponibilidades as $item)
      $options_array[$item['id_core_medico']]=$item['nombre_medico'].' || Horas Disponibles: '.$item['horas_disponibles'].' || '. $item['especialidad'];  
  echo form_dropdown('medico_disponibilidad1',$options_array,'','id="medico_disponibilidad1" onchange="actualizarConsultorios1()"');
}
////////////////////////////////////////////////////////////////////////////
//lista los médicos especialistas de una determinada especialidad y retorna 
//un select para su impresión en la interfaz de usuario que la requiera.
///////////////////////////////////////////////////////////////////////////
function eliminar_agenda($fecha, $id_consultorio,$id_intervalo_inicio, $id_intervalo_final)
{
    $this->agenda_model->suspender_citas_agenda_intervalos($fecha, $id_consultorio, $id_intervalo_inicio, $id_intervalo_final);
}
function medico_ocupa_consultorio_hora($id_medico, $intervalo_inicial,$intervalo_final,$fecha)
{
    
    echo $this->agenda_model->medico_ocupa_consultorio_hora($id_medico, $intervalo_inicial,$intervalo_final,$fecha);
}
}
?>