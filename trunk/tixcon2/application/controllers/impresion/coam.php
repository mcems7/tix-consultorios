<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/**
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: Coam
 *Tipo: controlador
 *Descripcion: Genera las vistas para la impresión en papel de las atenciones a los usuarios
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 15 de abril de 2012
*/
class Coam extends CI_Controller
{
///////////////////////////////////////////////////////////////////
function __construct()
{
	parent::__construct(); 
	$this->load->model('urg/urgencias_model');
	$this->load->model('core/medico_model');
	$this->load->model('coam/coam_model');
	 $this -> load -> model('impresion/hospi/hospi_impresion_model');
	$this->load->model('core/paciente_model');
	$this->load->model('core/tercero_model');
	
}
///////////////////////////////////////////////////////////////////
public function remision($id_remision)
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['remision'] = $this->coam_model->obtenerRemision($id_remision);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['remision']['id_medico']);
	$d['atencion'] = $this->coam_model->obtenerAtencion($d['remision']['id_atencion']);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['atencion']['id_entidad']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['consulta'] = $this->coam_model->obtenerNotaInicial($d['remision']['id_atencion']);
	$d['dxCon'] = $this->coam_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	 $d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
	//---------------------------------------------------------------
	$this->load->view('impresion/coam/remision',$d);
	//---------------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
public function incapacidad($id_incapacidad)
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['inca'] = $this->coam_model->obtenerIncapacidad($id_incapacidad);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['inca']['id_medico']);
	$d['atencion'] = $this->coam_model->obtenerAtencion($d['inca']['id_atencion']);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['atencion']['id_entidad']);
	$d['tipo_usuario']	= $this->paciente_model->tipos_usuario();
	$d['consulta'] = $this->coam_model->obtenerNotaInicial($d['inca']['id_atencion']);
	$d['dxCon'] = $this->coam_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
	//---------------------------------------------------------------
	$this->load->view('impresion/coam/incapacidad',$d);
	//---------------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
public function consultaInicial($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
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
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['atencion']['id_entidad']);
	$d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();
	$d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
	//-----------------------------------------------------------
	$this->load->view('impresion/coam/consultaInicial',$d);
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
public function ordenMed($id_orden)
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['orden'] = $this->coam_model->obtenerOrden($id_orden);
	$d['ordenMedi'] = $this->coam_model->obtenerMediOrden($d['orden']['id_orden']);
	$id_atencion = $d['orden']['id_atencion'];
	$d['atencion'] = $this->coam_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['atencion']['id_entidad']);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['orden']['id_medico']);
	$d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
	//-----------------------------------------------------------
	$this->load->view('impresion/coam/ordenMed',$d);
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
public function ordenCups($id_orden)
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['orden'] = $this->coam_model->obtenerOrden($id_orden);
	$d['ordenCups'] = $this->coam_model->obtenerCupsOrden($d['orden']['id_orden']);
	$id_atencion = $d['orden']['id_atencion'];
	$d['atencion'] = $this->coam_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['orden']['id_medico']);
	$d['empresa'] = $this -> hospi_impresion_model -> obtenerEmpresa();
	$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['atencion']['id_entidad']);
	//-----------------------------------------------------------
	$this->load->view('impresion/coam/ordenCups',$d);
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>
