<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: consultar_agendas
 *Tipo: controlador
 *Descripcion: Permite la consulta de las agendas de los especialistas
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
////////////////////////////////////////////////////////////////////////////////
class Consultar_agendas extends Controller
{
 function __construct()
  {
    parent::Controller(); 
    $this->load->model('agenda/agenda_model');
    $this->load->model('agenda/disponibilidades_model');
    $this->load->helper('intervalos');
    $this->load->helper('array');
  }
  /////////////////////////////////////////////////////////////////////////////
  //
  /////////////////////////////////////////////////////////////////////////////
function index()
    {
     $d = array();
     $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+
     $d['listaParametros']=$this->agenda_model->listaParametros();
     $medicos=$this->disponibilidades_model->lista_medicos_agenda();
     $d['medicos']=array();
     foreach($medicos as $item)
     {
         $d['medicos'][$item['id_medico']]=$item['primer_nombre']." ".
                                           $item['segundo_nombre']." ".
                                           $item['primer_apellido']." ".
                                           $item['segundo_apellido'].",".
                                           $item['especialidad'];
     }
    //----------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('agenda/agenda_medicos', $d);
    $this->load->view('core/core_fin');
    }
 /////////////////////////////////////////////////////////////////////////////
  //
  /////////////////////////////////////////////////////////////////////////////   
 function agregarParametroAgenda()
 {
     $this->agenda_model->ingresarNuevoParametroAgenda(elements(Array('horaInicio',
                        'horaFin','aplica_sabado','aplica_domingo'),$_POST));
     Redirect('/agenda/main/index');
 }
 /////////////////////////////////////////////////////////////////////////////
  //
  /////////////////////////////////////////////////////////////////////////////
 function asignarParametroActivo($id)
 {
     echo $id;
 }
 /////////////////////////////////////////////////////////////////////////////
  //
  /////////////////////////////////////////////////////////////////////////////
 function verificarPosicionAgenda($id_medico, $id_consultorio,$dia_semana, $intervalo)
  {
     echo 'true';
  }
  /////////////////////////////////////////////////////////////////////////////
  //
  /////////////////////////////////////////////////////////////////////////////
  function medicos_por_especialidad($id_especialidad)
  {
      
  }
  /////////////////////////////////////////////////////////////////////////////
  //
  /////////////////////////////////////////////////////////////////////////////
  function agenda_medico($fecha_inicial,$fecha_final,$id_medico)
  {
      $d['agenda']=$this->agenda_model->agenda_medicos($fecha_inicial, $fecha_final, $id_medico);
      $d['fechas']=$this->agenda_model->agenda_medicos_fechas($fecha_inicial, $fecha_final, $id_medico);
      $d['parametros_agenda']=$this->agenda_model->cargar_parametros();
      $this->load->view('agenda/agenda_medico', $d);
      
  }
}
