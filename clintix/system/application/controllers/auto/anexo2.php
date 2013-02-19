<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/

/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Gestión del amexo 2
 *Tipo: Controlador
 *Descripcion:Permite enviar y gestionar el anexo tecnico numero 2
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 30 de mayo de 2011
*/
class Anexo2 extends Controller
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
		$this -> load -> view('auto/auto_principalAnexo2', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
	function listadoAnexos2()
	{
		//----------------------------------------------------------
		$d = array();
		$d['enviado'] 	= $this->input->post('enviado');
		$d['lista'] = $this -> autorizaciones_model -> obtenerListadoAnexo2($d);
		echo $this -> load -> view('auto/auto_listadoAnexo2',$d);
	}	
///////////////////////////////////////////////////////////////////
	function generarAnexo2($id_atencion,$id_entidad,$id)
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		if($d['atencion']['remitido'] == 'SI'){
			$d['entidad_remite'] = $this ->autorizaciones_model -> obtenerEntidadRemite($d['atencion']['codigo_entidad']);
		}
		//----------------------------------------------------------
		$d['empresa'] = $this -> autorizaciones_model -> obtenerEmpresa(1);
		$cod_depa_empresa = substr($d['empresa']['id_municipio'], 0, 2);
		$cod_muni_empresa = substr($d['empresa']['id_municipio'], 2, 3);		
		//----------------------------------------------------------
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($id_entidad);
		//----------------------------------------------------------
		$d['cobertura'] 		= $this -> autorizaciones_model -> obtenerCobertura(); 
		$d['numero_informe'] 			= $this -> autorizaciones_model -> obtenerConsecutivo(2);
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['departamento']	 	= $this -> tercero_model -> obtenerDepartamento();
		$d['municipio'] 		= $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
		$d['id_paciente'] = $d['atencion']['id_paciente'];
		$d['id_atencion'] = $id_atencion;
		$d['fecha_anexo'] = date('Y-m-d');;
		$d['hora_anexo'] = date('H:i');
		$d['cod_depa_empresa'] = $cod_depa_empresa;
		$d['cod_muni_empresa'] = $cod_muni_empresa;
		$d['id_empresa'] = $d['empresa']['id_empresa'];
		$d['id_entidad'] = $d['paciente']['id_entidad'];
		$d['cobertura'] =  $d['paciente']['id_cobertura'];
		//----------------------------------------------------------
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		//----------------------------------------------------------
		$d['reporta'] = $this -> autorizaciones_model -> obtenerReporta(2);
		//----------------------------------------------------------
		$id_anexo = $this -> autorizaciones_model -> anexo2Db($d);
		//----------------------------------------------------------
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo2($id_anexo);
		
		if($id==1){
			redirect("auto/anexo2/anexo2Mail/".$id_anexo."/".$id_atencion);	
		}else{
			redirect("auto/anexo2/anexo2MailOtro/".$id_anexo."/".$id_atencion);	
		}
	}
///////////////////////////////////////////////////////////////////
	function generarAnexo2Obs($id_atencion,$id_entidad)
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		if($d['atencion']['remitido'] == 'SI'){
			$d['entidad_remite'] = $this ->autorizaciones_model -> obtenerEntidadRemite($d['atencion']['codigo_entidad']);
		}
		//----------------------------------------------------------
		$d['empresa'] = $this -> autorizaciones_model -> obtenerEmpresa(1);
		$cod_depa_empresa = substr($d['empresa']['id_municipio'], 0, 2);
		$cod_muni_empresa = substr($d['empresa']['id_municipio'], 2, 3);		
		//----------------------------------------------------------
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($id_entidad);
		//----------------------------------------------------------
		$d['cobertura'] 		= $this -> autorizaciones_model -> obtenerCobertura(); 
		$d['numero_informe'] 			= $this -> autorizaciones_model -> obtenerConsecutivo(2);
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['departamento']	 	= $this -> tercero_model -> obtenerDepartamento();
		$d['municipio'] 		= $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
		$d['id_paciente'] = $d['atencion']['id_paciente'];
		$d['id_atencion'] = $id_atencion;
		$d['fecha_anexo'] = date('Y-m-d');;
		$d['hora_anexo'] = date('H:i');
		$d['cod_depa_empresa'] = $cod_depa_empresa;
		$d['cod_muni_empresa'] = $cod_muni_empresa;
		$d['id_empresa'] = $d['empresa']['id_empresa'];
		$d['id_entidad'] = $d['paciente']['id_entidad'];
		$d['cobertura'] =  $d['paciente']['id_cobertura'];
		//----------------------------------------------------------
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		//----------------------------------------------------------
		$d['reporta'] = $this -> autorizaciones_model -> obtenerReporta(2);
		//----------------------------------------------------------
		$id_anexo = $this -> autorizaciones_model -> anexo2Db($d);
		//----------------------------------------------------------
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo2($id_anexo);
		
		redirect("auto/anexo2/anexo2MailObs/".$id_anexo."/".$id_atencion);	
	}
