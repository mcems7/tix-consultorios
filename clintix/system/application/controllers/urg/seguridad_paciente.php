<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Seguridad_paciente
 *Tipo: Controlador
 *Descripcion: Permite diligenciar los instrumentos de seguridad del paciente
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 14 de septiembre de 2012
*/
class Seguridad_paciente extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 	 		
	}
///////////////////////////////////////////////////////////////////
/*
* Listado de valoraciones
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright 	GNU GPL 3.0	
* @since		20120914
* @version		20120914
*/	
function escala_crichton($id_atencion)
{
	$d = array();
	$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['lista'] = $this -> urgencias_model -> obtenerListaValoracionRiesgo($id_atencion);
	$d['puntaje'] = $this->urgencias_model->obtenerValoracionPuntajeRiesgo($id_atencion);
	
	$id_serv = $d['atencion']['id_servicio'];
	
		if($id_serv == 16 || $id_serv == 17 || $id_serv == 18)
		{
			$d['urlRegresar'] 	= site_url('/urg/enfermeria_obs/main/'.$id_atencion);
		}	else 			{
				$d['urlRegresar'] 	= site_url('/urg/enfermeria/main/'.$id_atencion);
		    }
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('urg/urg_segu_listado_crichton', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Registrar una nueva valoración
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright 	GNU GPL 3.0	
* @since		20120914
* @version		20120914
*/	
function escala_crichton_crear($id_atencion)
{
	$d = array();
	$d['urlRegresar'] 	= site_url('urg/seguridad_paciente/escala_crichton/'.$id_atencion);
	$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
	$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('urg/urg_segu_riesgo_caidas_crear', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}

function escala_crichton_crear_()
{
	//----------------------------------------------------
	$d = array();
	$d['id_medico'] 			= $this->input->post('id_medico');
	$d['id_atencion'] 			= $this->input->post('id_atencion');
	//----------------------------------------------------------
	// Datos valoración de riesgos de caídas. Escala de crichton //
	$d['limitacion_fisica'] = $this->input->post('limitacion_fisica');
	$d['estado_mental'] = $this->input->post('estado_mental');
	$d['tratamiento_farmacologico'] = $this->input->post('tratamiento_farmacologico');
	$d['problemas_de_idioma'] = $this->input->post('problemas_de_idioma');
	$d['incontinencia_urinaria'] = $this->input->post('incontinencia_urinaria');
	$d['deficit_sensorial'] = $this->input->post('deficit_sensorial');
	$d['desarrollo_psicomotriz'] = $this->input->post('desarrollo_psicomotriz');
	$d['pacientes_sin_facores'] = $this->input->post('pacientes_sin_facores');
	$r = $this->urgencias_model->segu_riesgo_caidasDb($d);
	//----------------------------------------------------------
	$dt['mensaje']  = "Los datos de la valoración del riesfo de caídas se han almacenado correctamente!!";
	$dt['urlRegresar'] 	= site_url('urg/seguridad_paciente/escala_crichton/'.$d['id_atencion']);
	$this -> load -> view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------
}

/*
* Consultar VALORACIÓN RIESGO DE CAÍDA
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100920
* @version		20100920
*/	
function escala_crichton_consultar($id)
{
	$d = array();
	$d['es'] = $this->urgencias_model->obtenerValoracionRiesgo($id);
	echo $this->load->view('urg/urg_segu_riesgo_caidas_consultar',$d);
}


}
?>
