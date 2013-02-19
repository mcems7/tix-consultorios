<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/**
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hospi_gestion_atencion
 *Tipo: controlador
 *Descripcion: Permite realizar la admision del paciente a hospitalizacion
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 08 de marzo de 2012
*/
class Hospi_gestion_atencion extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this->load->model('hospi/hospi_model');
		$this->load->model('core/tercero_model');
		$this->load->model('core/paciente_model'); 
		$this->load->model('urg/urgencias_model');	
		$this->load->model('core/medico_model'); 		
	}
///////////////////////////////////////////////////////////////////
/**
* Vista que permite seleccionar el servicio a gestionar
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120305
* @version		20120305
*/	
function index()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	$d['estados'] = $this->hospi_model->obtenerEstadosCamas();
	$d['servicios'] = $this ->hospi_model->obtenerServicios();
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_camas', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/**
* Lista el estado de las camas de un servicio indicado
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120305
* @version		20120305
*/	
function listadoPacientesPiso()
{
	//----------------------------------------------------------
	$id_servicio 	= $this->input->post('id_servicio');
	//----------------------------------------------------------
	if($id_servicio == 0){
		$id_servicio = $this->session->userdata('id_servicioHospi');
	}else{
		$this->session->unset_userdata('id_servicioHospi');
		$this->session->set_userdata('id_servicioHospi',$id_servicio);
	}
	$id_estado 	= $this->input->post('estado');
	$d['lista'] = $this->hospi_model->obtPacPendientesCamaServicio($id_servicio);
	$d['camas'] = $this->hospi_model->obtenerCamasServicio($id_servicio,$id_estado);
	//----------------------------------------------------------
	$this->load->view('hospi/hospi_piso_detalle',$d);
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/**
* Muestra el listado de camas disponibles
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120309
* @version		20120309
* @return		HTML
*/	
function ingresoServicio($id_atencion,$id_servicio)
{
	$camas = $this->hospi_model->obtenerCamasDispoServicio($id_servicio);
	if(count($camas)>0)
	{
		$cadena = '';
		$cadena .='<select name="id_cama" id="id_cama">';
		$cadena .='<option value="0">-Disponibles-</option>';
		foreach($camas as $d)
		{
		$cadena .='<option value="'.$d['id_cama'].'">'.$d['numero_cama'].'</option>';	
		}
		$cadena .= '</select>';
		$data = array(	'name' => 'bv',
		'onclick' => "asignarCama('".$id_atencion."')",
		'value' => 'Asignar',
		'type' =>'button');
		$cadena .= form_input($data);
	}else{
		$cadena = 'No hay camas disponibles';
	}
	echo $cadena;
}
///////////////////////////////////////////////////////////////////
/**
* Accion que permite asignar cama al paciente
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120309
* @version		20120309
*/	
function ingresoServicioCama($id_servicio,$id_cama)
{
	$this->hospi_model->ingresoServicioDd($id_servicio,$id_cama);
	$cama =$this->hospi_model->detalleCama($id_cama);
	echo $cama['numero_cama'];
}
///////////////////////////////////////////////////////////////////
/**
* Accion que permite activar una cama
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120309
* @version		20120309
*/	
function activarCama($id_cama)
{	
	//----------------------------------------------------------
	$id_servicio 	= $this->input->post('id_servicio');
	$id_estado 	= 0;
	$this->hospi_model->activarCamaServicio($id_cama);
	$d['lista'] = $this->hospi_model->obtPacPendientesCamaServicio($id_servicio);
	$d['camas'] = $this->hospi_model->obtenerCamasServicio($id_servicio,$id_estado);
	//----------------------------------------------------------
	$this->load->view('hospi/hospi_piso_detalle',$d);
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/**
* Nota inicial de ingreso al servicio
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20101109
* @version		20101109
*/
function notaInicial($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	//----------------------------------------------------------
	$consulta = $d['atencion']['consulta'];
	if($consulta == 'SI'){
		redirect('hospi/hospi_gestion_atencion/main/'.$id_atencion);
	}
	//----------------------------------------------------------
	if($d['atencion']['via_urg'] == 'SI'){
		$id_aten_urg = $d['atencion']['id_aten_urg'];
		redirect('hospi/hospi_gestion_atencion/notaInicialEdit/'.$id_atencion.'/'.$id_aten_urg);
	}
	//----------------------------------------------------------
	$d['urlRegresar'] = site_url('hospi/hospi_gestion_atencion/index');
	$d['paciente'] =$this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['entidad'] =$this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['tercero'] =$this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
//Verifica si el usuario del sistema esta creado como medico para poder acceder a la consulta
	if(!$d['id_medico'])
	{
		$dt['mensaje']  = "El usuario ".$this->session->userdata('_username')." no se encuentra asignado al personal medico!!";
		$dt['urlRegresar'] 	= site_url("hospi/hospi_gestion_atencion/index");
		$this->load->view('core/presentacionMensaje', $dt);
		return;	
	}
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_nota_inicial', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
/**
* Nota inicial de ingreso al servicio basada en la de Urgencias
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120504
* @version		20120504
*/
function notaInicialEdit($id_atencion,$id_aten_urg)
{
	//----------------------------------------------------------
	$d = array();
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	//----------------------------------------------------------
	$d['urlRegresar'] = site_url('hospi/hospi_gestion_atencion/index');
	$d['paciente'] =$this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['entidad'] =$this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['tercero'] =$this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
//Verifica si el usuario del sistema esta creado como medico para poder acceder a la consulta
	if(!$d['id_medico'])
	{
		$dt['mensaje']  = "El usuario ".$this->session->userdata('_username')." no se encuentra asignado al personal medico!!";
		$dt['urlRegresar'] 	= site_url("hospi/hospi_gestion_atencion/index");
		$this->load->view('core/presentacionMensaje', $dt);
		return;	
	}
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	//-----------------------------------------------------------
	$d['consulta'] = $this->urgencias_model->obtenerConsulta($id_aten_urg);
	$d['consulta_ant'] = $this->urgencias_model->obtenerConsulta_ant($d['consulta']['id_consulta']);
	$d['consulta_exa'] = $this->urgencias_model->obtenerConsulta_exa($d['consulta']['id_consulta']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['dx'] = $this->urgencias_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_nota_inicial_edit', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
/**
* Recibe la información consignada en la nota inicial. historia clinica
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120309
* @version		20120309
*/
function notaInicial_()
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
	//----------------------------------------------------------
	$r = $this->hospi_model->notaInicialDb($d);
	if($r['error'])
	{
		$this->Registro->agregar($this->session->userdata('id_usuario'),'hospi',__CLASS__,__FUNCTION__
		,'aplicacion',"Error en la creación de la nota inicial id ".$d['id_atencion']);
		$dat['mensaje'] = "La operación no se realio con exito.";
		$dat['urlRegresar'] = site_url('hospi/hospi_gestion_atencion/index');
		$this->load->view('core/presentacionMensaje', $dat);
		return;
	}
	//----------------------------------------------------
	$dt['mensaje']  = "Los datos de la nota inicial se han almacenado correctamente!!";
	$dt['urlRegresar'] 	= site_url("hospi/hospi_gestion_atencion/main/".$d['id_atencion']);
	$this->load->view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/**
* Gestion de la atencion de un paciente hospitalizado
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20101103
* @version		20101103
*/	
function main($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hospi/hospi_gestion_atencion/index');
	//----------------------------------------------------------
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['consulta'] = $this->hospi_model->obtenerNotaInicial($id_atencion);
	$d['dxCon'] = $this->hospi_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['dxEvo'] = $this->hospi_model->obtenerDxEvoluciones($id_atencion);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_gestion_atencion', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
/**
* Muestra la opcion de cambiar un paciente de cama
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120310
* @version		20120310
* @return		HTML
*/	
function cambiarCamaHospi($id_atencion)
{
	$aten = $this->hospi_model->obtenerAtencion($id_atencion);
	$camas = $this->hospi_model->obtenerCamasDispoServicio($aten['id_servicio']);
	if(count($camas)>0)
	{
		$cadena = '';
		$cadena .='<select name="id_cama" id="id_cama">';
		$cadena .='<option value="0">-Disponibles-</option>';
		foreach($camas as $d)
		{
			$cadena .='<option value="'.$d['id_cama'].'">'.$d['numero_cama'].'</option>';	
		}
		$cadena .= '</select>';
		$data = array(	'name' => 'bv',
			'onclick' => "asignarCama('".$aten['id_atencion']."')",
			'value' => 'Asignar',
			'type' =>'button');
		$cadena .= form_input($data);
	}else{
		$cadena = 'No hay camas disponibles';
	}
	echo $cadena;
}
///////////////////////////////////////////////////////////////////
/**
* Realiza el cambio de la cama
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120310
* @version		20120310
* @return		HTML
*/
function cambiarHospiCama($id_atencion,$id_cama)
{
	$aten = $this->hospi_model->obtenerAtencion($id_atencion);
	$this->hospi_model->cambiarCamaHospiDb($id_atencion,$id_cama);
	$this->hospi_model->liberarCama($aten['id_cama']);
	$cama = $this->hospi_model->detalleCama($id_cama);
	echo $cama['numero_cama'];
}
///////////////////////////////////////////////////////////////////
/**
* Permite consultar el contenido de la nota de atencion inicial
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120310
* @version		20120310
*/
function consultaNotaInicial($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] = site_url('hospi/hospi_gestion_atencion/main/'.$id_atencion);
	//----------------------------------------------------------
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['consulta'] = $this->hospi_model->obtenerNotaInicial($id_atencion);
	$d['consulta_ant'] = $this->hospi_model->obtenerNotaInicial_ant($d['consulta']['id_consulta']);
	$d['consulta_exa'] = $this->hospi_model->obtenerNotaInicial_exa($d['consulta']['id_consulta']);
	$d['tipo_usuario'] = $this->paciente_model->tipos_usuario();
	$d['dx'] = $this->hospi_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['consulta']['id_medico']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);
	$d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_nota_inicial_consulta',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/**
* Epicrisis y salida de paciente hospitalizado
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120416
* @version		20120416
*/
function epicrisis($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	
	$d['urlRegresar'] 	= site_url('hospi/hospi_gestion_atencion/main/'.$id_atencion);
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['consulta'] = $this->hospi_model->obtenerNotaInicial($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['dxCon'] = $this->hospi_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['dxEvo'] = $this->hospi_model->obtenerDxEvoluciones($id_atencion);
	$d['evo'] = $this->hospi_model->obtenerEvoluciones($id_atencion);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	$d['entidad'] = $this->urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	$d['mediAtencion'] = $this->hospi_model ->obtenerMediAtencion($id_atencion);
	$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
	$d['especialidades']= $this->medico_model->tipos_especialidades();
	$d['destino'] = $this->hospi_model->obtenerDestinos();
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_epicrisis',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/**
* Epicrisis y salida de paciente hospitalizado
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120416
* @version		20120416
*/
function epicrisis_()
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['id_atencion'] 		= $this->input->post('id_atencion');
	$d['id_medico'] 		= $this->input->post('id_medico');
	$d['fecha_egreso'] 		= $this->input->post('fecha_egreso');
	$d['id_servicio'] 		= $this->input->post('id_servicio');
	$d['estado_salida'] 	= $this->input->post('estado_salida');
	$d['tiempo_muerto'] 	= $this->input->post('tiempo_muerto');
	$d['incapacidad'] 		= $this->input->post('incapacidad');
	$d['incapacidad_dias'] 	= $this->input->post('incapacidad_dias');
	$d['dxI'] 				= $this->input->post('dxI');
	$d['dxE'] 				= $this->input->post('dxE');
	$d['examenes_auxiliares'] = $this->input->post('examenes_auxiliares');
	$d['evos']	 			= $this->input->post('evos');
	$d['traslado'] 			= $this->input->post('traslado');
	$d['nivel_traslado'] 	= $this->input->post('nivel_traslado');
	$d['lugar_traslado'] 	= $this->input->post('lugar_traslado');
	$d['cita_con_ext'] 		= $this->input->post('cita_con_ext');
	$d['id_especialidad'] 	= $this->input->post('id_especialidad');
	$d['cita_conext'] 		= $this->input->post('cita_conext');
	$d['cita_hosp_local'] 	= $this->input->post('cita_hosp_local');
	$d['municipio_cita'] 	= $this->input->post('municipio_cita');
	$d['cita_hopslocal'] 	= $this->input->post('cita_hopslocal');
	$d['id_destino'] 		= $this->input->post('id_destino');
	//----------------------------------------------------------
	$d['atencion'] 			= $this->hospi_model->obtenerAtencion($d['id_atencion']);
	$this->hospi_model->liberarCama($d['atencion']['id_cama']);
	//----------------------------------------------------------
	$r = $this ->hospi_model->epicrisisDb($d);	
	
	if($r['error'])
	{
	$this->Registro->agregar($this->session->userdata('id_usuario'),'hospi',__CLASS__,__FUNCTION__
	,'aplicacion',"Error en la creación de la apicrisis id atencion".$d['id_atencion']);
	$dat['mensaje'] = "La operación no se realizo con exito.";
	$dat['urlRegresar'] = site_url('hospi/salas/index');
	$this->load->view('core/presentacionMensaje', $dat);
	return;
	}	
	
	//----------------------------------------------------
	$dt['mensaje']  = "La epicrisis se ha almacenado correctamente!!";
	$dt['urlRegresar'] 	= site_url("hospi/hospi_gestion_atencion/epicrisis_consulta/".$d['id_atencion']);
	$this->load->view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------

}
///////////////////////////////////////////////////////////////////
function epicrisis_consulta($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hospi/hospi_gestion_atencion/index');
	$d['epicrisis'] = $this->hospi_model->obtenerEpicrisis($id_atencion);
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['evo'] = $this->hospi_model->obtenerEvosEpicrisis($d['epicrisis']['id_epicrisis']);
	$d['consulta'] = $this->hospi_model->obtenerNotaInicial($id_atencion);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['dxI'] = $this->hospi_model->obtenerDxEpiI($d['epicrisis']['id_epicrisis']);
	$d['dxE'] = $this->hospi_model->obtenerDxEpiE($d['epicrisis']['id_epicrisis']);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	$d['entidad'] = $this->urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	$d['mediAtencion'] = $this->hospi_model ->obtenerMediAtencion($id_atencion);
	$d['origen'] = $this->urgencias_model->obtenerOrigenAtencion($d['atencion']['id_origen']);
	$d['especialidades']= $this->medico_model->tipos_especialidades();
	$d['destino'] = $this->hospi_model->obtenerDestinos();
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_epicrisis_consulta',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Consultar una evolución epicrisis
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright	GNU GPL 3.0
* @since		20120416
* @version		20120416
*/	
function consultaEvolucion($id_evolucion)
{
	$d = array();
	$d['evo'] = $this->hospi_model->obtenerEvolucion($id_evolucion);
	$d['dxEvo'] = $this->hospi_model->obtenerDxEvolucion($id_evolucion);
	echo $this->load->view('hospi/hospi_piso_evo_consulta',$d);
}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>
