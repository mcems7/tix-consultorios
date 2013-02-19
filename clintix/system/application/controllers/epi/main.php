<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Main
 *Tipo: controlador
 *Descripcion: Módulo de epidemiología
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 19 de septiembre de 2012
*/
class Main extends Controller
{
///////////////////////////////////////////////////////////////////
function __construct()
{
	parent::Controller();     
	$this -> load -> model('epi/epi_model');
	$this -> load -> model('urg/urgencias_model');	
	$this -> load -> model('core/paciente_model');
	$this -> load -> model('core/tercero_model');
}
///////////////////////////////////////////////////////////////////
function index()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar']   = site_url('core/home/index');
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('epi/listado_reportes', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
function listado_reportes()
{
	//----------------------------------------------------------
	$d = array();
	$d['estado'] 	= $this->input->post('estado');
	$d['fecha_inicio'] 	= $this->input->post('fecha_inicio');
	$d['fecha_fin'] 	= $this->input->post('fecha_fin');
	$d['lista'] = $this->epi_model->obtenerListado($d);
	echo $this -> load -> view('epi/listado_reportes_detalle',$d);
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
function consulta_caso($id_reporte)
{
	//----------------------------------------------------------
	$d = array();
	$d['repo'] = $this->epi_model->obtenerCaso($id_reporte);
	$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($d['repo']['id_atencion']);
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['repo']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['repo']['id_medico']);
	$d['entidad'] = $this -> urgencias_model -> obtenerEntidad($d['paciente']['id_entidad']);
	$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
	$this -> load -> view('epi/consulta_caso_vista',$d);
}
///////////////////////////////////////////////////////////////////
function inactivar_reporte($id_reporte)
{
	$this->epi_model->inactivar_reporte($id_reporte);
}
///////////////////////////////////////////////////////////////////
function activar_reporte($id_reporte)
{
	$this->epi_model->activar_reporte($id_reporte);
}
///////////////////////////////////////////////////////////////////

}
?>