<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: ausencias
 *Tipo: controlador
 *Descripcion: Permite la gestión de los pacientes que no asistieron a la consulta
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
class Atenciones extends Controller
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
    $this->load->helper(array('form', 'url'));
    $this -> load -> library('lib_edad');
  }
  
///////////////////////////////////////////////////////////////////
}
?>