<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hospi_evoluciones
 *Tipo: controlador
 *Descripcion: Permite gestionar crear y registrar nuevas evoluciones en una atencion hospitalizacion
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 10 de marzo de 2012
*/
class Hospi_evoluciones extends CI_Controller
{
///////////////////////////////////////////////////////////////////
function __construct()
{
	parent::__construct();
	$this->load->model('urg/urgencias_model');		
	$this->load->model('hospi/hospi_model');
	$this->load->model('core/paciente_model');
	$this->load->model('core/tercero_model');
	$this->load->model('core/medico_model');
}
///////////////////////////////////////////////////////////////////
/*
* Vista de gestion de evoluciones
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120310
* @version		20120310
*/	
function main($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hospi/hospi_gestion_atencion/main/'.$id_atencion);
	//----------------------------------------------------------
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	$d['evo'] = $this->hospi_model->obtenerEvoluciones($id_atencion);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_evo_listado', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Consultar una evolución indicada
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120310
* @version		20120310
*/	
function consultaEvolucion($id_evolucion)
{
	$d = array();
	$d['evo'] = $this->hospi_model->obtenerEvolucion($id_evolucion);
	$d['dxEvo'] = $this->hospi_model->obtenerDxEvolucion($id_evolucion);
	echo $this->load->view('hospi/hospi_piso_evo_consulta',$d);
}
///////////////////////////////////////////////////////////////////
/*
* Crear una nueva evolucion
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120310
* @version		20120310
*/	
function crearEvolucion($id_atencion)
{
	//---------------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hospi/hospi_evoluciones/main/'.$id_atencion);
	//---------------------------------------------------------------
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	$d['tiposEvo'] = $this->urgencias_model->obtenerTiposEvolucion();
	$d['especialidades']= $this->medico_model->tipos_especialidades();
	$d['consulta'] = $this->hospi_model->obtenerNotaInicial($id_atencion);
	$d['dxCon'] = $this->hospi_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['dxEvo'] = $this->hospi_model->obtenerDxEvoluciones($id_atencion);
	//---------------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('hospi/hospi_piso_evo_crear',$d);
	$this->load->view('core/core_fin');	
	//---------------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Crea la evolucion
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120310
* @version		20120310
*/
function crearEvolucion_()
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['id_tipo_evolucion'] = $this->input->post('id_tipo_evolucion');
	$d['id_especialidad'] = $this->input->post('id_especialidad');
	$d['subjetivo'] = mb_strtoupper($this->input->post('subjetivo'),'utf-8');
	$d['objetivo']  = mb_strtoupper($this->input->post('objetivo'),'utf-8');
	$d['analisis']  = mb_strtoupper($this->input->post('analisis'),'utf-8');
	$d['conducta']  = mb_strtoupper($this->input->post('conducta'),'utf-8');
	$d['dx'] = $this->input->post('dx_ID_');
	$d['tipo_dx'] = $this->input->post('tipo_dx_');
	$d['id_medico'] = $this->input->post('id_medico');
	$d['id_atencion'] = $this->input->post('id_atencion');
	$d['id_servicio'] = $this->input->post('id_servicio');
	//----------------------------------------------------------
	$d['id_evolucion'] = $this->hospi_model->crearEvolucionDb($d);
	//----------------------------------------------------------
	$dt['mensaje']  = "Los datos de la evolución se han almacenado correctamente!!";
	$dt['urlRegresar'] 	= site_url("hospi/hospi_evoluciones/main/".$d['id_atencion']);
	$this->load->view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Crear una nueva evolucion partiendo de la ultima registrada
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120310
* @version		20120310
*/	
function crearEvolucionEdit($id_atencion)
{
	//---------------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('hospi/hospi_evoluciones/main/'.$id_atencion);
	//---------------------------------------------------------------
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['id_medico'] = $this->urgencias_model->obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this->urgencias_model->obtenerMedico($d['id_medico']);
	$d['tiposEvo'] = $this->urgencias_model->obtenerTiposEvolucion();
	$d['especialidades']= $this->medico_model->tipos_especialidades();
	$d['consulta'] = $this->hospi_model->obtenerNotaInicial($id_atencion);
	$d['dxCon'] = $this->hospi_model->obtenerDxConsulta($d['consulta']['id_consulta']);
	$d['dxEvo'] = $this->hospi_model->obtenerDxEvoluciones($id_atencion);
	$d['evo'] = $this->hospi_model->obtenerUltEvolucion($id_atencion);
	$d['dx'] = $this->hospi_model->obtenerDxEvolucion($d['evo']['id_evolucion']);
	//---------------------------------------------------------------
	$this->load->view('core/core_inicio');	
	$this->load->view('hospi/hospi_piso_evo_crear_edit',$d);
	$this->load->view('core/core_fin');	
	//---------------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
}
?>
