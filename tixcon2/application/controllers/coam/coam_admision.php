<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Coam_admision
 *Tipo: controlador
 *Descripcion: Permite realizar la admision de paciente que asiste a consulta ambulatoria
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 06 de abril de 2012
*/
class Coam_admision extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this->load->model('coam/coam_model');
		$this->load->model('core/tercero_model');
		$this->load->model('hospi/hospi_model');
		$this->load->model('core/paciente_model');  
		$this->load->model('core/Usuario');
	 		
	}
///////////////////////////////////////////////////////////////////
function index()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	//----------------------------------------------------------
	$d['lista'] = $this->coam_model->listadoTotalAtenciones();
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('coam/coam_adm_busqueda', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Buscar la existencia de un paciente en el sistema
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120406
* @version		20120406
*/	
function buscarPaciente()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$n_d 	= $this->input->post('numero_documento');
	/*
		Verificar existencia de atenciones vigentes
	*/
	$verTer = $this ->tercero_model ->verificaTercero($n_d);
	//Verifica la existencia del tercero en el sistema
	if($verTer != 0){
		$verPas = $this->paciente_model->verificarPaciente($verTer);
	//Verifica la existencia del tercero como paciente
		if($verPas != 0){
			//Admision de un paciente ya existente
			redirect('coam/coam_admision/admPacienteExiste/'.$verPas);
		}else{
			//Admision de un tercero existente
			redirect('coam/coam_admision/admTerceroExiste/'.$verTer);
		}
	}else{
		//Admision de un tercero y paciente nuevo
		redirect('coam/coam_admision/admTerceroPaciente/'.$n_d);
	}
}
///////////////////////////////////////////////////////////////////
/*
* Admision de un paciente existente
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120406
* @version		20120406
*/	
function admPacienteExiste($id_paciente)
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['urlRegresar'] 	= site_url('coam/coam_admision');
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['tipo_usuario']= $this -> paciente_model -> tipos_usuario();
	$d['tipo_documento'] = $this -> tercero_model -> tipos_documento();		
	$d['pais'] = $this -> tercero_model -> obtenerPais();
	$d['departamento'] = $this -> tercero_model -> obtenerDepartamento();
	
	$d['municipio'] = $this -> tercero_model->obtenerMunicipio($d['tercero']['departamento']);
	
	$d['entidad'] = $this -> paciente_model->obtenerEntidades();
	$d['origen'] = $this->coam_model->obtenerOrigenesAtencion();
	$d['tipo_usuario']	= $this -> paciente_model->tipos_usuario();
	$d['consultorios'] = $this ->coam_model->obtenerConsultorios();
	
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('coam/coam_adm_pacExi', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Admision de un tercero no paciente existente
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120406
* @version		20120406
*/	
function admTerceroExiste($id_tercero)
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------	
	$d['urlRegresar'] 	= site_url('hospi_admision');
	$d['tercero'] = $this->paciente_model->obtenerTercero($id_tercero);
	$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
	$d['departamento']	 	= $this -> tercero_model -> obtenerDepartamento();	
	$d['municipio'] 		= $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
	$d['pais']				= $this -> tercero_model -> obtenerPais();
	$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
	$d['entidad'] = $this -> paciente_model -> obtenerEntidades();
	$d['origen'] = $this->coam_model->obtenerOrigenesAtencion();
	$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
	$d['consultorios'] = $this ->coam_model->obtenerConsultorios();
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('coam/coam_adm_paci', $d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Admision de un paciente y tercero no existente
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120406
* @version		20120406
*/
function admTerceroPaciente($n_d)
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['urlRegresar'] 	= site_url('core/administrar_paciente');
	$d['n_d'] = $n_d;
	$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
	$d['pais']				= $this -> tercero_model -> obtenerPais();
	$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
	$d['entidad'] = $this -> paciente_model -> obtenerEntidades();
	$d['origen'] = $this->coam_model->obtenerOrigenesAtencion();
	$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
	$d['consultorios'] = $this ->coam_model->obtenerConsultorios();	
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('coam/coam_adm_TerPac',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Admision de un paciente y tercero no existente
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120406
* @version		20120406
*/	
function admTerceroPaciente_()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['numero_documento'] 	= $this->input->post('numero_documento');	
	$verTer = $this -> tercero_model ->verificaTercero($d['numero_documento']);
	if($verTer != 0){
		$dat['mensaje'] = "Ya existe un tercero con el número de documento de identidad ".$d['numero_documento']."!!";
		$dat['urlRegresar'] = site_url('coam/coam_admision/index');
		$this -> load -> view('core/presentacionMensaje', $dat);
		return;
	}
	//----------------------------------------------------------
	$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
	$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
	$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
	$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
	$d['id_tipo_documento'] = $this->input->post('id_tipo_documento');
	$d['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');

	$d['razon_social'] = "";
	$d['pais'] 	= $this->input->post('pais');
	$d['departamento'] 	= $this->input->post('departamento');
	$d['municipio'] 	= $this->input->post('municipio');
	$d['vereda'] 	= mb_strtoupper($this->input->post('vereda'),'utf-8');
	$d['direccion'] 	= mb_strtoupper($this->input->post('direccion'),'utf-8');
	$d['zona'] 	= $this->input->post('zona');
	$d['telefono'] 	= $this->input->post('telefono');
	$d['celular'] 	= $this->input->post('celular');
	$d['fax'] 	= $this->input->post('fax');
	$d['email'] 	= $this->input->post('email');
	$d['observaciones'] 	= $this->input->post('observaciones');
	//----------------------------------------------------------
	$r = $this -> tercero_model -> crearTerceroDb($d);
	$d['id_tercero'] 	= $r['id_tercero'];
	//----------------------------------------------------------
	$d['genero'] = $this->input->post('genero');
	$d['estado_civil'] = $this->input->post('estado_civil');
	$d['id_entidad'] = $this->input->post('id_entidad');
	$d['id_cobertura'] = $this->input->post('id_cobertura');
	$d['tipo_afiliado'] = $this->input->post('tipo_afiliado');
	$d['nivel_categoria'] 	= $this->input->post('nivel_categoria');
	$d['desplazado'] = $this->input->post('desplazado');
	$d['observaciones'] = mb_strtoupper($this->input->post('observaciones'),'utf-8');
	//----------------------------------------------------------
	$r = $this -> paciente_model -> crearPacienteDb($d);
	$d['id_paciente'] = $r['id_paciente'];
	//----------------------------------------------------------
	$d['id_contrato'] 			= $this->input->post('id_contrato');
	$d['id_consultorio'] = $this->input->post('id_consultorio');
	$d['id_origen'] = $this->input->post('id_origen');
	$d['poliza_soat'] = $this->input->post('poliza_soat');
	$d['observaciones_adm'] 	= mb_strtoupper($this->input->post('observaciones_adm'),'utf-8');	
	$d['id_entidad_pago'] 	= $this->input->post('id_entidad_pago');
	//----------------------------------------------------------
	$r = $this ->coam_model->crearAdmisionDb($d);
	//----------------------------------------------------------
$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'coam',__CLASS__,__FUNCTION__
,'aplicacion',"Se creo la atención con id ".$r['id_id_atencion']);
//----------------------------------------------------------
	$dt['mensaje']  = "El ingreso del paciente se ha realizado exitosamente!!";
	$dt['urlRegresar'] 	= site_url("coam/coam_admision/index/");
	$this -> load -> view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Admision de un paciente tercero si existente paciente no
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120406
* @version		20120406
*/	
function admTerceroExiste_()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['id_tercero'] 	= $this->input->post('id_tercero');
	$d['numero_documento'] 	= $this->input->post('numero_documento');
	$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
	$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
	$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
	$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
	$d['id_tipo_documento'] = $this->input->post('id_tipo_documento');
	$d['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
	$d['razon_social'] 	= "";
	$d['fecha_nacimiento'] 	= $this->input->post('fecha_nacimiento');
	$d['id_tipo_documento'] 	= $this->input->post('id_tipo_documento');
	$d['numero_documento'] 	= $this->input->post('numero_documento');
	$d['pais'] 	= $this->input->post('pais');
	$d['departamento'] 	= $this->input->post('departamento');
	$d['municipio'] 	= $this->input->post('municipio');
	$d['vereda'] 	= mb_strtoupper($this->input->post('vereda'),'utf-8');
	$d['direccion'] 	= mb_strtoupper($this->input->post('direccion'),'utf-8');
	$d['zona'] 	= $this->input->post('zona');
	$d['telefono'] 	= $this->input->post('telefono');
	$d['celular'] 	= $this->input->post('celular');
	$d['fax'] 	= $this->input->post('fax');
	$d['email'] 	= $this->input->post('email');
	$d['observaciones'] = mb_strtoupper($this->input->post('observaciones'),'utf-8');	
	//----------------------------------------------------------
	$r = $this ->tercero_model->editarTerceroDb($d);
	//----------------------------------------------------------
	$d['genero'] = $this->input->post('genero');
	$d['estado_civil'] = $this->input->post('estado_civil');
	$d['id_entidad'] = $this->input->post('id_entidad');
	$d['id_cobertura'] = $this->input->post('id_cobertura');
	$d['tipo_afiliado'] = $this->input->post('tipo_afiliado');
	$d['nivel_categoria'] 	= $this->input->post('nivel_categoria');
	$d['desplazado'] = $this->input->post('desplazado');
	//----------------------------------------------------------
	$r = $this -> paciente_model -> crearPacienteDb($d);
	$d['id_paciente'] = $r['id_paciente'];
	//----------------------------------------------------------
	$d['id_contrato'] 			= $this->input->post('id_contrato');
	$d['id_consultorio'] = $this->input->post('id_consultorio');
	$d['id_origen'] = $this->input->post('id_origen');
	$d['poliza_soat'] = $this->input->post('poliza_soat');
	$d['observaciones_adm'] 	= mb_strtoupper($this->input->post('observaciones_adm'),'utf-8');	
	$d['id_entidad_pago'] 	= $this->input->post('id_entidad_pago');
	//----------------------------------------------------------
	$r = $this ->coam_model->crearAdmisionDb($d);
	//----------------------------------------------------------
$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'coam',__CLASS__,__FUNCTION__
,'aplicacion',"Se creo la atención con id ".$r['id_id_atencion']);
//----------------------------------------------------------
	$dt['mensaje']  = "El ingreso del paciente se ha realizado exitosamente!!";
	$dt['urlRegresar'] 	= site_url("coam/coam_admision/index/");
	$this -> load -> view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------
}
/*
* Admision de un paciente y tercero que existen
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120305
* @version		20120305
*/	
function admPacienteExiste_()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['id_tercero'] 	= $this->input->post('id_tercero');
	$d['id_paciente'] 	= $this->input->post('id_paciente');
	$d['numero_documento'] 	= $this->input->post('numero_documento');
	$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
	$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
	$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
	$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
	$d['id_tipo_documento'] = $this->input->post('id_tipo_documento');
	$d['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
	$d['razon_social'] 	= "";
	$d['fecha_nacimiento'] 	= $this->input->post('fecha_nacimiento');
	$d['id_tipo_documento'] 	= $this->input->post('id_tipo_documento');
	$d['numero_documento'] 	= $this->input->post('numero_documento');
	$d['pais'] 	= $this->input->post('pais');
	$d['departamento'] 	= $this->input->post('departamento');
	$d['municipio'] 	= $this->input->post('municipio');
	$d['vereda'] 	= mb_strtoupper($this->input->post('vereda'),'utf-8');
	$d['direccion'] 	= mb_strtoupper($this->input->post('direccion'),'utf-8');
	$d['zona'] 	= $this->input->post('zona');
	$d['telefono'] 	= $this->input->post('telefono');
	$d['celular'] 	= $this->input->post('celular');
	$d['fax'] 	= $this->input->post('fax');
	$d['email'] 	= $this->input->post('email');
	$d['observaciones'] = mb_strtoupper($this->input->post('observaciones'),'utf-8');	
	//----------------------------------------------------------
	$r = $this ->tercero_model->editarTerceroDb($d);
	//----------------------------------------------------------
	$d['genero'] = $this->input->post('genero');
	$d['estado_civil'] = $this->input->post('estado_civil');
	$d['id_entidad'] = $this->input->post('id_entidad');
	$d['id_cobertura'] = $this->input->post('id_cobertura');
	$d['tipo_afiliado'] = $this->input->post('tipo_afiliado');
	$d['nivel_categoria'] 	= $this->input->post('nivel_categoria');
	$d['desplazado'] = $this->input->post('desplazado');
	//----------------------------------------------------------
	$this -> paciente_model -> editarPacienteDb($d);
	//----------------------------------------------------------
	$d['id_contrato'] 			= $this->input->post('id_contrato');
	$d['id_consultorio'] = $this->input->post('id_consultorio');
	$d['id_origen'] = $this->input->post('id_origen');
	$d['poliza_soat'] = $this->input->post('poliza_soat');
	$d['observaciones_adm'] 	= mb_strtoupper($this->input->post('observaciones_adm'),'utf-8');	
	$d['id_entidad_pago'] 	= $this->input->post('id_entidad_pago');
	//----------------------------------------------------------
	$r = $this ->coam_model->crearAdmisionDb($d);
	//----------------------------------------------------------
	$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'coam',__CLASS__,__FUNCTION__
,'aplicacion',"Se creo la atención con id ".$r['id_id_atencion']);
//----------------------------------------------------------
	$dt['mensaje']  = "El ingreso del paciente se ha realizado exitosamente!!";
	$dt['urlRegresar'] 	= site_url("coam/coam_admision/index/");
	$this -> load -> view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Editar admisión paciente
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120415
* @version		20120415
*/
function editar_admision($id_atencion)
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['atencion'] = $this->coam_model->obtenerAtencion($id_atencion);
	$d['urlRegresar'] 	= site_url('coam/coam_admision');
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['tipo_usuario']= $this -> paciente_model -> tipos_usuario();
	$d['tipo_documento'] = $this -> tercero_model -> tipos_documento();		
	$d['pais'] = $this -> tercero_model -> obtenerPais();
	$d['departamento'] = $this -> tercero_model -> obtenerDepartamento();
	
	$d['municipio'] = $this -> tercero_model->obtenerMunicipio($d['tercero']['departamento']);
	
	$d['entidad'] = $this -> paciente_model->obtenerEntidades();
	$d['origen'] = $this->coam_model->obtenerOrigenesAtencion();
	$d['tipo_usuario']	= $this -> paciente_model->tipos_usuario();
	$d['consultorios'] = $this ->coam_model->obtenerConsultorios();
	
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this->load->view('coam/coam_adm_editar_admision',$d);
	$this->load->view('core/core_fin');
	//----------------------------------------------------------
}

