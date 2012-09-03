<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: main
 *Tipo: controlador
 *Descripcion: Permite la configuración de los rangos de las agendas.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
////////////////////////////////////////////////////////////////////////////////
class Main extends Controller
{
 function __construct()
  {
    parent::Controller(); 
    $this->load->model('agenda/agenda_model');
    $this->load->helper('array');
  }
function index()
    {
     $d = array();
     $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+
     $d['listaParametros']=$this->agenda_model->listaParametros();
    //----------------------------------------------------------
   
    $this->load->view('core/core_inicio');
    $this -> load -> view('agenda/agenda_principal', $d);
    $this->load->view('core/core_fin');
    }
    
 function agregarParametroAgenda()
 {
     $this->agenda_model->ingresarNuevoParametroAgenda(elements(Array('horaInicio',
                        'horaFin','aplica_sabado','aplica_domingo'),$_POST));
     Redirect('/agenda/main/index');
 }
 function asignarParametroActivo($id)
 {
     echo $id;
 }
}
