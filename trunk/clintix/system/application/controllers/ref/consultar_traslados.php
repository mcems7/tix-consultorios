<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Consultar_traslados
 *Tipo: controlador
 *Descripcion: Permite administrar las gestiones para traslado de pacientes
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 27 de Junio de 2012
*/
class Consultar_traslados extends Controller
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
function consultar_traslado($id_traslado)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('ref/traslados/index');
	//----------------------------------------------------------
	$d['traslado'] = $this->ref_model->obtener_traslado($id_traslado);
	
	if($d['traslado']['activo'] == 'NO')
		$d['traslado_fin'] = $this->ref_model->obtener_traslado_fin($id_traslado);
			
	if($d['traslado']['autorizacion'] == 'SI')
	{
		$d['auto'] = $this->ref_model->obtener_autorizacion($id_traslado);
	}
	$d['notas'] =$this->ref_model->obtener_notas($id_traslado);
	if($d['traslado']['id_atencion'] >= 10000000 ){
		$d['atencion'] = $this->hosp_model->obtenerAtencion($d['traslado']['id_atencion']);
		$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['traslado']['id_paciente']);
		$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['paciente']['id_entidad']);	
		$d['dx'] = $this->hosp_model->obtenerDxAtencion($d['traslado']['id_atencion']);
	}else{
		$d['atencion'] = $this->urgencias_model->obtenerAtencion($d['traslado']['id_atencion']);
		$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['traslado']['id_paciente']);
		$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this->urgencias_model->obtenerEntidad($d['atencion']['id_entidad']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($d['traslado']['id_atencion']);
		$d['dx'] = $this->urgencias_model->obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dx_evo'] = $this->urgencias_model ->obtenerDxEvoluciones($d['traslado']['id_atencion']);
	}
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('ref/ref_traslado_consultar',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>