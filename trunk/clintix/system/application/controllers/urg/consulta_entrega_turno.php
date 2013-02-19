<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Consulta_entrega_turno
 *Tipo: controlador
 *Descripcion: Permite consultar los informes de entrega de turno en el servicio de urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 27 de junio de 2012
*/
class Consulta_entrega_turno extends Controller
{
/////////////////////////////////////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this->load->model('urg/urgencias_model');
		$this->load->model('core/paciente_model');
		$this->load->model('core/tercero_model'); 	 
		$this->load->model('core/medico_model'); 	 		
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
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
	$d['urlRegresar'] = site_url('core/home/index');
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('urg/urg_consulta_entrega_turno',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
/////////////////////////////////////////////////////////////////////////////////////////////////
function buscar()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['fecha_inicio']	= $this->input->post('fecha_inicio')." 00:00:00";
	$d['fecha_fin']		= $this->input->post('fecha_fin')." 23:59:59";
	$d['id_servicio']	= $this->input->post('id_servicio');
	//----------------------------------------------------------
	$d['lista'] = $this->urgencias_model->obtenerListaEntregaTurno($d);
	$this->load->view('urg/urg_entrega_turno_consulta_lista',$d);
 	//----------------------------------------------------------	
}
/////////////////////////////////////////////////////////////////////////////////////////////////
function entrega_turno_consulta($id_entrega)
{
	//-----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] = site_url('urg/consulta_entrega_turno/index');
	$d['entrega'] = $this->urgencias_model->obtenerEntregaTurno($id_entrega);
	$d['entrega_detalle'] = $this->urgencias_model->obtenerEntregaTurnoDetalle($id_entrega);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('urg/urg_entrega_turno_consulta',$d);
	$this->load->view('core/core_fin');
	//-----------------------------------------------------------
}
}
?>
