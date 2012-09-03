<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Hops_main extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this -> load -> model('hosp/hosp_model'); 
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model');
	}
///////////////////////////////////////////////////////////////////
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('hosp/hosp_main',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function buscarPaciente()
	{
		//----------------------------------------------------------
		$d = array();
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		//----------------------------------------------------------
		
		$verTer = $this -> tercero_model -> verificaTercero($d['numero_documento']);
		
		$verAtenUrg = $this ->urgencias_model -> verificarAtencionUrg($d['numero_documento']);
		if($verAtenUrg != 0){
		$d['lista'] = $verAtenUrg;
		echo $this->load->view('auto/auto_listadoAtenciones',$d);
		}
		
		/*
		print_r($verAten);die();
		
		
		
		//Verifica la existencia del tercero en el sistema
		if($verTer != 0)
		{
			$verPas = $this -> paciente_model -> verificarPaciente($verTer);
			//Verifica la existencia del tercero como paciente
			if($verPas != 0)
			{
				$d['tipo'] = 'n';
				$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($verPas);
				$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
				$this -> load -> view('urg/urg_triage',$d);
			}else
			{
				$d['tipo'] = 'paciente';
				$d['tercero'] = $this -> urgencias_model -> obtenerTercero($verTer);
				$this -> load -> view('urg/urg_triage',$d);
			}
		}else{
			$d['tipo'] = 'tercero';
			$this -> load -> view('urg/urg_triage',$d);
		}
		*/
		
	}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>
