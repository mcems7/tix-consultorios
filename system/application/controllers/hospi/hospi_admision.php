<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hospi_admision
 *Tipo: controlador
 *Descripcion: Permite realizar la admision del paciente a hospitalizacion
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 01 de marzo de 2012
*/
class Hospi_admision extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this->load->model('hospi/hospi_model');
		$this->load->model('core/tercero_model');
		$this->load->model('core/paciente_model');  	 		
	}
///////////////////////////////////////////////////////////////////
function index()
{
	//----------------------------------------------------------
	$d = array();
	$d['urlRegresar'] 	= site_url('core/home/index');
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('hospi/hospi_adm_busqueda', $d);
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
* @since		20120305
* @version		20120305
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
			redirect('hospi/hospi_admision/admPacienteExiste/'.$verPas);
		}else{
			//Admision de un tercero existente
			redirect('hospi/hospi_admision/admTerceroExiste/'.$verTer);
		}
	}else{
		//Admision de un tercero y paciente nuevo
		redirect('hospi/hospi_admision/admTerceroPaciente/'.$n_d);
	}
}
///////////////////////////////////////////////////////////////////
/*
* Admision de un paciente existente
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120305
* @version		20120305
*/	
function admPacienteExiste($id_paciente)
{
	//----------------------------------------------------------
	$d = array();
	//----------------------------------------------------------
	$d['urlRegresar'] 	= site_url('hospi/hospi_admision');
	$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
	$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
	$d['tipo_usuario']= $this -> paciente_model -> tipos_usuario();
	$d['tipo_documento'] = $this -> tercero_model -> tipos_documento();		
	$d['pais'] = $this -> tercero_model -> obtenerPais();
	$d['departamento'] = $this -> tercero_model -> obtenerDepartamento();
	
	//print_r($d['paciente']);die();	
	$d['municipio'] = $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
	
	$d['entidad'] = $this -> paciente_model -> obtenerEntidades();
	$d['origen'] = $this->hospi_model->obtenerOrigenesAtencion();
	$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
	$d['servicios'] = $this ->hospi_model->obtenerServicios();
	$d['entidades_remision'] = $this ->hospi_model->obtenerEntidadesRemision();
	
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('hospi/hospi_adm_pacExi', $d);
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
* @since		20120305
* @version		20120305
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
	$d['origen'] = $this->hospi_model->obtenerOrigenesAtencion();
	$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
	$d['servicios'] = $this ->hospi_model->obtenerServicios();
	$d['entidades_remision'] = $this ->hospi_model->obtenerEntidadesRemision();
	
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('hospi/hospi_adm_paci', $d);
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
* @since		20120305
* @version		20120305
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
	$d['origen'] = $this->hospi_model->obtenerOrigenesAtencion();
	$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
	$d['servicios'] = $this ->hospi_model->obtenerServicios();
	$d['entidades_remision'] = $this ->hospi_model->obtenerEntidadesRemision();
	
	//----------------------------------------------------------
	$this->load->view('core/core_inicio');
	$this -> load -> view('hospi/hospi_adm_TerPac', $d);
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
* @since		20120305
* @version		20120305
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
		$dat['urlRegresar'] = site_url('core/administrar_paciente/index');
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
	$d['remitido'] 			= $this->input->post('remitido');
	$d['codigo_entidad'] 	= $this->input->post('codigo_entidad');
	$d['id_contrato'] 			= $this->input->post('id_contrato');
	$d['id_servicio'] = $this->input->post('id_servicio');
	$d['id_origen'] = $this->input->post('id_origen');
	$d['poliza_soat'] = $this->input->post('poliza_soat');
	$d['ingreso'] 	= $this->input->post('ingreso');
	$d['observaciones_adm'] 	= mb_strtoupper($this->input->post('observaciones_adm'),'utf-8');	
	$d['id_entidad_pago'] 	= $this->input->post('id_entidad_pago');
	//----------------------------------------------------------
	$r = $this ->hospi_model->crearAdmisionDb($d);
	//----------------------------------------------------------
$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'hospi',__CLASS__,__FUNCTION__
,'aplicacion',"Se creo la atención con id ".$r['id_id_atencion']);
//----------------------------------------------------------
	$dt['mensaje']  = "El ingreso del paciente se ha realizado exitosamente!!";
	$dt['urlRegresar'] 	= site_url("hospi/hospi_admision/index/");
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
* @since		20120305
* @version		20120305
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
	$d['remitido'] 			= $this->input->post('remitido');
	$d['codigo_entidad'] 	= $this->input->post('codigo_entidad');
	$d['id_contrato'] 			= $this->input->post('id_contrato');
	$d['id_servicio'] = $this->input->post('id_servicio');
	$d['id_origen'] = $this->input->post('id_origen');
	$d['poliza_soat'] = $this->input->post('poliza_soat');
	$d['ingreso'] 	= $this->input->post('ingreso');
	$d['observaciones_adm'] 	= mb_strtoupper($this->input->post('observaciones_adm'),'utf-8');	
	$d['id_entidad_pago'] 	= $this->input->post('id_entidad_pago');
	//----------------------------------------------------------
	$r = $this ->hospi_model->crearAdmisionDb($d);
	//----------------------------------------------------------
$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'hospi',__CLASS__,__FUNCTION__
,'aplicacion',"Se creo la atención con id ".$r['id_id_atencion']);
//----------------------------------------------------------
	$dt['mensaje']  = "El ingreso del paciente se ha realizado exitosamente!!";
	$dt['urlRegresar'] 	= site_url("hospi/hospi_admision/index/");
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
	$d['remitido'] 			= $this->input->post('remitido');
	$d['codigo_entidad'] 	= $this->input->post('codigo_entidad');
	$d['id_contrato'] 			= $this->input->post('id_contrato');
	$d['id_servicio'] = $this->input->post('id_servicio');
	$d['id_origen'] = $this->input->post('id_origen');
	$d['poliza_soat'] = $this->input->post('poliza_soat');
	$d['ingreso'] 	= $this->input->post('ingreso');
	$d['observaciones_adm'] 	= mb_strtoupper($this->input->post('observaciones_adm'),'utf-8');	
	$d['id_entidad_pago'] 	= $this->input->post('id_entidad_pago');
	//----------------------------------------------------------
	$r = $this ->hospi_model->crearAdmisionDb($d);
	//----------------------------------------------------------
	$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'hospi',__CLASS__,__FUNCTION__
,'aplicacion',"Se creo la atención con id ".$r['id_id_atencion']);
//----------------------------------------------------------
	$dt['mensaje']  = "El ingreso del paciente se ha realizado exitosamente!!";
	$dt['urlRegresar'] 	= site_url("hospi/hospi_admision/index/");
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
* @since		20120305
* @version		20120305
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
}
?>