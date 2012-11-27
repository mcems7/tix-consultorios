<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Salida voluntaria de un paciente del servicio de Urgencias sin conluir su atención
 *Tipo: controlador
 *Descripcion: Permite crear el registro de la atención inicial en el servicio de urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 23 de mayo de 2011
*/
class Salida_voluntaria extends Controller
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
* Ingreso de justificación de la salida voluntaria del paciente
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110523
* @version		20110523
*/	
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('urg/salas/index');
		//----------------------------------------------------------
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_salidaVoluntaria', $d);
    	$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function salidaVolintaria()
	{
		$d['id_atencion'] = $this->input->post('id_atencion');
		$d['password'] = $this->input->post('password');
		
		$res = $this->urgencias_model->comprobarPassword($d);

		if($res){
			$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$this->urgencias_model->retiroVoluntario($d);	
		
		redirect('urg/salida_voluntaria/impSalidaVoluntaria/'.$d['id_atencion']);
		
		}else{
		//----------------------------------------------------
		$dt['mensaje']  = "La contraseña no corresponde!!";
		$dt['urlRegresar'] 	= site_url('urg/salida_voluntaria/main/'.$d['id_atencion']);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------	
		}	
	}
///////////////////////////////////////////////////////////////////
function impSalidaVoluntaria($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['urlRegresar'] 	= site_url('urg/salas/index');
	//----------------------------------------------------------
	$d['retiro'] = $this->urgencias_model->obtenerInfoRetiro($id_atencion);
	$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
	//-----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('urg/urg_salidaVoluntariaImp', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////	
}
?>
