<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: estado_cita
 *Tipo: controlador
 *Descripcion: Permite la consulta del estado de la cita
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
///////////////////////////////////////////////////////////////////////////////
class Estado_cita extends Controller
{
 function __construct()
  {
    parent::Controller(); 
    $this->load->model('citas/citas_model');
    $this->load->model('agenda/agenda_model');
    $this->load->model('citas/asignacion_model');
    $this->load->helper('array');
    $this->load->helper('intervalos');
    $this->load->helper('datos_listas');
  }
function index()
    {
     $d = array();
     $d['urlRegresar']   = site_url('core/home/index'); //Asignar al menu principal -+-+-+-+-+-+-+-+-+-+-+
     //----------------------------------------------------------
   
    $this->load->view('core/core_inicio');
    $this -> load -> view('citas/consultar_cita');
    $this->load->view('core/core_fin');
    }
    function buscar()
    {
        $d = array();
    $d['atencionesConsulta'] = array();
    //--------------------------------------------------------------------------
    $d['urlRegresar'] 	= site_url('core/home/index');	
    //--------------------------------------------------------------------------
    $d['primer_apellido'] 	= $this->input->post('primer_apellido');
    $d['primer_nombre'] 	= $this->input->post('primer_nombre');
    $d['segundo_apellido'] 	= $this->input->post('segundo_apellido');
    $d['segundo_nombre'] 	= $this->input->post('segundo_nombre');
    $d['numero_documento'] 	= $this->input->post('numero_documento');		
    $d['pin']                   = $this->input->post('pin');
    $d['citas']                 = $this->citas_model->buscar_cita($d);
    $this->load->view('citas/listado_citas_buscada',$d);
    }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function detalle_solicitud($pin)
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
    $this->load->view('core/core_inicio');
    $this->load->view('citas/cita_solicitada',$d);
    $this->load->view('core/core_fin');
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
}
