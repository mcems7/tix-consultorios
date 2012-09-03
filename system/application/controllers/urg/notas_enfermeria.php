<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Notas_enfermeria
 *Tipo: controlador
 *Descripcion: Gestiona de notas de enfermeria.
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 04 de marzo de 2011
*/

class Notas_enfermeria extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('urg/enfermeria_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 
		$this -> load -> helper('html');	 		
	}
///////////////////////////////////////////////////////////////////
/*
* Gestión de las notas de enfermería
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110304
* @version		20110304
*/	
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> enfermeria_model -> obtenerNotas($id_atencion);
		$id_serv = $d['atencion']['id_servicio'];
	
		if($id_serv == 16 || $id_serv == 17 || $id_serv == 18)
		{
			$d['urlRegresar'] 	= site_url('/urg/enfermeria_obs/main/'.$id_atencion);
		}	else 			{
				$d['urlRegresar'] 	= site_url('/urg/enfermeria/main/'.$id_atencion);
		    }
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_notasListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Consultar una nota indicada
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110305
* @version		20110305
*/	
	function consultaNota($id_nota)
	{
		$d = array();
		$d['nota'] = $this->enfermeria_model->obtenerNota($id_nota);
		echo $this->load->view('urg/urg_notaConsulta',$d);
	}

///////////////////////////////////////////////////////////////////
/*
* Crear una nueva nota de enfermeria
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110307
* @version		20110307
*/	
	function crearNota($id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['urlRegresar'] 	= site_url('urg/notas_enfermeria/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_notaCrear',$d);
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
/*
* Crear una nota de enfermeria partiendo de la ultima registrada
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110307
* @version		20110307
*/	
	function crearNotaEdit($id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['nota'] = $this->enfermeria_model->obtenerUltNota($id_atencion);
		$d['urlRegresar'] 	= site_url('urg/notas_enfermeria/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');	
		$this -> load -> view('urg/urg_notaCrearEdit',$d);
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Crea la nota de enfermeria
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110307
* @version		20110307
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
		$atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
		$d['id_servicio'] = $atencion['id_servicio']; 
		//----------------------------------------------------------
		$d['id_nota'] = $this -> enfermeria_model -> crearNotaDb($d);
		//----------------------------------------------------
		$dt['mensaje']  = "Los datos de la nota de enfermeria se han almacenado correctamente!!";
		$dt['urlRegresar'] 	= site_url("urg/notas_enfermeria/main/".$d['id_atencion']);
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
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> enfermeria_model -> obtenerNotas($id_atencion,$d['atencion']['id_servicio']);
		$id_serv = $d['atencion']['id_servicio'];
	
		$d['urlRegresar'] 	= site_url('/urg/observacion/main/'.$id_atencion);
		
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_notasListadoM', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
	function consultarNotaEfecto($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['ultima_nota'] = $this -> enfermeria_model -> obtenerUltimaNota($id_atencion);
		//Codificación de la sala de espera según el servicio
		$d['notas'] = $this -> enfermeria_model -> obtenerNotas($id_atencion,$d['atencion']['id_servicio']);
		$id_serv = $d['atencion']['id_servicio'];
	
		$d['urlRegresar'] 	= site_url('/urg/observacion/main/'.$id_atencion);
		
		//-----------------------------------------------------------
		$this->load->view('core/efecto_inicio');
		$this -> load -> view('urg/urg_notasListadoEfect', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
}
?>
