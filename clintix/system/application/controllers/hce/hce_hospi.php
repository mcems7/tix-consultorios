<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hce_hospi
 *Tipo: controlador
 *Descripcion: Permite consultar las historias clinicas hospitalización
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 08 de agosto de 2012
*/
class Hce_hospi extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('hospi/hospi_model');
		$this -> load -> model('urg/enfermeria_model');
		$this -> load -> model('hce/hce_model');
		$this -> load -> model('core/medico_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model');
		$this -> load -> model('inter/interconsulta_model'); 
		$this -> load -> helper('text');
	}
///////////////////////////////////////////////////////////////////
function gestion_atencion($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home');
	//----------------------------------------------------------
	$d['atencion'] = $this->hospi_model->obtenerAtencion($id_atencion);
	$d['paciente'] = $this->paciente_model->obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this->paciente_model->obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	if($d['atencion']['consulta'] != 'NO')
	{
		$d['consulta'] = $this->hospi_model->obtenerNotaInicial($id_atencion);
		$d['dxCon'] = $this->hospi_model->obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dxEvo'] = $this->hospi_model->obtenerDxEvoluciones($id_atencion);
	}
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('hce/hospi_gestionAtencion', $d);
    $this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
}
?>
