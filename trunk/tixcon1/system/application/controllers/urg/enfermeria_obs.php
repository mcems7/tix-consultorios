<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Enfermeria_obs
 *Tipo: controlador
 *Descripcion: Gestiona el paciente en observación por el personal de enfermeria
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 18 de mayo de 2011
*/
class Enfermeria_obs extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('urg/enfermeria_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 
	}
/*
* Listado salas de observación
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20101025
* @version		20101025
*/		
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		$d['estados'] = $this->urgencias_model->obtenerEstadosCamas();
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_enferObsSalas', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Gestión de la atención de un paciente por parte del personal de enfermería en observación
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20110518
* @version		20110518
* @return		HTLM
*/
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('urg/enfermeria_obs/index');
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		
		$d['triage'] = $this -> urgencias_model -> obtenerTriage($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_enferObsGestionAtencion', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////	
	function ingresoObservacion($id_observacion)
	{
		$observacion = $this->urgencias_model->obtenerObservacion($id_observacion);
		$camas = $this->urgencias_model->obtenerCamasDispoServicio($observacion['id_servicio']);
		if(count($camas)>0)
		{
			$cadena = '';
			$cadena .='<select name="id_cama" id="id_cama">';
			$cadena .='<option value="0">-Disponibles-</option>';
			foreach($camas as $d)
			{
				$cadena .='<option value="'.$d['id_cama'].'">'.$d['numero_cama'].'</option>';	
			}
			$cadena .= '</select>';
			$data = array(	'name' => 'bv',
							'onclick' => "asignarCama('".$id_observacion."')",
							'value' => 'Asignar',
							'type' =>'button');
			$cadena .= form_input($data);
		}else{
			$cadena = 'No hay camas disponibles';
		}
		echo $cadena;
	}
///////////////////////////////////////////////////////////////////
	function ingresoObservacionCama($id_observacion,$id_cama)
	{
		$this -> urgencias_model -> ingresoObservacionDb($id_observacion,$id_cama);
		$cama = $this-> urgencias_model -> detalleCama($id_cama);
		echo $cama['numero_cama'];
	}
///////////////////////////////////////////////////////////////////
	function listadoPacientesSala()
	{	
	//----------------------------------------------------------
		$id_salaObs 	= $this->input->post('salasObs');
		
		if($id_salaObs == 0){
				$id_salaObs = $this->session->userdata('id_salaObs');
		}else{
		
			$this->session->unset_userdata('id_salaObs');
			$this->session->set_userdata('id_salaObs',$id_salaObs);
		}
			
		//----------------------------------------------------------
		$id_servicio 	= $this->input->post('salasObs');
		$id_estado 	= $this->input->post('estado');
		$d['servicio'] = $this -> urgencias_model -> obtenerInfoServicio($id_servicio);
		$d['lista'] = $this -> urgencias_model -> obtenerPacientesObservacionUrg($id_servicio);
		$d['camas'] = $this -> urgencias_model -> obtenerCamasServicio($id_servicio,$id_estado);
		//echo $this->db->last_query();die();
		//----------------------------------------------------------
		$this -> load -> view('urg/urg_enferObsSalasDetalle',$d);
		//----------------------------------------------------------
	}
//////////////////////////////////////////////////////////////////
	function activarCama($id_cama)
	{	
		//----------------------------------------------------------
		$id_servicio 	= $this->input->post('salasObs');
		$id_estado 	= 0;
		$this -> urgencias_model -> activarCamaObservacion($id_cama);
		$d['servicio'] = $this -> urgencias_model -> obtenerInfoServicio($id_servicio);
		$d['lista'] = $this -> urgencias_model -> obtenerPacientesObservacionUrg($id_servicio);
		$d['camas'] = $this -> urgencias_model -> obtenerCamasServicio($id_servicio,$id_estado);
		//echo $this->db->last_query();die();
		//----------------------------------------------------------
		$this -> load -> view('urg/urg_obsSalasDetalle',$d);
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
}
?>
