<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: impresiones_consulta
 *Tipo: controlador
 *Descripcion: Permite la impresión de los elementos que componen la atención de
 *             la consulta: la historia clínica electrónica, órdenamiento médico,
 *             interconsultas, incapacidad y citas de control.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
require_once('hce_consulta.php');
class Impresiones_consulta extends Hce_consulta
{
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
  function __construct()
  {
      parent::Controller(); 
      $this -> load -> model('urg/urgencias_model');
        $this -> load -> model('hce/hce_model');
        $this -> load -> model('core/medico_model');
         $this -> load -> model('citas/citas_model');
        $this -> load -> model('core/paciente_model');
        $this -> load -> model('core/tercero_model');
        $this -> load -> model('inter/interconsulta_model'); 
        $this -> load -> model('hce/hce_consulta_model');
        $this -> load -> helper('text');
        $this->load->model('atenciones/atenciones_model');
        $this->load->model('citas/asignacion_model');
        $this->load->model('agenda/consultorios_model');
        $this->load->helper('form');
        $this->load->helper('datos_listas');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('url');
        $this->load->helper('array');;
        $this->load->helper('intervalos');
        $this->load->library('lib_edad');
        $this->load->model('lab/laboratorio_model'); 
        $this->load->model('urg/urgencias_model'); 
        $this->load->model('core/paciente_model');
        $this->load->model('citas/citas_model');
        $this->load->model('agenda/agenda_model');
        $this->load->helper('numero_a_letra');
        $this->load->helper('utilidades_fechas');
  }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
  function imprimir_hce($id_cita)
  {
      $this->cargar_datos_basico($id_cita,$d);
      //$this->cargar_datos_basico($id_cita,$d);
      $d['info_cita']=$this->citas_model->detalle_cita($id_cita);
      $d['info_cita']=$d['info_cita'][0];
      $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
      $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
   $d['urlRegresar']=site_url().'/atencion/atenciones/registro_ordenes/';
   $d['info_cita']=$this->citas_model->detalle_cita($id_cita);
   $d['info_cita']=$d['info_cita'][0];
   $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
   $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
   $d['hce']=$this->hce_consulta_model->hce_paciente($id_cita);
   $d['hce_items']=$this->hce_consulta_model->hce_paciente($d['info_cita']['id']);
   $d['plan_manejo']=$this->hce_consulta_model->plan_y_manejo_paciente($d['info_cita']['id']);
   $d['diagnosticos']=$this->hce_consulta_model->diagnosticos_paciente($d['info_cita']['id']);
   $d['hce_impresa']=$this->generar_impresion_formato_hce($d['info_cita']['id_especialidad'],$d['hce_items']);
      $this->load->view('impresion/inicio');
      $this -> load->view('impresion/consulta_hce',$d);
      $this -> load->view('impresion/datos_medico',$d);
      $this->load->view('impresion/fin');
  }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
  function imprimir_incapacidad($id_cita)
  {
      $this->cargar_datos_basico($id_cita,$d);
      $d['info_cita']=$this->citas_model->detalle_cita($id_cita);
      $d['info_cita']=$d['info_cita'][0];
      $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
      $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
      $d['incapacidad']=$this->hce_consulta_model->incapacidad_paciente($id_cita);
      $this->load->view('impresion/inicio');
      $this->load->view('impresion/consulta_incapacidad',$d);
      $this -> load->view('impresion/datos_medico',$d);
      $this->load->view('impresion/fin');
  }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
  function imprimir_ordenes($id_cita)
  {
      $this->cargar_datos_basico($id_cita,$d);
      $d['info_cita']=$this->citas_model->detalle_cita($id_cita);
      $d['info_cita']=$d['info_cita'][0];
      $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
      $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
   //$d['hce']=$this->hce_consulta_model->hce_paciente($id_cita);
      $d['medicamentos']=$this->hce_consulta_model->medicamentos_paciente($id_cita);
      $d['ayudas_diagnosticas']=$this->hce_consulta_model->ayudas_diagnosticas($id_cita);
      $this->load->view('impresion/inicio');
      $this->load->view('impresion/consulta_ordenes',$d);
      $this -> load->view('impresion/datos_medico',$d);
      $this->load->view('impresion/fin');
  }
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function cargar_datos_basico($id_cita,&$d)
{
    $d['tercero']=$this->atenciones_model->datos_pacientes($id_cita);
    $d['tercero']=$d['tercero'][0];
    $d['medico']=$this->urgencias_model->obtenerMedico($d['tercero']['id_especialista']);
    $d['paciente']=$d['tercero'];
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function imprimir_estado_cita($pin)
{
    $d['estado_cita']=$this->citas_model->datos_cita($pin);
    $d['pin']=$pin;
    if($d['estado_cita']['estado']=='asignada'||$d['estado_cita']['estado']=='confirmada' ||
       $d['estado_cita']['estado']=='atendida')
    {
        $parametros_agenda=$this->agenda_model->cargar_parametros();
        $minutos=$this->asignacion_model->minutos_cita($d['estado_cita']['intervalo_cita'], $d['estado_cita']['id']);
        $d['minutos']=$minutos;
        $d['parametros_agenda']=$parametros_agenda;
    }
    $this->load->view('impresion/inicio');
    $this->load->view('impresion/estado_cita',$d);
    $this->load->view('impresion/fin');
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function imprimir_remision($id_cita)
{
    $this->cargar_datos_basico($id_cita,$d);
    $d['info_cita']=$this->citas_model->detalle_cita($id_cita);
    $d['info_cita']=$d['info_cita'][0];
    $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
    $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
    $d['remision']=$this->hce_consulta_model->remision($id_cita);
    $this->load->view('impresion/inicio');
    $this->load->view('impresion/consulta_remision',$d);
    $this -> load->view('impresion/datos_medico',$d);
    $this->load->view('impresion/fin');
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function imprimir_control($id_cita)
{
    $this->cargar_datos_basico($id_cita,$d);
    $d['info_cita']=$this->citas_model->detalle_cita($id_cita);
    $d['info_cita']=$d['info_cita'][0];
    $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
    $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
    $d['remision']=$this->hce_consulta_model->control($id_cita);
    $this->load->view('impresion/inicio');
    $this->load->view('impresion/consulta_control',$d);
    $this -> load->view('impresion/datos_medico',$d);
    $this->load->view('impresion/fin');
}
}
?>