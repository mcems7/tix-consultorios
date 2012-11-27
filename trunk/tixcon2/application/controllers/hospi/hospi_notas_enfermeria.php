<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: hospi_Notas_enfermeria
 *Tipo: controlador
 *Descripcion: Gestiona de notas de enfermeria.
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 04 de marzo de 2012
*/

class Hospi_notas_enfermeria extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('hospi/hospi_model');
		$this -> load -> model('hospi/hospi_enfermeria_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 
		$this -> load -> helper('html');	 		
	}
///////////////////////////////////////////////////////////////////
/*
* Gestión de las notas de enfermería
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120304
* @version		20120304
*/	
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> hospi_enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerNotas($id_atencion);
		$d['urlRegresar'] 	= site_url('/hospi/hospi_enfermeria/main/'.$id_atencion);
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hospi/hospi_notasListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Consultar una nota indicada
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120305
* @version		20120305
*/	
	function consultaNota($id_nota)
	{
		$d = array();
		$d['nota'] = $this->hospi_enfermeria_model->obtenerNota($id_nota);
		echo $this->load->view('hospi/hospi_notaConsulta',$d);
	}

///////////////////////////////////////////////////////////////////
/*
* Crear una nueva nota de enfermeria
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120307
* @version		20120307
*/	
	function crearNota($id_atencion)
	{
		$this->load->model('urg/urgencias_model');
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['urlRegresar'] 	= site_url('hospi/hospi_notas_enfermeria/main/'.$id_atencion);
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['consulta'] = $this -> hospi_model -> obtenerNotaInicial($id_atencion);
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hospi/hospi_notaCrear',$d);
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
/*
* Crear una nota de enfermeria partiendo de la ultima registrada
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120307
* @version		20120307
*/	
	function crearNotaEdit($id_atencion)
	{
		$this->load->model('urg/urgencias_model');
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['nota'] = $this->hospi_enfermeria_model->obtenerUltNota($id_atencion);
		$d['urlRegresar'] 	= site_url('hospi/hospi_notas_enfermeria/main/'.$id_atencion);
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['consulta'] = $this -> hospi_model -> obtenerNotaInicial($id_atencion);
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');	
		$this -> load -> view('hospi/hospi_notaCrearEdit',$d);
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Crea la nota de enfermeria
*
* @author Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20120307
* @version		20120307
*/
	function crearNota_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['subjetivo'] = mb_strtoupper($this->input->post('subjetivo'),'utf-8');
		$d['objetivo']  = mb_strtoupper($this->input->post('objetivo'),'utf-8');
		$d['actividades']  = mb_strtoupper($this->input->post('actividades'),'utf-8');
		$d['pendientes']  = mb_strtoupper($this->input->post('pendientes'),'utf-8');
		$d['id_medico'] = $this->input->post('id_medico');
		$d['id_atencion'] = $this->input->post('id_atencion');
		$atencion = $this -> hospi_model -> obtenerAtencion($d['id_atencion']);
		$d['id_servicio'] = $atencion['id_servicio']; 
		//----------------------------------------------------------
		$d['id_nota'] = $this -> hospi_enfermeria_model -> crearNotaDb($d);
		//----------------------------------------------------
		$dt['mensaje']  = "Los datos de la nota de enfermeria se han almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("hospi/hospi_notas_enfermeria/main/".$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
//////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
/*
* Gestión de las notas de enfermería
*
* @author Diego Ivan Carvajal <dcarvajal@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright

*/	
	function consultarNota($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> hospi_enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerNotas($id_atencion,$d['atencion']['id_servicio']);
		$id_serv = $d['atencion']['id_servicio'];
	
		$d['urlRegresar'] 	= site_url('hospi/hospi_gestion_atencion/main/'.$id_atencion);
		
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hospi/hospi_notasListadoM', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
	
	//----------------------------------------------------------
	//----------------------------------------------------------
	
	
	function consultarNotaEfecto($id_atencion)
	{
		//----------------------------------------------------------
//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> hospi_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> hospi_enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> hospi_enfermeria_model -> obtenerNotas($id_atencion,$d['atencion']['id_servicio']);
		$id_serv = $d['atencion']['id_servicio'];
	
		$d['urlRegresar'] 	= site_url('hospi/hospi_gestion_atencion/main/'.$id_atencion);
		
		//-----------------------------------------------------------
		$this->load->view('core/efecto_inicio');
		$this -> load -> view('hospi/hospi_notasListadoEfect', $d);
		$this->load->view('core/efecto_fin');
		//----------------------------------------------------------
	}
}
?>
