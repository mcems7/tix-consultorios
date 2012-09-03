<?php 
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Lista_atencion
 *Tipo: controlador
 *Descripcion: Permite la impresion de las listas de pacientes para atender
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
class Lista_atencion extends Controller
{

///////////////////////////////////////////////////////////////////////////////
  function __construct()
  {
    parent::Controller();     
    $this->load->model('lab/laboratorio_model'); 
    $this->load->model('urg/urgencias_model'); 
    $this->load->model('core/paciente_model');
    $this->load->model('atenciones/atenciones_model');
    $this->load->model('atenciones/atenciones_model');
    $this->load->model('citas/asignacion_model');
    $this->load->model('agenda/agenda_model');
    $this->load->helper('intervalos');
    $this->load->helper(array('form', 'url'));
  }
  
///////////////////////////////////////////////////////////////////
   function index()
  {
    //----------------------------------------------------------
    $d = array();
    $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+-
    //----------------------------------------------------------
   
    $this->load->view('core/core_inicio');
    $d['parametros_agenda']=$this->agenda_model->cargar_parametros();
    $d['lista_pacientes']=$this->atenciones_model->lista_pacientes($this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario')));
    if(count($d['lista_pacientes'])!=0)
      {
          for($i=0;$i<count($d['lista_pacientes']);$i++)
          {
              $minutos=$this->asignacion_model->minutos_cita($d['lista_pacientes'][$i]['intervalo_cita'], $d['lista_pacientes'][$i]['id']);
              $d['lista_pacientes'][$i]['minutos']=$minutos[0]['minutos'];
          }
      }
    $this->load->view('atencion/lista_pacientes',$d);
    $this->load->view('core/core_fin');
    //----------------------------------------------------------
  }
  }
  ?>