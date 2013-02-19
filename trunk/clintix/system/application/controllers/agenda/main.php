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
 
 /*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Descripcion: Permite crear el bloqueo de la agenda 
 *Autor: Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
 *Fecha de creación: 06 de Agosto de 2012
 */
 
  function agregarBloqueo($fecha,$intervalo_inicial,$intervalo_final,$consultorio,$id_especialista)
 {
	
   $d['id_agenda_consultorio']=$this->agenda_model->CapturaAgendaConsultorio($fecha,$intervalo_inicial,$intervalo_final,$consultorio);
   
  $this->agenda_model->BloquearAgenda($d['id_agenda_consultorio'][0]['id_agenda_consultorio'],$id_especialista);
	
     //Redirect('/agenda/main/index');
 }
 
 
 
 
 /*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Descripcion: Permite crear el desbloqueo de la agenda 
 *Autor: Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
 *Fecha de creación: 06 de Agosto de 2012
 */

  function agregarDesbloqueo($fecha,$intervalo_inicial,$intervalo_final,$consultorio,$id_especialista)
 {
	
   $d['id_agenda_consultorio']=$this->agenda_model->CapturaAgendaConsultorio($fecha,$intervalo_inicial,$intervalo_final,$consultorio);
   
  $this->agenda_model->DesbloquearAgenda($d['id_agenda_consultorio'][0]['id_agenda_consultorio'],$id_especialista);
	
     //Redirect('/agenda/main/index');
 }
 
 
 
 function asignarParametroActivo($id)
 {
     echo $id;
 }
}
