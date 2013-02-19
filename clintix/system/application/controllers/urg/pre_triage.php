<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Pre_triage
 *Tipo: controlador
 *Descripcion: Permite llevar un registro de alertas para pacientes pendientes de triage
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 19 de octubre de 2012
*/
class Pre_triage extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();
		$this -> load -> model('urg/urgencias_model');			
	}
///////////////////////////////////////////////////////////////////
/*
* Listado de pacientes que aun se encuentran en el servicio de Urgencias en todas las salas
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100913
* @version		20100913
*/	
function index()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('urg/urg_pre_triage_ingresar', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
/////////////////////////////////////////////////////////////////////////////////////////////////
function ingresar_paciente()
{
	//----------------------------------------------------------
	$nd = $this->input->post('numero_documento');
	//----------------------------------------------------------
	$this->urgencias_model->ingresar_paciente_pre_triage($nd);
	$dat['mensaje'] = "Se ha ingresado el documento ".$nd."!!";
	$dat['urlRegresar'] = site_url('urg/pre_triage/index');
	$this -> load -> view('core/presentacionMensaje', $dat);
	return;
	
}
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
}
?>