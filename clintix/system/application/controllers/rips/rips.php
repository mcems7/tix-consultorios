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
class Rips extends Controller
{
 function __construct()
  {
    parent::Controller(); 
    $this->load->model('citas/citas_model');
    $this->load->model('rips/rips_model');
    $this->load->model('agenda/disponibilidades_model');
    $this->load->helper('array');
    $this->load->helper('intervalos');
    $this->load->helper('datos_listas_helper');
  }
////////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
  function index()
  {
      $this->load->view('core/core_inicio');
      $this->load->view('rips/consulta_rips');
      $this->load->view('core/core_fin');
  }
  function cargar_especialidades($fecha_inicial,$fecha_final)
  {
      $resultado=$this->rips_model->citas_atendidas_especialidades($fecha_inicial, $fecha_final);
      $listado=array();
      $listado["-1"]="Escoja una especialidad";
      foreach($resultado as $item)
        $listado[$item['id_especialidad']]=$item['especialidad'];
      echo form_dropdown('id_especialidad',$listado, '','id="id_especialidad" onChange="cargar_especialistas()"');
      
  }
  function cargar_especialistas($fecha_inicial,$fecha_final,$id_especialidad)
  {
      $resultado=$this->rips_model->medicos_atencion_fecha($fecha_inicial, $fecha_final,$id_especialidad);
      $listado=array();
      $listado["-1"]="Escoja un especialista";
      foreach($resultado as $item)
        $listado[$item['id_medico']]=$item['primer_nombre_medico'].' '.$item['segundo_nombre_medico'].' '.$item['primer_apellido_medico'].' '.$item['segundo_apellido_medico'];
      echo form_dropdown('id_especialista',$listado, '','id="id_especialista" onChange="cargar_rips()"');   
  }
  function rips_medico($fecha_inicial, $fecha_final,$id_especialista)
  {
      $resultado=$this->rips_model->rips_medico($fecha_inicial, $fecha_final,$id_especialista);
      $d['resultado']=$resultado;
      $d['fecha_inicial']=$fecha_inicial;
      $d['fecha_final']=$fecha_final;
      $d['id_especialista']=$id_especialista;
      $this->load->view('rips/rips_medico',$d);
  }

}