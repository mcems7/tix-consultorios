<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Anexo3_consulta
 *Tipo: controlador
 *Descripcion: Permite realizar la gestión de pacientes por la central de autorizaciones
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 12 de septiembre de 2012
*/
class Anexo3_consulta extends Controller
{
///////////////////////////////////////////////////////////////////
function __construct()
{
	parent::Controller();			
	$this -> load -> model('auto/autorizaciones_model'); 
	$this -> load -> model('urg/urgencias_model');	
	$this -> load -> model('core/paciente_model');
	$this -> load -> model('core/tercero_model');
	$this -> load -> model('hosp/hosp_model'); 
}
///////////////////////////////////////////////////////////////////
function index()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('auto/consulta_anexo3', $d);
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
	$res = $this->autorizaciones_model->obtenerPaciente($d['numero_documento']);
	$d['lista'] = $this->autorizaciones_model->obtenerPacientesAnexo3($res['id_paciente']);
	
	echo $this->load->view('auto/auto_lista_anexo3',$d);
	
}
///////////////////////////////////////////////////////////////////
function consultarAnexo3($id_anexo)
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('auto/consulta_anexo3/index');
	//----------------------------------------------------------
	$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo3($id_anexo);
	$id_atencion = $d['anexo']['id_atencion'];
	//----------------------------------------------------------
	if($id_atencion < 10000000){
	$aten = $this -> urgencias_model -> obtenerAtencion($id_atencion);
	}else{
	$aten = $this -> hosp_model -> obtenerAtencion($id_atencion);
	}
	
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['anexo']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['anexo']['id_entidad']);
	//----------------------------------------------------------
	$d['envios'] = $this -> autorizaciones_model -> obtenerEnviosAnexo3($id_anexo);
	
	$d['cups'] = $this -> autorizaciones_model -> obtenerCupsAnexo3($id_anexo);
	
	$d['anexo4'] = $this -> autorizaciones_model -> obtenerListadoAnexo4($id_anexo);
	$d['adjuntos'] = $this -> autorizaciones_model -> obtenerAdjuntosAnexo3($id_anexo);
	
	$d['entes'] = $this -> autorizaciones_model -> obtenerEntes();	
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('auto/auto_consulta_gestionAnexo3', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------	
}
///////////////////////////////////////////////////////////////////
	function anexo3Web($id_anexo)
	{
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo3($id_anexo);
		//----------------------------------------------------------
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['anexo']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		//----------------------------------------------------------
		$d['empresa'] = $this -> autorizaciones_model -> obtenerEmpresa(1);
		//----------------------------------------------------------
		$d['reporta'] = $this -> autorizaciones_model -> obtenerReporta(3);
		$d['cups'] = $this -> autorizaciones_model -> obtenerCupsAnexo3($id_anexo);
		
		if($d['anexo']['tipo'] == 'urg'){
			$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($d['anexo']['id_atencion']);
			$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
			$d['dx_evo'] = $this -> urgencias_model ->obtenerDxEvoluciones($d['anexo']['id_atencion']);
		}else if($d['anexo']['tipo'] == 'hosp'){
			$d['dx'] = $this -> hosp_model -> obtenerDxAtencion($d['anexo']['id_atencion']);
		}
		$d['tipo'] = 'web';
		$this->load->view('auto/anexo3',$d);
	}
	
	function consultarAnexo4($id_anexo)
	{
		//----------------------------------------------------------
		$d = array();
		
		//----------------------------------------------------------
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo4($id_anexo);
		$d['anexo3'] = $this -> autorizaciones_model ->obtenerAnexo3($d['anexo']['id_anexo3']);
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('auto/anexo3_consulta/consultarAnexo3/'.$d['anexo']['id_anexo3']);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['anexo3']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model -> obtenerEntidad($d['anexo3']['id_entidad']);
		$d['anexoCups'] = $this -> autorizaciones_model -> obtenerCupsAnexo4($id_anexo);
		//----------------------------------------------------------	
		$this->load->view('core/core_inicio');
		$this -> load -> view('auto/auto_anexo4Consulta', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
}
?>
