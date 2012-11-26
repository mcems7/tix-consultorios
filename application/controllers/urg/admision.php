<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Admision y gestión administrativa de los pacientes en el servicio de urgencias
 *Tipo: controlador
 *Descripcion: Permite crear el registro de la atención inicial en el servicio de urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 13 de septiembre de 2010
*/
class Admision extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 	 		
		$this -> load -> helper( array('url','form','text') );
		$this -> load -> model('core/Registro'); 
	}
///////////////////////////////////////////////////////////////////
/*
* Listado de pacientes que aun se encuentran en el servicio de Urgencias en todas las salas
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100913
* @version		20100913
*/	
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		$d['urlRegresar'] 	= site_url('core/home/index');
		//-----------------------------------------------------------
		$d['estados'] = $this -> urgencias_model -> listadoEstados();
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_admisionPacienteSala', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Listado de pacientes filtrados solicitado por AJAX
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100913
* @version		20100913
* @return		HTML
*/	
	function listadoPacientesUrgencias()
	{
		$d = array();
		$da['admision'] = $this->input->post('admision');
		$d['lista'] = $this -> urgencias_model -> obtenerPacientesUrgencias($da);
		echo $this -> load -> view('urg/urg_admisionListado', $d);
		
	}
///////////////////////////////////////////////////////////////////
/*
* Listado de pacientes filtrados solicitado por AJAX
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100913
* @version		20100913
* @return		HTML
*/
	function admisionPaciente($id_atencion)
	{
		$d = array();	
		$d['urlRegresar'] 	= site_url('urg/admision/index');	
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();		
		$d['pais']				= $this -> tercero_model -> obtenerPais();
		$d['departamento']	 	= $this -> tercero_model -> obtenerDepartamento();	
		
		$d['entidad'] = $this -> paciente_model -> obtenerEntidades();	
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();	
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['municipio'] 		= $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
		$d['origen'] = $this->urgencias_model->obtenerOrigenesAtencion();
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));		
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
	
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		if($d['atencion']['admision'] == 'NO'){
			$this -> load -> view('urg/urg_admCrear', $d);
		}else if($d['atencion']['admision'] == 'SI'){
		$this -> load -> view('urg/urg_admEditar', $d);
		}
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
////////////////////////////////////////////////////////////////////
	function obtenerDepartamento()
	{
		$pais 	= $this->input->post('pais');
		$cadena = '';
   		if($pais == '52')
		{
			$departamento 		= $this -> tercero_model -> obtenerDepartamento();
			$cadena .='<select name="departamento" id="departamento" onchange="obtenerMunicipio()">';
			$cadena .='<option value="0" selected="selected">-Seleccione uno-</option>';
			foreach($departamento as $d)
			{
				$cadena .= '<option value="'.$d['id_departamento'].'">'.$d['nombre'].'</option>';
			}
			$cadena .='</select>';
		}else{
			$cadena .='<select name="departamento" id="departamento">';
			$cadena .= '<option value="999">-No aplica-</option>';
			$cadena .='</select>';
			$cadena .='<script>noAplicaMunicipio();</script>';
		}echo $cadena;
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
	function noAplicaMunicipio()
	{
		$cadena = '';
		$cadena .='<select name="municipio" id="municipio">';
		$cadena .= '<option value="99999">-No aplica-</option>';
		$cadena .='</select>';
		echo $cadena;
	}	
/////////////////////////////////////////////////////////////////////////////////////////////////
	function crearAdmision_()
	{
		$d['id_tercero'] 	= $this->input->post('id_tercero');
		$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
		$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
		$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
		$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
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
		$d['observaciones'] 	= mb_strtoupper($this->input->post('observaciones'),'utf-8');	
		//----------------------------------------------------------
		$this -> tercero_model -> editarTerceroDb($d);
		//----------------------------------------------------------
		$d['genero'] 	= $this->input->post('genero');
		$d['estado_civil'] 	= $this->input->post('estado_civil');
		$d['id_entidad'] 	= $this->input->post('id_entidad');
		$d['id_cobertura'] = $this->input->post('id_cobertura');
		$d['tipo_afiliado'] = $this->input->post('tipo_afiliado');
		$d['nivel_categoria'] 	= $this->input->post('nivel_categoria');
		$d['desplazado'] 	= $this->input->post('desplazado');
		$d['id_paciente'] 	= $this->input->post('id_paciente');
		//----------------------------------------------------------
		$this -> paciente_model -> editarPacienteDb($d);
		//----------------------------------------------------------
		$d['id_atencion']	= $this->input->post('id_atencion');
		$d['id_origen'] = $this->input->post('id_origen');
		$d['ingreso'] 	= $this->input->post('ingreso');
		$d['observaciones_adm'] 	= mb_strtoupper($this->input->post('observaciones_adm'),'utf-8');	
		$d['id_entidad_pago'] 	= $this->input->post('id_entidad_pago');
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'urg',__CLASS__,__FUNCTION__
			,'aplicacion',"Se realizo el ingreso de la atencion id ".$d['id_atencion']);
		//----------------------------------------------------------
		$this -> urgencias_model -> crearAdmisionDb($d);
		//----------------------------------------------------------
		$dt['mensaje']  = "El ingreso del paciente se ha realizado exitosamente!!";
		$dt['urlRegresar'] 	= site_url("urg/admision/index/");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function editarAdmision_(){
		$d['id_tercero'] 	= $this->input->post('id_tercero');
		$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
		$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
		$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
		$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
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
		$d['observaciones'] 	= mb_strtoupper($this->input->post('observaciones'),'utf-8');	
		//----------------------------------------------------------
		$this -> tercero_model -> editarTerceroDb($d);
		//----------------------------------------------------------
		$d['genero'] 	= $this->input->post('genero');
		$d['estado_civil'] 	= $this->input->post('estado_civil');
		$d['id_entidad'] 	= $this->input->post('id_entidad');
		$d['id_cobertura'] = $this->input->post('id_cobertura');
		$d['tipo_afiliado'] = $this->input->post('tipo_afiliado');
		$d['nivel_categoria'] 	= $this->input->post('nivel_categoria');
		$d['desplazado'] 	= $this->input->post('desplazado');
		$d['id_paciente'] 	= $this->input->post('id_paciente');
		//----------------------------------------------------------
		$this -> paciente_model -> editarPacienteDb($d);
		//----------------------------------------------------------
		$d['id_atencion']	= $this->input->post('id_atencion');
		$d['id_origen'] = $this->input->post('id_origen');
		$d['ingreso'] 	= $this->input->post('ingreso');
		$d['observaciones_adm'] 	= mb_strtoupper($this->input->post('observaciones_adm'),'utf-8');	
		$d['id_entidad_pago'] 	= $this->input->post('id_entidad_pago');
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'urg',__CLASS__,__FUNCTION__
			,'aplicacion',"Se realizo el ingreso de la atencion id ".$d['id_atencion']);
		//----------------------------------------------------------
		$this -> urgencias_model -> crearAdmisionDb($d);
		//----------------------------------------------------------
		$dt['mensaje']  = "El ingreso del paciente se ha modificado exitosamente!!";
		$dt['urlRegresar'] 	= site_url("urg/admision/index/");
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
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
			
		}else{
		$cadena = '<input name="id_entidad_pago" id="id_entidad_pago" type="hidden" value="-" />No Aplica';
		}
		echo $cadena;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
}
?>
