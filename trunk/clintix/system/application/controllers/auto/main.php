<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Main
 *Tipo: controlador
 *Descripcion: Permite realizar la gestión de pacientes por la central de autorizaciones
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 21 de octubre de 2010
*/
class Main extends Controller
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
		$this -> load -> view('auto/auto_main', $d);
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
		
		//Verifica las atenciones activas de urgencias
		$verAten = $this ->autorizaciones_model -> verificarAtencionUrg($d);
		
		if($verAten != 0){
			$d['listaUrg'] = $verAten;
			$d['listaHosp'] = array();
			
		}else{
			$d['listaUrg'] = array();
			//Verifica atenciones activas en hospitalización 
			$verAtenHosp = $this -> hosp_model -> verificarAtencionHosp($d['numero_documento']);
			
			if($verAtenHosp != 0){
				$d['listaHosp'] = $verAtenHosp;
			}else{
				$d['listaHosp'] = array();
			}
		}
		
		echo $this->load->view('auto/auto_listadoAtenciones',$d);
		
	}

///////////////////////////////////////////////////////////////////
	function anexo1($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		//----------------------------------------------------------
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		//----------------------------------------------------------
		$d['cobertura'] 		= $this -> autorizaciones_model -> obtenerCobertura(); 
		$d['conse'] 			= $this -> autorizaciones_model -> obtenerConsecutivo(1);
		$d['empresa'] 			= $this -> autorizaciones_model -> obtenerEmpresa(1);
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['departamento']	 	= $this -> tercero_model -> obtenerDepartamento();
		$d['municipio'] 		= $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('auto/auto_anexo1Form', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function anexo1_()
	{		
		//----------------------------------------------------------
		$d = array();
		$d['id_paciente'] = $this->input->post('id_paciente');
		$d['id_atencion'] = $this->input->post('id_atencion');
		$d['fecha_anexo'] = $this->input->post('fecha_anexo');
		$d['hora_anexo'] = $this->input->post('hora_anexo');
		$d['cod_depa_empresa'] = $this->input->post('cod_depa_empresa');
		$d['cod_muni_empresa'] = $this->input->post('cod_muni_empresa');
		$d['numero_informe'] = $this->input->post('numero_informe');
		$d['id_empresa'] = $this->input->post('id_empresa');
		$d['id_entidad'] = $this->input->post('id_entidad');
		$d['tipo_inconsistencia'] = $this->input->post('tipo_inconsistencia');
		$d['primer_apellido'] = $this->input->post('primer_apellido');
		$d['segundo_apellido'] = $this->input->post('segundo_apellido');
		$d['primer_nombre'] = $this->input->post('primer_nombre');
		$d['segundo_nombre'] = $this->input->post('segundo_nombre');
		$d['id_tipo_documento'] = $this->input->post('id_tipo_documento');
		$d['numero_documento'] = $this->input->post('numero_documento');
		$d['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
		$d['direccion'] = $this->input->post('direccion');
		$d['telefono'] = $this->input->post('telefono');
		$d['departamento'] = $this->input->post('departamento');
		$d['municipio'] = $this->input->post('municipio');
		$d['cobertura'] = $this->input->post('cobertura');
		//----------------------------------------------------------
		$d['primer_apellido_caja'] = $this->input->post('primer_apellido_caja');
		if($d['primer_apellido_caja'] != 'SI'){
			$d['primer_apellido_caja'] = 'NO';
			$d['primer_apellido_doc'] = '';
		}
		$d['primer_apellido_doc'] = $this->input->post('primer_apellido_doc');
		//----------------------------------------------------------
		$d['segundo_apellido_caja'] = $this->input->post('segundo_apellido_caja');
		if($d['segundo_apellido_caja'] != 'SI'){
			$d['segundo_apellido_caja'] = 'NO';
			$d['segundo_apellido_doc'] = '';
		}
		$d['segundo_apellido_doc'] = $this->input->post('segundo_apellido_doc');
		//----------------------------------------------------------
		$d['primer_nombre_caja'] = $this->input->post('primer_nombre_caja');
		if($d['primer_nombre_caja'] != 'SI'){
			$d['primer_nombre_caja'] = 'NO';
			$d['primer_nombre_doc'] = '';
		}
		$d['primer_nombre_doc'] = $this->input->post('segundo_apellido_doc');
		//----------------------------------------------------------
		$d['segundo_nombre_caja'] = $this->input->post('segundo_nombre_caja');
		if($d['segundo_nombre_caja'] != 'SI'){
			$d['segundo_nombre_caja'] = 'NO';
			$d['segundo_nombre_doc'] = '';
		}
		$d['segundo_nombre_doc'] = $this->input->post('segundo_nombre_doc');
		//----------------------------------------------------------
		$d['tipo_documento_caja'] = $this->input->post('tipo_documento_caja');
		if($d['tipo_documento_caja'] != 'SI'){
			$d['tipo_documento_caja'] = 'NO';
			$d['tipo_documento_doc'] = '';
		}
		$d['tipo_documento_doc'] = $this->input->post('tipo_documento_doc');
		//----------------------------------------------------------
		$d['numero_documento_caja'] = $this->input->post('numero_documento_caja');
		if($d['numero_documento_caja'] != 'SI'){
			$d['numero_documento_caja'] = 'NO';
			$d['numero_documento_doc'] = '';
		}
		$d['numero_documento_doc'] = $this->input->post('numero_documento_doc');
		//----------------------------------------------------------
		$d['fecha_nacimiento_caja'] = $this->input->post('fecha_nacimiento_caja');
		if($d['fecha_nacimiento_caja'] != 'SI'){
			$d['fecha_nacimiento_caja'] = 'NO';
			$d['fecha_nacimiento_doc'] = '';
		}
		$d['fecha_nacimiento_doc'] = $this->input->post('fecha_nacimiento_doc');
		//----------------------------------------------------------
		$d['observaciones'] = $this->input->post('observaciones');
		//----------------------------------------------------------
		$d['nombre_reporta'] = $this->input->post('nombre_reporta');
		$d['indicativo_reporta'] = $this->input->post('indicativo_reporta');
		$d['telefono_reporta'] = $this->input->post('telefono_reporta');
		$d['ext_reporta'] = $this->input->post('ext_reporta');
		$d['cargo_reporta'] = $this->input->post('cargo_reporta');
		$d['celular_reporta'] = $this->input->post('celular_reporta');
		//----------------------------------------------------------
		$r = $this -> autorizaciones_model -> anexo1Db($d);
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function anexo1Pdf($id_anexo)
	{
		//----------------------------------------------------------
		$d = array();
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo1($id_anexo);
		//----------------------------------------------------------
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($d['anexo']['id_atencion']);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['anexo']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['anexo']['id_entidad']);
		//----------------------------------------------------------
		$d['cobertura'] 		= $this -> autorizaciones_model -> obtenerCobertura(); 
		$d['conse'] 			= $this -> autorizaciones_model -> obtenerConsecutivo(1);
		$d['empresa'] 			= $this -> autorizaciones_model -> obtenerEmpresa($d['anexo']['id_empresa']);
		//----------------------------------------------------------
		$this -> load -> view('auto/anexo1', $d, false);
		
		/*$this ->load->plugin('to_pdf');
		$html = $this->load->view('auto/anexo1' ,$d );
		pdf_create ($html,'pruebas'); */
	}
///////////////////////////////////////////////////////////////////
}
?>
