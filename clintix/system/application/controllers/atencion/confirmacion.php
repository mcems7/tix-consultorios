<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: atenciones
 *Tipo: controlador
 *Descripcion: Permite gestionar las ordenes de atencion
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 24 de octubre de 2011
*/
class Confirmacion extends Controller
{
///////////////////////////////////////////////////////////////////
  function __construct()
  {
    parent::Controller();     
    $this->load->model('lab/laboratorio_model'); 
    $this->load->model('urg/urgencias_model'); 
    $this->load->model('core/paciente_model');
    $this->load->model('citas/citas_model');
    $this->load->model('atenciones/atenciones_model');
    $this->load->model('agenda/consultorios_model');
    $this->load->helper('form');
    $this->load->helper(array('form', 'url'));
    $this->load->helper('url');
    $this->load->library('lib_edad');
    $this->load->model('citas/asignacion_model');
    $this->load->model('agenda/agenda_model');
    $this->load->helper('intervalos');
    $this->load->helper(array('form', 'url'));
  }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
  function index()
  {
     //----------------------------------------------------------
    $d = array();
    $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+-
    //----------------------------------------------------------
   
    $this->load->view('core/core_inicio');
    $d['especialidad']=$this->asignacion_model->especialidades_programadas_dia(date('Y-m-d'));
    $especialidad=array();
    $especialidad["-1"]="Todas";
    foreach( $d['especialidad'] as $item)
    {
        $especialidad[$item['id_especialidad']]=$item['descripcion'];
    }
    $d['especialidad']=$especialidad;
   
    $this->load->view('atencion/aten_confirmar',$d);
    $this->load->view('core/core_fin');
    //----------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
  function confirmar($id_cita,$factura)
  {
      $id_usuario=$this -> session -> userdata('id_usuario');
      $this->citas_model->confirmar_cita($id_cita,$factura,$id_usuario);
      $this->index();
  }
////////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function lista($id_especialidad)
{
     $d['parametros_agenda']=$this->agenda_model->cargar_parametros();
    $d['lista_pacientes']=$this->atenciones_model->lista_pacientes_confirmar($id_especialidad);
    if(count($d['lista_pacientes'])!=0)
      {
          for($i=0;$i<count($d['lista_pacientes']);$i++)
          {
              $minutos=$this->asignacion_model->minutos_cita($d['lista_pacientes'][$i]['intervalo_cita'], $d['lista_pacientes'][$i]['id']);
              $d['lista_pacientes'][$i]['minutos']=$minutos[0]['minutos'];
          }
      }
      $this->load->view('atencion/lista_filtrada_confirmar',$d);
}
}