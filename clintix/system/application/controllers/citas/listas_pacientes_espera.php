<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: lista_pacientes_espera
 *Tipo: controlador
 *Descripcion: Permite visualizar la lista de pacientes en espera que no se les
 *              ha programado aún cita con el especialista.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
class Listas_pacientes_espera extends Controller
{
 function __construct()
  {
    parent::Controller(); 
    $this->load->model('agenda/agenda_model');
    $this->load->model('citas/citas_model');
    $this->load->helper('array');
    $this->load->helper('datos_listas_helper');
  }
function index()
    {
    $d['listado_citas']=$this->citas_model->lista_consultas_espera();
    $tipo_cita='';
    for($i=0; $i<count($d['listado_citas']); $i++)
    {
       $tipo_cita=valor_tipo_cita($d['listado_citas'][$i]['tipo_cita']);
        $d['listado_citas'][$i]['tipo_cita']=$tipo_cita;
    }
    $this->load->view('core/core_inicio');
    $this->load->view('citas/lista_citas_espera', $d);
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
 ///////////////////////////////////////////////////////////////////////////////
 //
 //////////////////////////////////////////////////////////////////////////////
 function detalle_cita($id_cita)
 {
    $d['listado_citas']=$this->citas_model->detalle_cita($id_cita);
    $d['info_cita']=$d['listado_citas'][0];
    $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
    $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
    $this->load->view('core/core_inicio');
    $this->load->view('citas/detalle_cita',$d);
    //$this->load->view('citas/autorizar_cita',$d);
    $this->load->view('core/core_fin');
 }
}
