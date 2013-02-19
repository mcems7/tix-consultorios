<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Entrega_turno
 *Tipo: controlador
 *Descripcion: Permite generar los informes de entrega de turno en el servicio de urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 18 de mayo de 2012
*/
class Entrega_turno extends Controller
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
	$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('urg/urg_entrega_turno', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
/////////////////////////////////////////////////////////////////////////////////////////////////
function listadoPacientesServicio()
{
	$d['id_servicio'] = $this->input->post('id_servicio');
	$d['lista'] = $this->urgencias_model->obtenerPacientesEntregaTurno($d['id_servicio']);
	echo $this->load->view('urg/urg_entrega_turno_lista',$d);
}
/////////////////////////////////////////////////////////////////////////////////////////////////
function pacientes_seleccionados()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] = site_url('urg/entrega_turno/index');
	//-----------------------------------------------------------
	$d['id_servicio'] = $this->input->post('id_servicio');
	$seleccion = $this->input->post('seleccion');
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$d['hospitalarios'] = $this->urgencias_model->obtenerMedicosHospitalarios();
	$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
	$this->load->view('urg/urg_entrega_turno_inicio',$d);
	$dat['especialidades']= $this->medico_model -> tipos_especialidades();
	foreach($seleccion as $data)
	{
			$dat['dato'] = $this->urgencias_model->obtenerPacienteEntregaTurno($data);
			//$pac = $this->urgencias_model->obtenerPacienteEntregaTurno('45491');
		$this->load->view('urg/urg_entrega_turno_detalle_paciente',$dat);
	}
	$this->load->view('urg/urg_entrega_turno_fin');
	$this->load->view('core/core_fin');
	//-----------------------------------------------------------
}
/////////////////////////////////////////////////////////////////////////////////////////////////
function pacientes_seleccionados_()
{
	//-----------------------------------------------------------
	$d = array();
	//-----------------------------------------------------------
	$d['id_servicio'] = $this->input->post('id_servicio');
	$d['id_medico_entrega'] = $this->input->post('id_medico_entrega');
	$d['id_medico_recibe'] = $this->input->post('id_medico_recibe');
	$d['id_atencion'] = $this->input->post('id_atencion');
	$d['id_especialidad'] = $this->input->post('id_especialidad');
	$d['pendiente'] = $this->input->post('pendiente');
	$d['observaciones'] = $this->input->post('observaciones');
	$d['fecha_hora_entrega'] = date("Y-m-d H:i:s");
	//-----------------------------------------------------------
	$id_entrega = $this->urgencias_model->pacientes_seleccionadosDB($d);
	redirect('urg/entrega_turno/entrega_turno_consulta/'.$id_entrega);
	//-----------------------------------------------------------
}
/////////////////////////////////////////////////////////////////////////////////////////////////
function entrega_turno_consulta($id_entrega)
{
	//-----------------------------------------------------------
	$d = array();
	$d['entrega'] = $this->urgencias_model->obtenerEntregaTurno($id_entrega);
	$d['entrega_detalle'] = $this->urgencias_model->obtenerEntregaTurnoDetalle($id_entrega);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('urg/urg_entrega_turno_consulta',$d);
	$this->load->view('core/core_fin');
	//-----------------------------------------------------------
}
/////////////////////////////////////////////////////////////////////////////////////////////////
function entrega_turno_imp($id_entrega)
{
	//-----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] = site_url('urg/entrega_turno/index');
	$d['entrega'] = $this->urgencias_model->obtenerEntregaTurno($id_entrega);
	$d['entrega_detalle'] = $this->urgencias_model->obtenerEntregaTurnoDetalle($id_entrega);
	//-----------------------------------------------------------
	$this->load->view('urg/urg_entrega_turno_imprimir',$d);
	//-----------------------------------------------------------
}

/////////////////////////////////////////////////////////////////////////////////////////////////
}
?>
