<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Main_consulta_externa
 *Tipo: controlador
 *Descripcion: Permite la impresión de los elementos que componen la atención de
 *             la consulta: la historia clínica electrónica, órdenamiento médico,
 *             interconsultas, incapacidad y citas de control.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
///////////////////////////////////////////////////////////////////////////////
require_once('hce_consulta.php'); //
class Main_consulta_externa extends Hce_consulta
{
///////////////////////////////////////////////////////////////////
function __construct()
{
        parent::__construct();			
        $this -> load -> model('urg/urgencias_model');
        $this -> load -> model('hce/hce_model');
        $this -> load -> model('core/medico_model');
        $this -> load -> model('core/paciente_model');
        $this -> load -> model('core/tercero_model');
        $this -> load -> model('inter/interconsulta_model'); 
        $this -> load -> model('hce/hce_consulta_model');
        $this -> load -> helper('text');
        $this->load->model('atenciones/atenciones_model');
        $this->load->model('agenda/consultorios_model');
        $this->load->helper('form');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('url');
         $this->load->helper('datos_listas');
        $this->load->library('lib_edad');
        $this->load->model('lab/laboratorio_model'); 
        $this->load->model('urg/urgencias_model'); 
        $this->load->model('core/paciente_model');
        $this->load->model('citas/citas_model');
	}
///////////////////////////////////////////////////////////////////
/*
* Busqueda de un paciente para ser atendido en consulta externa
*
* @author José Miguel Londoño Montilla <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20110308
* @version		20110308
*/
function index()
{
        //----------------------------------------------------------
        $d = array();
        $d['urlRegresar'] 	= site_url('core/home/index');
        //-----------------------------------------------------------
        $this->load->view('core/core_inicio');
        $this -> load -> view('hce/consulta_externa_inicio',$d);
        $this->load->view('core/core_fin');
        //----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////	
function buscar_atenciones($id_paciente)
{	
        //----------------------------------------------------------
        $d = array();
        $d['atencionesUrg'] = array();
        $d['urlRegresar'] 	= site_url('hce/main/index');	
        $atenciones = $this ->hce_model -> obtenerAtencionesUrg($id_paciente);
        $d['atencionesConsulta'] = $atenciones;
        $this->load->view('core/core_inicio');
        $this->load->view('hce/hce_listadoAtenciones',$d);
        $this->load->view('core/core_fin');	
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////	
function buscar_atenciones_paciente()
{
//------------------------------------------------------------------------------
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
    $d['atencionesConsulta']     = $this->hce_consulta_model->obtenerAtencionesPacientes($d);
    echo $this->load->view('hce/hce_listado_pacientes_consulta',$d);
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function hce_paciente($id_cita)
{
   $this->cargar_datos_basico($id_cita,$d);
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
   $this->load->view('core/core_inicio');
   $this -> load -> view('hce/hce_consulta',$d);
   $this->load->view('core/core_fin');
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
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function hce_ordenes($id_cita)
{
   $this->cargar_datos_basico($id_cita,$d);
   $d['info_cita']=$this->citas_model->detalle_cita($id_cita);
   $d['info_cita']=$d['info_cita'][0];
   $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
   $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
   //$d['hce']=$this->hce_consulta_model->hce_paciente($id_cita);
   $d['medicamentos']=$this->hce_consulta_model->medicamentos_paciente($id_cita);
   $d['ayudas_diagnosticas']=$this->hce_consulta_model->ayudas_diagnosticas($id_cita);
   $this->load->view('core/core_inicio');
   $this -> load -> view('hce/hce_ordenes',$d);
   //$d['hce_items']=$this->hce_consulta_model->lista_items_hce($d['info_cita']['id_especialidad']);
   $this->load->view('core/core_fin');
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function hce_remision($id_cita)
{
   $this->cargar_datos_basico($id_cita,$d);
   $d['info_cita']=$this->citas_model->detalle_cita($id_cita);
   $d['info_cita']=$d['info_cita'][0];
   $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
   $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
   $d['remision']=$this->hce_consulta_model->remision($id_cita);
   //$d['hce_items']=$this->hce_consulta_model->lista_items_hce($d['info_cita']['id_especialidad']);
   $this->load->view('core/core_inicio');
   $this -> load -> view('hce/hce_remision',$d);
   $this->load->view('core/core_fin');
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function hce_incapacidad($id_cita)
{
   $this->cargar_datos_basico($id_cita,$d);
   $d['info_cita']=$this->citas_model->detalle_cita($id_cita);
   $d['info_cita']=$d['info_cita'][0];
   $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
   $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
   $d['incapacidad']=$this->hce_consulta_model->incapacidad_paciente($id_cita);
   $this->load->view('core/core_inicio');
   $this->load->view('hce/hce_incapacidad',$d);
   $this->load->view('core/core_fin');
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function hce_control($id_cita)
{
   $this->cargar_datos_basico($id_cita,$d);
   $d['info_cita']=$this->citas_model->detalle_cita($id_cita);
   $d['info_cita']=$d['info_cita'][0];
   $d['info_cita']['edad']=$this->lib_edad->edad($d['info_cita']['fecha_nacimiento']);
   $d['info_cita']['tiempo_espera']=$this->lib_edad->edad($d['info_cita']['fecha_solicitud']);
   $d['remision']=$this->hce_consulta_model->control($id_cita);
   //$d['hce_items']=$this->hce_consulta_model->lista_items_hce($d['info_cita']['id_especialidad']);
   $this->load->view('core/core_inicio');
   $this -> load -> view('hce/hce_control',$d);
   $this->load->view('core/core_fin');
}
}
?>
