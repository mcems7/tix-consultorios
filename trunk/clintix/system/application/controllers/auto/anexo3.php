<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: anexo3
 *Tipo: controlador
 *Descripcion: Envia de forma automatica el anexo tecnico numero 2
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 30 de mayo de 2011
*/
class anexo3 extends Controller
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
		$d['estados_anexo'] = $this -> autorizaciones_model -> obtenerEstadosAnexo3(); 
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('auto/auto_principalAnexo3', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
	function listadoAnexos3()
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_estado_anexo'] 	= $this->input->post('id_estado_anexo');
		$d['lista'] = $this -> autorizaciones_model -> obtenerListadoAnexo3($d);
		echo $this -> load -> view('auto/auto_listadoAnexo3',$d);
	}
///////////////////////////////////////////////////////////////////
	function obtenerMunicipio()
	{
		$departamento 	= $this->input->post('departamento');
		$cadena = '';
		$departamento 		= $this -> tercero_model -> obtenerMunicipio($departamento);
		$cadena .='<select name="municipio" id="municipio">';
		$cadena .='<option value="0" selected="selected">-Seleccione uno-</option>';
		foreach($departamento as $d)
		{
			$cadena .= '<option value="'.$d['id_municipio'].'">'.$d['nombre'].'</option>';
		}
		$cadena .='</select>';
	
		echo $cadena;
	}	
