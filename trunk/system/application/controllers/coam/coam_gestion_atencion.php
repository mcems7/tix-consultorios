<?php
/**
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/**
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Coam_gestion_atencion
 *Tipo: controlador
 *Descripcion: Permite realizar la la cnsulta y la gestion de la atencion del paciente ambulatorio
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 06 de abril de 2012
*/
class Coam_gestion_atencion extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this->load->model('coam/coam_model');
		$this->load->model('core/tercero_model');
		$this->load->model('core/paciente_model'); 
		$this->load->model('urg/urgencias_model'); 	 		
	}
///////////////////////////////////////////////////////////////////
/*
* Vista que permite seleccionar el consultorio
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120406
* @version		20120406
*/	
function index()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	$d['consultorios'] = $this ->coam_model->obtenerConsultorios();
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_sala_espera',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Listado de pacientes en espera en consultorio
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120406
* @version		20120406
*/	
function listadoPacientesConsultorio()
{
	//----------------------------------------------------------
	$id_consultorio 	= $this->input->post('id_consultorio');
	//----------------------------------------------------------
	if($id_consultorio == 0){
		$id_consultorio = $this->session->userdata('id_consultorioCoam');
	}else{
		$this->session->unset_userdata('id_consultorioCoam');
		$this->session->set_userdata('id_consultorioCoam',$id_consultorio);
	}
	$d['lista'] = $this->coam_model->obtPacConsultorio($id_consultorio);
	//----------------------------------------------------------
	$this->load->view('coam/coam_consultorio_detalle',$d);
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Consulta ambulatoria
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120406
* @version		20120406
*/
function consulta_ambulatoria($id_atencion)
{
	//----------------------------------------------------------
	
	$d = array();
	$d['atencion'] = $this->coam_model->obtenerAtencion($id_atencion);
	//----------------------------------------------------------
	$consulta = $d['atencion']['consulta'];
	if($consulta == 'SI'){
		redirect('coam/coam_gestion_atencion/main/'.$id_atencion);
	}
	//----------------------------------------------------------
	$d['urlRegresar'] = site_url('coam/coam_gestion_atencion/index');
	$d['paciente'] =$this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['entidad'] =$this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['tercero'] =$this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['causa_externa'] = $this->coam_model->obtenerListaCausaExterna();
	$d['finalidad'] = $this->coam_model->obtenerListaFinalidad();
//Verifica si el usuario del sistema esta creado como medico para poder acceder a la consulta
	if(!$d['id_medico'])
	{
		$dt['mensaje']  = "El usuario ".$this->session->userdata('_username')." no se encuentra asignado al personal medico!!";
		$dt['urlRegresar'] 	= site_url("coam/coam_gestion_atencion/index");
		$this->load->view('core/presentacionMensaje', $dt);
		return;	
	}
	$this->coam_model->cambiar_estado($id_atencion,'2');
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_consulta_ambulatoria', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
/*
* Recibe la información consignada en la consulta ambulatoria

*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120406
* @version		20120406
*/
function consulta_ambulatoria_()
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['motivo_consulta'] = mb_strtoupper($this->input->post('motivo_consulta'),'utf-8');
	$d['enfermedad_actual'] = mb_strtoupper($this->input->post('enfermedad_actual'),'utf-8');
	$d['revicion_sistemas'] = mb_strtoupper($this->input->post('revicion_sistemas'),'utf-8');
	$d['ant_patologicos'] = mb_strtoupper($this->input->post('ant_patologicos'),'utf-8');
	$d['ant_famacologicos'] = mb_strtoupper($this->input->post('ant_famacologicos'),'utf-8');
	$d['ant_toxicoalergicos'] = mb_strtoupper($this->input->post('ant_toxicoalergicos'),'utf-8');
	$d['ant_quirurgicos'] = mb_strtoupper($this->input->post('ant_quirurgicos'),'utf-8');
	$d['ant_familiares'] = mb_strtoupper($this->input->post('ant_familiares'),'utf-8');
	$d['ant_ginecologicos'] = mb_strtoupper($this->input->post('ant_ginecologicos'),'utf-8');
	$d['ant_otros'] = mb_strtoupper($this->input->post('ant_otros'),'utf-8');
	$d['condiciones_generales'] = mb_strtoupper($this->input->post('condiciones_generales'),'utf-8');
	$d['talla'] = $this->input->post('talla');
	$d['peso'] = $this->input->post('peso');		
	$d['frecuencia_cardiaca'] = $this->input->post('frecuencia_cardiaca');
	$d['frecuencia_respiratoria'] = $this->input->post('frecuencia_respiratoria');
	$d['ten_arterial_s'] = $this->input->post('ten_arterial_s');
	$d['ten_arterial_d'] = $this->input->post('ten_arterial_d');
	$d['temperatura'] = $this->input->post('temperatura');
	$d['spo2'] = $this->input->post('spo2');
	$d['exa_cabeza'] = mb_strtoupper($this->input->post('exa_cabeza'),'utf-8');
	$d['exa_ojos'] = mb_strtoupper($this->input->post('exa_ojos'),'utf-8');
	$d['exa_oral'] = mb_strtoupper($this->input->post('exa_oral'),'utf-8');
	$d['exa_cuello'] = mb_strtoupper($this->input->post('exa_cuello'),'utf-8');
	$d['exa_dorso'] = mb_strtoupper($this->input->post('exa_dorso'),'utf-8');
	$d['exa_torax'] = mb_strtoupper($this->input->post('exa_torax'),'utf-8');
	$d['exa_abdomen'] = mb_strtoupper($this->input->post('exa_abdomen'),'utf-8');
	$d['exa_genito_urinario'] = mb_strtoupper($this->input->post('exa_genito_urinario'),'utf-8');
	$d['exa_extremidades'] = mb_strtoupper($this->input->post('exa_extremidades'),'utf-8');
	$d['exa_neurologico'] = mb_strtoupper($this->input->post('exa_neurologico'),'utf-8');
	$d['exa_piel'] = mb_strtoupper($this->input->post('exa_piel'),'utf-8');
	$d['exa_mental'] = mb_strtoupper($this->input->post('exa_mental'),'utf-8');
	$d['dx'] = $this->input->post('dx_ID_');
	$d['tipo_dx'] = $this->input->post('tipo_dx_');
	$d['analisis'] = mb_strtoupper($this->input->post('analisis'),'utf-8');
	$d['conducta'] = mb_strtoupper($this->input->post('conducta'),'utf-8');
	$d['id_medico'] = $this->input->post('id_medico');
	$d['id_atencion'] = $this->input->post('id_atencion');
	$d['fecha_ini_consulta'] = $this->input->post('fecha_ini_consulta');
	$d['id_causa_externa'] = $this->input->post('id_causa_externa');
	$d['id_finalidad'] = $this->input->post('id_finalidad');
	//----------------------------------------------------------
	$r = $this->coam_model->consulta_ambulatoriaDb($d);
	if($r['error'])
	{
		$this->Registro->agregar($this->session->userdata('id_usuario'),'coam',__CLASS__,__FUNCTION__
		,'aplicacion',"Error en la creación de la consulta id ".$d['id_atencion']);
		$dat['mensaje'] = "La operación no se realio con exito.";
		$dat['urlRegresar'] = site_url('coam/coam_gestion_atencion/index');
		$this->load->view('core/presentacionMensaje', $dat);
		return;
	}
	//----------------------------------------------------
	$dt['mensaje']  = "Los datos de la consulta se han almacenado correctamente!!";
	$dt['urlRegresar'] 	= site_url("coam/coam_gestion_atencion/main/".$d['id_atencion']);
	$this->load->view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Gestion de la atencion de un paciente consulta ambulatoria
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120406
* @version		20120406
*/	
function main($id_atencion)
{
	
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('coam/coam_gestion_atencion/index');
	//----------------------------------------------------------
	$d['atencion'] = $this->coam_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['consulta'] = $this->coam_model->obtenerNotaInicial($id_atencion);
	$d['dxCon'] = $this->coam_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['rem'] = $this->coam_model->obtenerRemisiones($id_atencion);
	$d['inca'] = $this->coam_model->obtenerIncapacidades($id_atencion);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_gestion_atencion', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
/*
* Permite consultar el contenido de la consulta
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120406
* @version		20120406
*/
function consultaNotaInicial($id_atencion)
{
	
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] = site_url('coam/coam_gestion_atencion/main/'.$id_atencion);
	//----------------------------------------------------------
	$d['atencion'] = $this->coam_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['consulta'] = $this->coam_model->obtenerNotaInicial($id_atencion);
	$d['consulta_ant'] = $this->coam_model->obtenerNotaInicial_ant($d['consulta']['id_consulta']);
	$d['consulta_exa'] = $this->coam_model->obtenerNotaInicial_exa($d['consulta']['id_consulta']);
	$d['tipo_usuario'] = $this->paciente_model->tipos_usuario();
	$d['dx'] = $this->coam_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['consulta']['id_medico']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_consulta_ambulatoria_consulta',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/**
* Permite generar una incapacidad para el paciente
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120406
* @version		20120406
*/
function incapacidad($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('coam/coam_gestion_atencion/main/'.$id_atencion);
	
	$this->load->model('core/medico_model');
	//----------------------------------------------------------
	$d['atencion'] = $this->coam_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['consulta'] = $this->coam_model->obtenerNotaInicial($id_atencion);
	$d['especialidades']= $this -> medico_model -> tipos_especialidades();
	$d['dxCon'] = $this->coam_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_incapacidad', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
/**
* Almacena la información de la incapacidad
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120415
* @version		20120415
*/
function incapacidad_()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['id_atencion'] = $this->input->post('id_atencion');
	$d['id_medico'] = $this->input->post('id_medico');
	$d['fecha_inicio'] = $this->input->post('fecha_inicio');
	$d['duracion'] = $this->input->post('duracion');
	$d['observacion'] = mb_strtoupper($this->input->post('observacion'),'utf-8');
	//----------------------------------------------------------
	$id_inca = $this->coam_model->incapacidadDb($d);
	//----------------------------------------------------------
	$dt['mensaje']  = "Los datos de la incapacidad se han almacenado correctamente!!";
	$dt['urlRegresar'] 	= site_url("coam/coam_gestion_atencion/incapacidad_consulta/".$id_inca);
	$this->load->view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------
}
/**
* Consulta la remisión
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120415
* @version		20120415
*/
function incapacidad_consulta($id_remision)
{
	//----------------------------------------------------------
	$d = array();
	
	
	$this -> load -> model('core/medico_model');
	//----------------------------------------------------------
	$d['inca'] = $this->coam_model->obtenerIncapacidad($id_remision);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['inca']['id_medico']);
	$d['atencion'] = $this->coam_model->obtenerAtencion($d['inca']['id_atencion']);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['consulta'] = $this->coam_model->obtenerNotaInicial($d['inca']['id_atencion']);
	$d['dxCon'] = $this->coam_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	
	$d['urlRegresar'] 	= site_url('coam/coam_gestion_atencion/main/'.$d['inca']['id_atencion']);
	
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_incapacidad_consulta', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
/**
* Permite generar la remision del paciente
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120406
* @version		20120406
*/
function remision($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('coam/coam_gestion_atencion/main/'.$id_atencion);
	
	$this -> load -> model('core/medico_model');
	//----------------------------------------------------------
	$d['atencion'] = $this->coam_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['consulta'] = $this->coam_model->obtenerNotaInicial($id_atencion);
	$d['especialidades']= $this -> medico_model -> tipos_especialidades();
	$d['dxCon'] = $this->coam_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_remision', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
/**
* Almacena la información de la remision
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120415
* @version		20120415
*/
function remision_()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['id_atencion'] = $this->input->post('id_atencion');
	$d['id_medico'] = $this->input->post('id_medico');
	$d['id_especialidad'] = $this->input->post('id_especialidad');
	$d['motivo_remision'] = mb_strtoupper($this->input->post('motivo_remision'),'utf-8');
	$d['observacion'] = mb_strtoupper($this->input->post('observacion'),'utf-8');
	//----------------------------------------------------------
	$id_remision = $this->coam_model->remisionDb($d);
	//----------------------------------------------------------
	$dt['mensaje']  = "Los datos de la remision se han almacenado correctamente!!";
	$dt['urlRegresar'] 	= site_url("coam/coam_gestion_atencion/remision_consulta/".$id_remision);
	$this->load->view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/**
* Consulta la remisión
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120415
* @version		20120415
*/
function remision_consulta($id_remision)
{
	//----------------------------------------------------------
	$d = array();
	
	
	$this -> load -> model('core/medico_model');
	//----------------------------------------------------------
	$d['remision'] = $this->coam_model->obtenerRemision($id_remision);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['remision']['id_medico']);
	$d['atencion'] = $this->coam_model->obtenerAtencion($d['remision']['id_atencion']);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['consulta'] = $this->coam_model->obtenerNotaInicial($d['remision']['id_atencion']);
	$d['dxCon'] = $this->coam_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	
	$d['urlRegresar'] 	= site_url('coam/coam_gestion_atencion/main/'.$d['remision']['id_atencion']);
	
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_remision_consulta', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
/**
* Permite finalizar la atención del paciente
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120406
* @version		20120406
*/
function finalizar_atencion($id_atencion)
{
	$this->coam_model->finalizar_atencionDb($id_atencion);
	
	$this->Registro->agregar($this->session->userdata('id_usuario'),'coam',__CLASS__,__FUNCTION__
		,'aplicacion',"Atencion finalizada id ".$id_atencion);
		$dat['mensaje'] = "La atención ha finalizado!!.";
		$dat['urlRegresar'] = site_url('coam/coam_gestion_atencion/index');
		$this->load->view('core/presentacionMensaje', $dat);
		return;
}
///////////////////////////////////////////////////////////////////
/*
* Ingreso de justificación de retiro voluntaria del paciente
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120421
* @version		20120421
*/	
function retiro_voluntario($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['urlRegresar'] 	= site_url('coam/coam_gestion_atencion/index');
	//----------------------------------------------------------
	
	$d['atencion'] = $this -> coam_model -> obtenerAtencion($id_atencion);
	
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('coam/coam_retiro_voluntario', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function retiro_voluntario_()
{
	$d['id_atencion'] = $this->input->post('id_atencion');
	$d['password'] = $this->input->post('password');
	
	$res = $this->urgencias_model->comprobarPassword($d);

	if($res){
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
	
	$this->coam_model->retiroVoluntario($d);	
	
	redirect('coam/coam_gestion_atencion/index');
	
	}else{
	//----------------------------------------------------
	$dt['mensaje']  = "La contraseña no corresponde!!";
	$dt['urlRegresar'] 	= site_url('coam/coam_gestion_atencion/retiro_voluntario/'.$d['id_atencion']);
	$this -> load -> view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------	
	}	
}
///////////////////////////////////////////////////////////////////
function no_responde($id_atencion)
{
	$this->coam_model->no_respondeDB($id_atencion);	
	//----------------------------------------------------
	$dt['mensaje']  = "El paciente ha sido retirado de la lista!!";
	$dt['urlRegresar'] 	= site_url('coam/coam_gestion_atencion/index');
	$this -> load -> view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
function calculo_imc()
{
	$talla = $this->input->post('talla');
	$peso = $this->input->post('peso');
	
	echo $this->lib_ope->imc($talla,$peso);
}
///////////////////////////////////////////////////////////////////
}
?>