/*
* Admision de un paciente y tercero que existen
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120305
* @version		20120305
*/	
function editar_admision_()
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['id_tercero'] 	= $this->input->post('id_tercero');
	$d['id_atencion'] 	= $this->input->post('id_atencion');
	$d['id_paciente'] 	= $this->input->post('id_paciente');
	$d['numero_documento'] 	= $this->input->post('numero_documento');
	$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
	$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
	$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
	$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
	$d['id_tipo_documento'] = $this->input->post('id_tipo_documento');
	$d['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
	$d['razon_social'] 	= "";
	$d['fecha_nacimiento'] 	= $this->input->post('fecha_nacimiento');
	$d['id_tipo_documento'] 	= $this->input->post('id_tipo_documento');
	$d['numero_documento'] 	= $this->input->post('numero_documento');
	$d['pais'] 	= $this->input->post('pais');
	$d['departamento'] 	= $this->input->post('departamento');
	$d['municipio'] 	= $this->input->post('municipio');
	$d['vereda'] 	= mb_strtoupper($this->input->post('vereda'),'utf-8');
	$d['direccion'] 	= mb_strtoupper($this->input->post('direccion'),'utf-8');
	$d['zona'] 	= $this->input->post('zona');
	$d['telefono'] 	= $this->input->post('telefono');
	$d['celular'] 	= $this->input->post('celular');
	$d['fax'] 	= $this->input->post('fax');
	$d['email'] 	= $this->input->post('email');
	$d['observaciones'] = mb_strtoupper($this->input->post('observaciones'),'utf-8');	
	//----------------------------------------------------------
	$r = $this ->tercero_model->editarTerceroDb($d);
	//----------------------------------------------------------
	$d['genero'] = $this->input->post('genero');
	$d['estado_civil'] = $this->input->post('estado_civil');
	$d['id_entidad'] = $this->input->post('id_entidad');
	$d['id_cobertura'] = $this->input->post('id_cobertura');
	$d['tipo_afiliado'] = $this->input->post('tipo_afiliado');
	$d['nivel_categoria'] 	= $this->input->post('nivel_categoria');
	$d['desplazado'] = $this->input->post('desplazado');
	//----------------------------------------------------------
	$this -> paciente_model -> editarPacienteDb($d);
	//----------------------------------------------------------
	$d['id_contrato'] 			= $this->input->post('id_contrato');
	$d['id_consultorio'] = $this->input->post('id_consultorio');
	$d['id_origen'] = $this->input->post('id_origen');
	$d['poliza_soat'] = $this->input->post('poliza_soat');
	$d['observaciones_adm'] 	= mb_strtoupper($this->input->post('observaciones_adm'),'utf-8');	
	$d['id_entidad_pago'] 	= $this->input->post('id_entidad_pago');
	//----------------------------------------------------------
	$this ->coam_model->editar_admisionDb($d);
	//----------------------------------------------------------
	$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'coam',__CLASS__,__FUNCTION__
,'aplicacion',"Se edito la atención con id ".$d['id_atencion']);
//----------------------------------------------------------
	$dt['mensaje']  = "La modificación de la admisión de ha realizado exitosamente!!";
	$dt['urlRegresar'] 	= site_url("coam/coam_admision/index/");
	$this -> load -> view('core/presentacionMensaje', $dt);
	return;	
	//----------------------------------------------------------
}
///////////////////////////////////////////////////////////////////
/*
* Verificar entidad
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120406
* @version		20120406
*/	
function verificarEntidad()
{
	$entidad	= $this -> paciente_model -> obtenerEntidades();
	$id_origen = $this->input->post('id_origen');
	
	if($id_origen == 6 || $id_origen == 4 || $id_origen == 3 || $id_origen == 2)
	{
	$cadena = '<select name="id_entidad_pago" id="id_entidad_pago" style="font-size:9px">';
	$cadena .= '<option value="0">-Seleccione uno-</option>';
	foreach($entidad as $d)
	{
		$cadena .= '<option value="'.$d['id_entidad'].'">'.$d['razon_social'].'</option>';	
	}
	$cadena .= '</select>';	
		if($id_origen == 4){
			$cadena .='<p>'.br()."<strong>Número de poliza SOAT:</strong>".nbs().form_input(array('name' => 'poliza_soat',
					'id'=> 'poliza_soat',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']")).'</p>';
		}else{
			$cadena .= '<input name="poliza_soat" id="poliza_soat" type="hidden" value="" />';
		}
	}else{
	$cadena = '<input name="poliza_soat" id="poliza_soat" type="hidden" value="" />';
	$cadena .= '<input name="id_entidad_pago" id="id_entidad_pago" type="hidden" value="-" />No Aplica';
	}
	echo $cadena;
}

function verificarEntidadEdit($id_atencion)
{
	
	$aten = $this->coam_model->obtenerAtencion($id_atencion);
	$entidad	= $this -> paciente_model -> obtenerEntidades();
	$id_origen = $this->input->post('id_origen');
	
	if($id_origen == 6 || $id_origen == 4 || $id_origen == 3 || $id_origen == 2)
	{
	$cadena = '<select name="id_entidad_pago" id="id_entidad_pago" style="font-size:9px">';
	$cadena .= '<option value="0">-Seleccione uno-</option>';
	foreach($entidad as $d)
	{
		if($aten['id_entidad_pago'] == $d['id_entidad']){
		$cadena .= '<option value="'.$d['id_entidad'].'" selected="selected">'.$d['razon_social'].'</option>';
		}else{
		$cadena .= '<option value="'.$d['id_entidad'].'">'.$d['razon_social'].'</option>';
		}
	}
	$cadena .= '</select>';	
		if($id_origen == 4){
			$cadena .='<p>'.br()."<strong>Número de poliza SOAT:</strong>".nbs().form_input(array('name' => 'poliza_soat',
					'id'=> 'poliza_soat',
					'maxlength'   => '20',
					'size'=> '20',
					'value' => $aten['poliza_soat'],
					'class'=>"fValidate['alphanumtilde']")).'</p>';
		}else{
			$cadena .= '<input name="poliza_soat" id="poliza_soat" type="hidden" value="" />';
		}
	}else{
	$cadena = '<input name="poliza_soat" id="poliza_soat" type="hidden" value="" />';
	$cadena .= '<input name="id_entidad_pago" id="id_entidad_pago" type="hidden" value="-" />No Aplica';
	}
	echo $cadena;
}

///////////////////////////////////////////////////////////////////
function obtenerContratosEntidad()
{
	$id_entidad = $this->input->post('id_entidad');
	$contratos = $this->hospi_model->obtenerContratosEntidad($id_entidad);
	
	$cadena = '<select name="id_contrato" id="id_contrato"">';
	$cadena .= '<option value="0">-Seleccione uno-</option>';
	foreach($contratos as $d)
	{
		$cadena .= '<option value="'.$d['id_contrato'].'">'.$d['nombre_contrato'].'</option>';	
	}
	$cadena .= '</select>';	
		
	echo $cadena;	
}
//////////////////////////////////////////////////////////////////
function obtenerContratosEntidadEditar($id_atencion)
{
	$id_entidad = $this->input->post('id_entidad');
	$contratos = $this->hospi_model->obtenerContratosEntidad($id_entidad);
	$aten = $this->coam_model->obtenerAtencion($id_atencion);
	
	$cadena = '<select name="id_contrato" id="id_contrato"">';
	$cadena .= '<option value="0">-Seleccione uno-</option>';
	foreach($contratos as $d)
	{
		
		if($aten['id_contrato'] == $d['id_contrato']){
		$cadena .= '<option value="'.$d['id_contrato'].'" selected="selected">'.$d['nombre_contrato'].'</option>';	
		}else{
		$cadena .= '<option value="'.$d['id_contrato'].'">'.$d['nombre_contrato'].'</option>';	
		}
	}
	$cadena .= '</select>';	
		
	echo $cadena;	
}
}
?>