///////////////////////////////////////////////////////////////////
	function crearAnexo3($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('auto/anexo3/index');
		$d['tipo'] = 'urg';
		//----------------------------------------------------------
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model -> obtenerEntidad($d['atencion']['id_entidad']);
		
		if($d['atencion']['id_entidad_pago'] != '-'){
$d['entidad_pago'] = $this -> urgencias_model -> obtenerEntidad($d['atencion']['id_entidad_pago']);
$d['correos_entidad_pago'] = $this -> autorizaciones_model -> obtenerCorreosEntidad($d['atencion']['id_entidad_pago']); 
		}
		
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		$d['dx_evo'] = $this -> urgencias_model ->obtenerDxEvoluciones($id_atencion);
		$d['servicios'] = $this -> urgencias_model -> obtenerServicios();
		//----------------------------------------------------------
		$d['cobertura'] 		= $this -> autorizaciones_model -> obtenerCobertura(); 
		$d['conse'] 			= $this -> autorizaciones_model -> obtenerConsecutivo(3);
		$d['correos'] = $this -> autorizaciones_model -> obtenerCorreosEntidad($d['atencion']['id_entidad']); 
		$d['empresa'] 			= $this -> autorizaciones_model -> obtenerEmpresa(1);
		$d['municipio'] 		= $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('auto/auto_anexo3Form', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function anexo3Hosp($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('auto/anexo3/index');
		$d['tipo'] = 'hosp';
		//----------------------------------------------------------
		$d['atencion'] = $this -> hosp_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model -> obtenerEntidad($d['paciente']['id_entidad']);
		
		
		if($d['atencion']['id_entidad_pago'] != '-'){
$d['entidad_pago'] = $this -> urgencias_model -> obtenerEntidad($d['atencion']['id_entidad_pago']);
$d['correos_entidad_pago'] = $this -> autorizaciones_model -> obtenerCorreosEntidad($d['atencion']['id_entidad_pago']); 
		}
		
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['dx'] = $this -> hosp_model -> obtenerDxAtencion($id_atencion);
		$d['servicios'] = $this -> urgencias_model -> obtenerServicios($d['paciente']['id_entidad']);
		$d['correos'] = $this -> autorizaciones_model -> obtenerCorreosEntidad($d['atencion']['id_entidad']); 
		//----------------------------------------------------------
		$d['cobertura'] 		= $this -> autorizaciones_model -> obtenerCobertura(); 
		$d['conse'] 			= $this -> autorizaciones_model -> obtenerConsecutivo(3);
		$d['empresa'] 			= $this -> autorizaciones_model -> obtenerEmpresa(1);
		$d['municipio'] 		= $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('auto/auto_anexo3Form', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function anexo3_()
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $this->input->post('id_atencion');
		$d['tipo'] = $this->input->post('tipo');
		$d['id_paciente'] = $this->input->post('id_paciente');
		$d['fecha_anexo'] = $this->input->post('fecha_anexo');
		$d['hora_anexo'] = $this->input->post('hora_anexo');
		$numero_documento = $this->input->post('numero_documento');
		$d['cod_depa_empresa'] = $this->input->post('cod_depa_empresa');
		$d['cod_muni_empresa'] = $this->input->post('cod_muni_empresa');
		$d['numero_informe'] = $this->input->post('numero_informe');
		$d['id_empresa'] = $this->input->post('id_empresa');
		$d['id_entidad'] = $this->input->post('id_entidad');
		$d['cobertura'] = $this->input->post('cobertura');
		$d['id_origen'] = $this->input->post('id_origen');
		$d['serv_soli'] = $this->input->post('serv_soli');
		$d['prioridad'] = $this->input->post('prioridad');
		$d['ubicacion_paciente'] = $this->input->post('ubicacion_paciente');
		$d['servicio'] = $this->input->post('servicio');
		$d['cama'] = $this->input->post('cama');
		$d['guia_manejo'] = $this->input->post('guia_manejo');
		$d['justificacion_clinica'] = $this->input->post('justificacion_clinica');
		$d['cups'] 	= $this->input->post('cups_');
		$d['observacionesCups'] 	= $this->input->post('observacionesCups_');
		$d['cantidadCups'] 	= $this->input->post('cantidadCups_');
		
		$d['nombre_reporta'] 	= $this->input->post('nombre_reporta');
		$d['cargo_reporta'] 	= $this->input->post('cargo_reporta');
		$d['indicativo_reporta'] 	= $this->input->post('indicativo_reporta');
		$d['telefono_reporta'] 	= $this->input->post('telefono_reporta');
		$d['ext_reporta'] 	= $this->input->post('ext_reporta');
		$d['celular_reporta'] 	= $this->input->post('celular_reporta');
		
		
		$nombre_pdf ='Anexo3';
		$nombre_pdf .= $d['fecha_anexo'];
		$nombre_pdf .= $d['numero_informe'];
		$nombre_pdf .= $numero_documento.'.pdf';
		$d['nombre_pdf'] = $nombre_pdf;
		//----------------------------------------------------------
		$id_anexo = $this -> autorizaciones_model -> anexo3Db($d);
		//----------------------------------------------------------
		redirect("auto/anexo3/anexo3Mail/".$id_anexo);
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function anexo3Mail($id_anexo)
	{
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo3($id_anexo);
		//----------------------------------------------------------
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['anexo']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['anexo']['id_entidad']);
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
		$d['tipo'] = 'email';
		$html_email = $this->load->view('auto/anexo3',$d,true);
		
		//----------------------------------------------------------------------------------------
		$d['tipo'] = 'pdf';
		$html_pdf = $this->load->view('auto/anexo3',$d,true);
		//----------------------------------------------------------	
		$this ->load->plugin('to_pdf');
		$nombre_pdf ='Anexo3';
		$nombre_pdf .= $d['anexo']['fecha_anexo'];
		$nombre_pdf .= $d['anexo']['numero_informe'];
		$nombre_pdf .= $d['tercero']['numero_documento'];	
    	
    	// Envio de correo electronico-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
		$correos = $this -> autorizaciones_model -> obtenerCorreosEntidad($d['anexo']['id_entidad']);
    	
    	$this->load->library('email');
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);
		
		$asunto ='Anexo3 ';
		$asunto .= $d['anexo']['numero_informe']." ";
		$asunto .= $d['anexo']['fecha_anexo']." ";
		$asunto .= $d['tercero']['numero_documento']." ";
		$asunto .= $d['tercero']['primer_apellido']." ";
		$asunto .= $d['tercero']['segundo_apellido']." ";
		$asunto .= $d['tercero']['primer_nombre']." ";
		$asunto .= $d['tercero']['segundo_nombre']." ";	
		$lista = $this -> autorizaciones_model -> obtenerCorreosEntidad($d['anexo']['id_entidad']);
		
		$email = array();
		foreach($lista as $email_temp)
		{
			$email[] = $email_temp['correo_entidad'];
		}
		
		if(count($email) == 0)
		{
			$envio = 'NO';
		}else{
		
			//pdf_create ($html_pdf,$nombre_pdf,false);
				
			$this->email->from('cerca@hospitalquindio.gov.co','Hospital Departamental Universitario del Quindío San Juan de Dios');
			
			$this->email->to($email);
			//	Correo de almacenamiento de anexos enviados
			$this->email->cc('bodegacerca@opuslibertati.org'); 
			$this->email->subject($asunto);
			$this->email->message($html_email);
			//	Adjuntar el anexo en PDF para ser enviado en el correo electronico
			//$this->email->attach('./files/auto/anexo3/'.$nombre_pdf.'.pdf');
			if (!$this->email->send())
			{
				$envio = 'NO';
			}else{
				$envio = 'SI';
				$this -> autorizaciones_model  ->contarEnvioAnexo3($id_anexo,$d['anexo']['numero_envio']+1);
			}
		}
		// $this->email->print_debugger();
		
		 
		redirect('auto/anexo3/gestionAnexo3/'.$id_anexo);	
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
///////////////////////////////////////////////////////////////////
	function gestionAnexo3($id_anexo)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('auto/anexo3/index');
		//----------------------------------------------------------
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo3($id_anexo);
		$id_atencion = $d['anexo']['id_atencion'];
		//----------------------------------------------------------
		if($id_atencion < 10000000){
			$aten = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		}else{
			$aten = $this -> hosp_model -> obtenerAtencion($id_atencion);
		}
		/*
		if($aten['activo'] != 'SI'){
	$dat['mensaje'] = "La atención se encuentra inactiva!!";
	$dat['urlRegresar'] = site_url('auto/anexo3/index');
	$this -> load -> view('core/presentacionMensaje', $dat);
	return;	
		}*/
		
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
		$this -> load -> view('auto/auto_gestionAnexo3', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function anexo3MailEnte($id_anexo,$id_ente)
	{
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo3($id_anexo);
		$d['envios'] = $this -> autorizaciones_model -> obtenerEnviosAnexo3($id_anexo);
		//----------------------------------------------------------
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['anexo']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['anexo']['id_entidad']);
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
		$d['tipo'] = 'email';
		$html_email = $this->load->view('auto/anexo3no_respuesta',$d,true);
		
		//----------------------------------------------------------------------------------------
		$d['tipo'] = 'pdf';
		$html_pdf = $this->load->view('auto/anexo3no_respuesta',$d,true);
		//----------------------------------------------------------	
		$this ->load->plugin('to_pdf');
		$nombre_pdf ='Anexo3';
		$nombre_pdf .= $d['anexo']['fecha_anexo'];
		$nombre_pdf .= $d['anexo']['numero_informe'];
		$nombre_pdf .= $d['tercero']['numero_documento'];	
    	
    	// Entidad territorial
		$correos = $this -> autorizaciones_model -> obtenerCorreosEntidad($id_ente);
    	
    	$this->load->library('email');
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);
		
		$asunto ='NO RESPUESTA Anexo3 ';
		$asunto .= $d['anexo']['numero_informe']." ";
		$asunto .= $d['anexo']['fecha_anexo']." ";
		$asunto .= $d['tercero']['numero_documento']." ";
		$asunto .= $d['tercero']['primer_apellido']." ";
		$asunto .= $d['tercero']['segundo_apellido']." ";
		$asunto .= $d['tercero']['primer_nombre']." ";
		$asunto .= $d['tercero']['segundo_nombre']." ";	
		$lista = $this -> autorizaciones_model -> obtenerCorreosEntidad($d['anexo']['id_entidad']);
		
		$email = array();
		foreach($lista as $email_temp)
		{
			$email[] = $email_temp['correo_entidad'];
		}
		
		$email2 = array();
		foreach($correos as $email_temp2)
		{
			$email2[] = $email_temp2['correo_entidad'];
		}
		
		if(count($email) == 0)
		{
			$envio = 'NO';
		}else{
		
			//pdf_create ($html_pdf,$nombre_pdf,false);
				
			$this->email->from('cerca@hospitalquindio.gov.co','Hospital Departamental Universitario del Quindío San Juan de Dios');
			
			$this->email->to($email2);
			$this->email->cc($email);
			//	Correo de almacenamiento de anexos enviados
			$this->email->bcc('bodegacerca@opuslibertati.org'); 
			$this->email->subject($asunto);
			$this->email->message($html_email);
			//	Adjuntar el anexo en PDF para ser enviado en el correo electronico
			//$this->email->attach('./files/auto/anexo3/'.$nombre_pdf.'.pdf');
			if (!$this->email->send())
			{
				$envio = 'NO';
			}else{
				$envio = 'SI';
				$this -> autorizaciones_model  ->contarEnvioAnexo3($id_anexo,$d['anexo']['numero_envio']+1);
			}
		}
		//$this->email->print_debugger();
		 
		redirect('auto/anexo3/gestionAnexo3/'.$id_anexo);	
	}
///////////////////////////////////////////////////////////////////
	function anexo4($id_anexo3)
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('auto/anexo3/gestionAnexo3/'.$id_anexo3);
		//----------------------------------------------------------
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo3($id_anexo3);
		//----------------------------------------------------------
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['anexo']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model -> obtenerEntidad($d['anexo']['id_entidad']);
		$d['anexoCups'] = $this -> autorizaciones_model -> obtenerCupsAnexo($id_anexo3);
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('auto/auto_anexo4Form', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function anexo4_()
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_anexo3'] = $this->input->post('id_anexo3');
		$d['estado_anexo'] = $this->input->post('estado_anexo');
		$d['numero_informe'] = $this->input->post('numero_informe');
		$d['fecha_anexo'] = $this->input->post('fecha_anexo');
		$d['hora_anexo'] = $this->input->post('hora_anexo');
		$d['cups'] = $this->input->post('cups_');
		$d['observacionesCups'] = $this->input->post('observacionesCups_');
		$d['cantidadCups'] = $this->input->post('cantidadCups_');
		$d['porcentaje_pagar'] = $this->input->post('porcentaje_pagar');
		$d['semanas_afiliacion'] = $this->input->post('semanas_afiliacion');
		$d['bono_pago'] = $this->input->post('bono_pago');
		
		$d['cuota_moderadora'] = $this->input->post('cuota_moderadora');
		if($d['cuota_moderadora'] != 'SI'){
			$d['cuota_moderadora'] = 'NO';
		}
		$d['valor_moderadora'] = $this->input->post('valor_moderadora');
		$d['porcentaje_moderadora'] = $this->input->post('porcentaje_moderadora');
		$d['tope_moderadora'] = $this->input->post('tope_moderadora');
		
		$d['copago'] = $this->input->post('copago');
		if($d['copago'] != 'SI'){
			$d['copago'] = 'NO';
		}
		$d['valor_copago'] = $this->input->post('valor_copago');
		$d['porcentaje_copago'] = $this->input->post('porcentaje_copago');
		$d['tope_copago'] = $this->input->post('tope_copago');
		
		$d['cuota_recuperacion'] = $this->input->post('cuota_recuperacion');
		if($d['cuota_recuperacion'] != 'SI'){
			$d['cuota_recuperacion'] = 'NO';
		}
		$d['valor_recuperacion'] = $this->input->post('valor_recuperacion');
		$d['porcentaje_recuperacion'] = $this->input->post('porcentaje_recuperacion');
		$d['tope_recuperacion'] = $this->input->post('tope_recuperacion');
		
		$d['otro'] = $this->input->post('otro');
			if($d['otro'] != 'SI'){
			$d['otro'] = 'NO';
		}
		$d['valor_otro'] = $this->input->post('valor_otro');
		$d['porcentaje_otro'] = $this->input->post('porcentaje_otro');
		$d['tope_otro'] = $this->input->post('tope_otro');
		
		//----------------------------------------------------------
		$id_anexo = $this -> autorizaciones_model -> anexo4Db($d);
		//----------------------------------------------------------
		redirect("auto/anexo3/gestionAnexo3/".$d['id_anexo3']);
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
	function consultarAnexo4($id_anexo)
	{
		//----------------------------------------------------------
		$d = array();
		
		//----------------------------------------------------------
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo4($id_anexo);
		$d['anexo3'] = $this -> autorizaciones_model ->obtenerAnexo3($d['anexo']['id_anexo3']);
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('auto/anexo3/gestionAnexo3/'.$d['anexo']['id_anexo3']);
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
///////////////////////////////////////////////////////////////////
	function do_upload()
	{
		//----------------------------------------------------------
		$d = array();
		$dt = array();
		$config = array();
		//----------------------------------------------------------
		$d['id_anexo3'] = $this->input->post('id_anexo3');
		$d['titulo'] = $this->input->post('titulo');
		$d['descripcion'] = $this->input->post('descripcion');
		//----------------------------------------------------------	
		//Configuración de la libreria upload
		$config['upload_path'] = "./files/auto/anexo3/adjuntos_anexo3/";
		$config['allowed_types'] = 'xls|xlsx|doc|docx|pdf|jpg|bmp|gif';
		$config['max_size']	= '6000';
		$this -> load -> library('upload');
		$this -> upload -> initialize($config);
		//----------------------------------------------------------
		if (!$this->upload->do_upload() )
		{	
			//----------------------------------------------------------
			$dt['mensaje']  = $this -> upload -> display_errors();
			$dt['urlRegresar'] 	= site_url("auto/anexo3/gestionAnexo3/".$d['id_anexo3']);
			$this -> load -> view('core/presentacionMensaje', $dt);
			return;	
			//----------------------------------------------------------
		}	
		else
		{	
			$res = $this->upload->data();
			$d['archivo'] = $res['file_name'];
			$d['ext'] = $res['file_ext'];
			$this -> autorizaciones_model -> agregarAdjuntoAnexo3($d);
			//----------------------------------------------------------
			$dt['mensaje']  = "El archivo fue cargado exitosamente!!";
			$dt['urlRegresar'] 	= site_url("auto/anexo3/gestionAnexo3/".$d['id_anexo3']);
			$this -> load -> view('core/presentacionMensaje', $dt);
			return;	
			//----------------------------------------------------------
		}
	}	
///////////////////////////////////////////////////////////////////
	function cups($l)
	{
		$l = preg_replace("/[^a-z0-9 ]/si","",$l);
		$this->load->database();
		$this->db->like('desc_subcategoria',$l);
		$r = $this->db->get('core_cups_subcategoria');
		$dat = $r -> result_array();
		foreach($dat as $d)
		{
			echo $d["id_subcategoria"]."###".$d["desc_subcategoria"]."|";
		}
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con metodo avanzado de codificar diagnosticos 
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100906
* @version		20100906
* @return		HTML
*/	
	function cupsAvanzados()
	{
		$d['secciones'] = $this -> urgencias_model -> obtenerCupsSec();	
		echo $this->load->view('urg/urg_ordAgreProcAvanzado',$d);
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con metodo simple de codificar diagnosticos 
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright
* @since		20100906
* @version		20100906
* @return		HTML
*/	
	function cupsSimple()
	{
		echo $this->load->view('urg/urg_ordAgreProcSimple');
	}
///////////////////////////////////////////////////////////////////
	function cupsCaps($sec)
	{
		$capitulos = $this -> urgencias_model -> obtenerCupsCap($sec);
		
		$cadena ='';
		$cadena .= '<select name="id_capitulo" id="id_capitulo" onChange="gruposCap()">';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($capitulos  as $d)
			{
				$cadena .='<option value="'.$d['id_capitulo'].'">'.$d['desc_capitulo'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;
	}
///////////////////////////////////////////////////////////////////	
	function cupsGrupos($cap)
	{
		$grupos = $this -> urgencias_model -> obtenerCupsGrup($cap);
		
		$cadena ='';
		$cadena .= '<select name="id_grupo" id="id_grupo" onChange="subGGru()">';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($grupos  as $d)
			{
				$cadena .='<option value="'.$d['id_grupo'].'">'.$d['desc_grupo'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;
	}
///////////////////////////////////////////////////////////////////
	function cupsSubGrupos($gru)
	{
		$subGrupos = $this -> urgencias_model -> obtenerCupsSubGrup($gru);
		
		$cadena ='';
		$cadena .= '<select name="id_subgrupo" id="id_subgrupo" onChange="CubGcate()">';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($subGrupos  as $d)
			{
				$cadena .='<option value="'.$d['id_subgrupo'].'">'.$d['desc_subgrupo'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;
	}
///////////////////////////////////////////////////////////////////
	function cupsCategorias($sgru)
	{
		$categorias = $this -> urgencias_model -> obtenerCupsCategorias($sgru);
		
		$cadena ='';
		$cadena .= '<select name="id_categoria" id="id_categoria" onChange="CubCaSubca()">';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($categorias  as $d)
			{
				$cadena .='<option value="'.$d['id_categoria'].'">'.$d['desc_categoria'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;
	}
///////////////////////////////////////////////////////////////////
	function cupsSubCate($cate)
	{
		$subCate = $this -> urgencias_model -> obtenerCupsSubCate($cate);
		
		$cadena ='';
		$cadena .= '<select name="cups_ID" id="cups_hidden">';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($subCate  as $d)
			{
				$cadena .='<option value="'.$d['id_subcategoria'].'">'.$d['desc_subcategoria'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;
	}
///////////////////////////////////////////////////////////////////
	function agregarProcedimiento()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['cups'] = $this->input->post('cups_ID');
		$d['observacionesCups'] = $this->input->post('observacionesCups');
		$d['cantidadCups'] = $this->input->post('cantidadCups');
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		
		echo $this->load->view('urg/urg_ordInfoProcedimiento',$d);
	}
///////////////////////////////////////////////////////////////////
	function prueba()
	{
			
			$this->load->library('email');
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);	
			$this->email->from('cerca@hospitalquindio.gov.co','Hospital Departamental Universitario del Quindío San Juan de Dios');
			
			$this->email->to('cajaramillo@misena.edu.co');
			$mensaje = "prueba ".date('Y-m-d H:i:s');
			$this->email->subject($mensaje);
			$this->email->message($mensaje);
			//	Adjuntar el anexo en PDF para ser enviado en el correo electronico
			//$this->email->attach('./files/auto/anexo3/'.$nombre_pdf.'.pdf');
			$this->email->send();
			echo $this->email->print_debugger();
		
	}
}
?>
