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
class Rips_editar extends Controller
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
      $this->load->view('rips/consulta_rips_editar');
      $this->load->view('core/core_fin');
  }
//////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
  function rips_medico($fecha_inicial, $fecha_final,$id_especialista)
  {
      $resultado=$this->rips_model->rips_medico($fecha_inicial, $fecha_final,$id_especialista);
      $d['resultado']=$resultado;
      $d['fecha_inicial']=$fecha_inicial;
      $d['fecha_final']=$fecha_final;
      $d['id_especialista']=$id_especialista;
      $this->load->view('rips/rips_medico_editar',$d);
  }
  function rips_factura_editar($fecha_inicial, $fecha_final,$id_especialista,$id_atencion,$factura)
  {
      $this->rips_model->editar_factura($id_atencion, $factura);
      $this->rips_medico($fecha_inicial, $fecha_final,$id_especialista);
  }

}