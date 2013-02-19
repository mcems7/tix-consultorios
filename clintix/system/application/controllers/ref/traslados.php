<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Traslados
 *Tipo: controlador
 *Descripcion: Permite administrar las gestiones para traslado de pacientes
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 27 de abril de 2012
*/
class Traslados extends Controller
{
///////////////////////////////////////////////////////////////////
function __construct()
{
	parent::Controller();			
	$this->load->model('auto/autorizaciones_model'); 
	$this->load->model('ref/ref_model'); 
	$this->load->model('urg/urgencias_model');	
	$this->load->model('core/paciente_model');
	$this->load->model('core/tercero_model');
	$this->load->model('hosp/hosp_model');   	 		
}
///////////////////////////////////////////////////////////////////
function index($tipo = 0,$estado  = 'SI')
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	$d['lista'] = $this->ref_model->obtener_traslados_activos($tipo,$estado);
	$d['tipo'] = $tipo;
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('ref/ref_principal',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Buscar la existencia de un paciente en el sistema
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120305
* @version		20120305
*/	
function buscarPaciente()
{
	//----------------------------------------------------------
	$d = array();
	$d['numero_documento'] 	= $this->input->post('numero_documento');
	//----------------------------------------------------------
	
	//Verifica las atenciones activas de urgencias
	$verAten = $this ->autorizaciones_model->verificarAtencionUrg($d);
	
	if($verAten != 0){
		$d['listaUrg'] = $verAten;
		$d['listaHosp'] = array();
		
	}else{
		$d['listaUrg'] = array();
		//Verifica atenciones activas en hospitalización 
		$verAtenHosp = $this->hosp_model->verificarAtencionHosp($d['numero_documento']);
		
		if($verAtenHosp != 0){
			$d['listaHosp'] = $verAtenHosp;
		}else{
			$d['listaHosp'] = array();
		}
	}
	
	echo $this->load->view('ref/ref_listado_atenciones',$d);
	
}
///////////////////////////////////////////////////////////////////
function crear_traslado($id_atencion,$ser)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('ref/traslados/index');
	if($ser == 'urg'){
		//----------------------------------------------------------
		$d['atencion'] = $this->urgencias_model->obtenerAtencion($id_atencion);
		$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['atencion']['id_entidad']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['dx'] = $this->urgencias_model->obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dx_evo'] = $this->urgencias_model ->obtenerDxEvoluciones($id_atencion);
		//----------------------------------------------------------
	}else if($ser == 'hosp'){
		$d['atencion'] = $this->hosp_model->obtenerAtencion($id_atencion);
		$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);	
		$d['dx'] = $this->hosp_model->obtenerDxAtencion($id_atencion);
		//----------------------------------------------------------
	}
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('ref/ref_traslado_crear',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function crear_traslado_()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['id_paciente'] = $this->input->post('id_paciente');
	$d['id_atencion'] = $this->input->post('id_atencion');
	$d['fecha_solicitud'] = $this->input->post('fecha_solicitud');
	$d['tramite'] = mb_strtoupper($this->input->post('tramite'),'utf-8');
	$d['tipo_traslado'] = $this->input->post('tipo_traslado');
	$d['prioridad'] = $this->input->post('prioridad');
	$d['fecha_orden'] = $this->input->post('fecha_orden');
	$d['procedimiento'] = mb_strtoupper($this->input->post('procedimiento'),'utf-8');
	$d['medico_remite'] = mb_strtoupper($this->input->post('medico_remite'),'utf-8');
	//----------------------------------------------------------
	$this->ref_model->crear_trasladoDB($d);
	redirect('ref/traslados/index');
}
///////////////////////////////////////////////////////////////////
function gestionar_traslado($id_traslado)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('ref/traslados/index');
	//----------------------------------------------------------
	$d['usuario']  = $this->ref_model->obtenerUsuario($this->session->userdata('id_usuario'));
	$d['traslado'] = $this->ref_model->obtener_traslado($id_traslado);
	if($d['traslado']['autorizacion'] == 'SI')
	{
		$d['auto'] = $this->ref_model->obtener_autorizacion($id_traslado);
	}
	$d['notas'] =$this->ref_model->obtener_notas($id_traslado);
	if($d['traslado']['id_atencion'] >= 10000000 ){
		$d['atencion'] = $this->hosp_model->obtenerAtencion($d['traslado']['id_atencion']);
		$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);	
		$d['dx'] = $this->hosp_model->obtenerDxAtencion($d['traslado']['id_atencion']);
	}else{
		$d['atencion'] = $this->urgencias_model->obtenerAtencion($d['traslado']['id_atencion']);
		$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['atencion']['id_entidad']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($d['traslado']['id_atencion']);
		$d['dx'] = $this->urgencias_model->obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dx_evo'] = $this->urgencias_model ->obtenerDxEvoluciones($d['traslado']['id_atencion']);
	}
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('ref/ref_traslado_gestionar',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function agregar_nota()
{
	//----------------------------------------------------------
	$d = array();
	$data = array();
	$d['id_tramite'] = $this->input->post('id_tramite');	
	$d['nota'] = mb_strtoupper($this->input->post('nota'),'utf-8');
	$d['tipo_nota'] = $this->input->post('tipo_nota');	
	$d['id_traslado'] = $this->input->post('id_traslado');	
	$id_nota = $this->ref_model->agregar_notaDB($d);
	$data['nota']=$this->ref_model->obtener_nota($id_nota);
	echo $this->load->view('ref/ref_traslado_nota_info',$data);
}
///////////////////////////////////////////////////////////////////
function agregar_autorizacion()
{
	//----------------------------------------------------------
	$d = array();
	$d['id_traslado'] = $this->input->post('id_traslado');	
	$d['obs_autorizacion'] = mb_strtoupper($this->input->post('obs_autorizacion'),'utf-8');
	$d['autorizacion'] = $this->input->post('autorizacion');	
	$d['fecha_autorizacion'] = $this->input->post('fecha_autorizacion');	
	$this->ref_model->agregar_autorizacionDB($d);
}
///////////////////////////////////////////////////////////////////
function finalizar_traslado($id_traslado)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('ref/traslados/index');
	//----------------------------------------------------------
	$d['usuario']  = $this->ref_model->obtenerUsuario($this->session->userdata('id_usuario'));
	$d['traslado'] = $this->ref_model->obtener_traslado($id_traslado);
	if($d['traslado']['autorizacion'] == 'SI')
	{
		$d['auto'] = $this->ref_model->obtener_autorizacion($id_traslado);
	}
	$d['notas'] =$this->ref_model->obtener_notas($id_traslado);
	if($d['traslado']['id_atencion'] >= 10000000 ){
		$d['atencion'] = $this->hosp_model->obtenerAtencion($d['traslado']['id_atencion']);
		$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);	
		$d['dx'] = $this->hosp_model->obtenerDxAtencion($d['traslado']['id_atencion']);
	}else{
		$d['atencion'] = $this->urgencias_model->obtenerAtencion($d['traslado']['id_atencion']);
		$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['atencion']['id_entidad']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($d['traslado']['id_atencion']);
		$d['dx'] = $this->urgencias_model->obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dx_evo'] = $this->urgencias_model ->obtenerDxEvoluciones($d['traslado']['id_atencion']);
	}
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('ref/ref_traslado_finalizar',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function finalizar_traslado_()
{
	//----------------------------------------------------------
	$d = array();
	$d['id_traslado'] = $this->input->post('id_traslado');
	$d['traslado_realizado'] = $this->input->post('traslado_realizado');
	$d['muere_traslado'] = $this->input->post('muere_traslado');
	$d['motivo_no_traslado'] = $this->input->post('motivo_no_traslado');
	$d['fecha_traslado'] = $this->input->post('fecha_traslado');
	$d['movil'] = $this->input->post('movil');
	$d['conductor'] = $this->input->post('conductor');
	$d['paramedico'] = $this->input->post('paramedico');
	$d['medico'] = $this->input->post('medico');
	$d['observacion'] = $this->input->post('observacion');
	//----------------------------------------------------------
	$this->ref_model->finalizar_trasladoDB($d);
	//----------------------------------------------------------
	redirect('ref/traslados/index');	
}
///////////////////////////////////////////////////////////////////
}
?>