///////////////////////////////////////////////////////////////////
	function anexo2MailObs($id_anexo,$id_atencion)
	{
		$this -> autorizaciones_model ->enviarAnexo2Mail($id_anexo);
		redirect("urg/observacion/mensajeAnexo/".$id_atencion);
	}
///////////////////////////////////////////////////////////////////
	function anexo2Mail($id_anexo,$id_atencion)
	{
		$this -> autorizaciones_model ->enviarAnexo2Mail($id_anexo);
		redirect("urg/gestion_atencion/generarAnexos/".$id_atencion);
	}
//////////////////////////////////////////////////////////////////
	function anexo2MailOtro($id_anexo,$id_atencion)
	{
		$this -> autorizaciones_model ->enviarAnexo2Mail($id_anexo);
		redirect("urg/gestion_atencion/generarOtro/");
	}
//////////////////////////////////////////////////////////////////
	function reenviarAnexo2($id_anexo)
	{
		$this -> autorizaciones_model ->enviarAnexo2Mail($id_anexo);
		redirect("auto/anexo2/index");	
	}
//////////////////////////////////////////////////////////////////
	function consultarAnexo2($id_anexo)
	{
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo2($id_anexo);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($d['anexo']['id_atencion']);
		if($d['atencion']['remitido'] == 'SI'){
			$d['entidad_remite'] = $this ->autorizaciones_model -> obtenerEntidadRemite($d['atencion']['codigo_entidad']);
		}
		//----------------------------------------------------------
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($d['paciente']['id_entidad']);
		//----------------------------------------------------------
		$d['empresa'] = $this -> autorizaciones_model -> obtenerEmpresa(1);
		//----------------------------------------------------------
		$d['reporta'] = $this -> autorizaciones_model -> obtenerReporta(2);
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($d['anexo']['id_atencion']);
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		
		$d['tipo'] = 'email';
		$this->load->view('auto/anexo2',$d);
	}
//////////////////////////////////////////////////////////////////
	function generarAnexo2Manual($id_atencion,$id_entidad)
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		if($d['atencion']['remitido'] == 'SI'){
			$d['entidad_remite'] = $this ->autorizaciones_model -> obtenerEntidadRemite($d['atencion']['codigo_entidad']);
		}
		//----------------------------------------------------------
		$d['empresa'] = $this -> autorizaciones_model -> obtenerEmpresa(1);
		$cod_depa_empresa = substr($d['empresa']['id_municipio'], 0, 2);
		$cod_muni_empresa = substr($d['empresa']['id_municipio'], 2, 3);		
		//----------------------------------------------------------
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['entidad'] = $this -> urgencias_model ->obtenerEntidad($id_entidad);
		//----------------------------------------------------------
		$d['cobertura'] 		= $this -> autorizaciones_model -> obtenerCobertura(); 
		$d['numero_informe'] 			= $this -> autorizaciones_model -> obtenerConsecutivo(2);
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['departamento']	 	= $this -> tercero_model -> obtenerDepartamento();
		$d['municipio'] 		= $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
		$d['id_paciente'] = $d['atencion']['id_paciente'];
		$d['id_atencion'] = $id_atencion;
		$d['fecha_anexo'] = date('Y-m-d');;
		$d['hora_anexo'] = date('H:i');
		$d['cod_depa_empresa'] = $cod_depa_empresa;
		$d['cod_muni_empresa'] = $cod_muni_empresa;
		$d['id_empresa'] = $d['empresa']['id_empresa'];
		$d['id_entidad'] = $d['paciente']['id_entidad'];
		$d['cobertura'] =  $d['paciente']['id_cobertura'];
		//----------------------------------------------------------
		$d['consulta'] = $this -> urgencias_model -> obtenerConsulta($id_atencion);
		$d['dx'] = $this -> urgencias_model -> obtenerDxConsulta($d['consulta']['id_consulta']);
		//----------------------------------------------------------
		$d['reporta'] = $this -> autorizaciones_model -> obtenerReporta(2);
		//----------------------------------------------------------
		$id_anexo = $this -> autorizaciones_model -> anexo2Db($d);
		//----------------------------------------------------------
		$d['anexo'] = $this -> autorizaciones_model ->obtenerAnexo2($id_anexo);
		
		redirect("auto/anexo2/anexo2MailManual/".$id_anexo."/".$id_atencion);	
	}
//////////////////////////////////////////////////////////////////
	function anexo2MailManual($id_anexo,$id_atencion)
	{
		$this -> autorizaciones_model ->enviarAnexo2Mail($id_anexo);
		
		//----------------------------------------------------
		$dt['mensaje']  = "Se ha enviado el anexo técnico 2 exitosamente!!";
		$dt['urlRegresar'] 	= site_url("hce/main/consultarAtencion/".$id_atencion);
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
	  function editar($id_anexo)
	{
                    
       $dato=$id_anexo;
		
            
		$res = $this -> autorizaciones_model -> verificado($dato);
		                         
        }     
	
	
//////////////////////////////////////////////////////////////////

}
?>
