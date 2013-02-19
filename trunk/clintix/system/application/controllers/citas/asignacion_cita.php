<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: asignacion_cita
 *Tipo: controlador
 *Descripcion: Permite la asignación de pacientes a las agendas programadas de los médicos
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
////////////////////////////////////////////////////////////////////////////////
class Asignacion_cita extends Controller
{
 function __construct()
  {
    parent::Controller(); 
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
////////////////////////////////////////////////////////////////////////////////
  function index()
  {
    $this->load->view('core/core_inicio');
    $d['fecha']=date('y-m-d');
    $d['entidades_remision']=$this->citas_model->obtenerEntidadesRemision();
    $departamentos=$this->ubicacion_model->departamentos();
    $d['departamento']=array(-1=> "Todos");
    foreach($departamentos as $item)
    {
        if($item['nombre']!="No aplica")
            $d['departamento'][$item['id_departamento']]=$item['nombre'];
    }
    $this->load->view('citas/asignacion_citas',$d);
    $this->load->view('core/core_fin');
  }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function especialidades_dia($dia)
{
  $d['especialidades']=$this->asignacion_model->especialidades_programadas_dia($dia);
  $especialidades['-1']='Seleccione una Especialidad a Programar';
  foreach($d['especialidades'] as $item)
  {
      $especialidades[$item['id_especialidad']]=$item['descripcion'];
  }
  if(count($especialidades)!=0)
  echo form_dropdown('id_especialidad',$especialidades, '','id="id_especialidad" onchange="lista_pacientes_espera()"');
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function especialistas_dia($fecha, $id_especialidad)
{
  $arreglo_agenda=array();
  $d['especialistas']=$this->asignacion_model->especialistas_programados_dia($fecha,$id_especialidad);
  $parametros_agenda=$this->agenda_model->cargar_parametros();
  for($i=0;$i<= ($parametros_agenda[0]['horaFin']-$parametros_agenda[0]['horaInicio']);$i++)
  {
      $agenda[$i]=($parametros_agenda[0]['horaInicio']+$i)."-".($parametros_agenda[0]['horaInicio']+$i+1);
  }
  $array_tiempos_disponibles=array();
  $arreglo_disponibilidades=array();
  foreach($d['especialistas'] as $item)
  {
      $arreglo_agenda[$item['id_medico']]['id']=$item['id_medico'];
	  $arreglo_agenda[$item['id_medico']]['bloqueado']=$item['bloqueado'];
	  //$arreglo_agenda[$item['id_medico']]['bloqueado']=$item['bloqueado'];
      $arreglo_agenda[$item['id_medico']]['nombre']=$item['primer_nombre'].' '.$item['segundo_nombre'].' '.$item['primer_apellido'].' '.$item['segundo_apellido'].' ';
      for($i=0;$i<=$parametros_agenda[0]['horaFin']-$parametros_agenda[0]['horaInicio'];$i++)
      {
           $arreglo_agenda[$item['id_medico']][$i]= $agenda[$i];
      }
      $arreglo_disponibilidades[$item['id_medico']]=$this->citas_model->detalle_disponbilidad_medico($fecha,$item['id_medico']);
      foreach($arreglo_disponibilidades[$item['id_medico']]  as $item)
      { 
          $array_tiempos_disponibles[$item['id_agenda_dia_detalle']]=$this->citas_model->tiempos_disponibles($item['id_agenda_dia_detalle']);

      }
  }
  $d['arreglo_agenda']=$arreglo_agenda;
  $d['agenda']=$agenda;
  $d['arreglo_disponibilidades']=$arreglo_disponibilidades;
  $d['tiempos_disponibles']=$array_tiempos_disponibles;
  $this->load->view('citas/citas_agenda',$d);
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function pacientes_espera($id_especialidad,$id_departamento,$id_municipio,
                        $tipo_atencion,$prioridad,$prioritaria,
                        $id_entidad_remitente,$id_tiempo,$id_entidad,$fecha,$cadena='')
{
  $d['pacientes']=$this->asignacion_model->pacientes_espera_especialidad($id_especialidad,$id_departamento,$id_municipio,$tipo_atencion,
                                                                         $prioridad,$prioritaria,$id_entidad_remitente,$id_tiempo,$id_entidad,$cadena);
  $pacientes=array();
  foreach($d['pacientes'] as $item)
  {
      $paciente=$item['numero_documento'].' || '.$item['primer_nombre'].' '.$item['segundo_nombre'].' '.
                $item['primer_apellido'].' '.$item['segundo_apellido'].' || '.
                $this->lib_edad->dias($item['fecha_solicitud'],$fecha).' Días ||'.
                $this->lib_edad->edad($item['fecha_nacimiento']).' || '.$item['pin'];
      $pacientes[$item['id']]=$paciente;
  }
  if(count($pacientes)!=0)
  echo form_dropdown('id_remision',$pacientes, '', 
                     'id="id_remision" onchange="datos_basicos_cita()"');
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function datos_basico_cita($id_cita,$fecha)
{
  $d['datos_cita']=$this->asignacion_model->datos_basicos_cita($id_cita);
  $d['datos_cita']=$d['datos_cita'][0];
  $d['fecha']=$fecha;
  $d['ultima_atencion']=$this->atenciones_model->ultima_atencion_paciente($d['datos_cita']['id_paciente']);
  $d['numero_documento_paciente']=$this->atenciones_model->ultima_atencion_paciente($d['datos_cita']['id_paciente']);
  $this->load->view('citas/datos_basicos_cita',$d);
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function pacientes_agenda($id_medico, $fecha)
{
  $d['parametros_agenda']=$this->agenda_model->cargar_parametros();
  $d['lista_pacientes']=$this->asignacion_model->pacientes_programados_dia_medico($fecha, $id_medico);
  $d['datos_agenda']=array('id_medico'=>$id_medico, 
                           'fecha'=>$fecha);
  if(count($d['lista_pacientes'])!=0)
  {
      for($i=0;$i<count($d['lista_pacientes']);$i++)
      {
          $minutos=$this->asignacion_model->minutos_cita($d['lista_pacientes'][$i]['intervalo_cita'], $d['lista_pacientes'][$i]['id']);
          $d['lista_pacientes'][$i]['minutos']=$minutos[0]['minutos'];
      }
  }
  $this->load->view('citas/agenda_pacientes',$d);
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function asignar_cita($id_detalle_agenda, $id_cita)
{
    
    $orden_intervalo=$this->asignacion_model->maximo_intervalo($id_detalle_agenda);
    $datos_cita=$this->citas_model->detalle_cita($id_cita);
    $duracion_cita=$datos_cita[0]['duracion_cita'];
    $id_usuario=$this -> session -> userdata('id_usuario');
    $this->asignacion_model->asignar_cita($id_detalle_agenda, $id_cita, $orden_intervalo[0]['orden_intervalo'],$duracion_cita,$id_usuario);
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function suspender_cita_paciente($id_cita)
{
  $id_usuario=$this->session->userdata('id_usuario');
  $this->citas_model->suspender_cita($id_cita,$id_usuario);
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function dar_baja_cita_paciente($id_cita,$causa)
{
  $id_usuario=$this -> session -> userdata('id_usuario');
  $this->citas_model->dar_baja_cita($id_cita,$causa,$id_usuario);
}
 ////////////////////////////////////////////////////////////////////////////// 
 
 function crear_observacion_agenda($id_cita,$observacion)
{
  $fecha=date('Y-m-d H:i:s');
  $observacion_traida=$this->citas_model->observacion_agenda($id_cita);
  $observacion_agenda= $observacion_traida ."<br>".$fecha.' '. $observacion ;
  $this->citas_model->crear_observacion_agenda($id_cita,$observacion_agenda);
  
}
 
 
 
}
 ?>