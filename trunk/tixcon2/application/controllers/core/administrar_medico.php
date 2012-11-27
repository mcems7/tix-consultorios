<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre:  administrar_medico
 *Tipo: Controlador
 *Descripcion: Administración de personal asistencial
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 30 de octubre de 2010
*/
class Administrar_medico extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this -> load -> helper('form');
		$this -> load -> model('core/medico_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 
		$this -> load -> model('core/Registro'); 	
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function index()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/home/index');	

		//Configuración paginador
		$this->load->library('pagination');
		$config['base_url'] = site_url('core/administrar_medico/index');
		$config['total_rows'] = $this->medico_model->obtenerNumListaMedicos();
		$config['uri_segment'] = 4;
		$config['per_page'] = '50'; //Número de noticias por página
		$config['num_links'] = '3'; //Número de enlaces antes y después de la página actual
		$config['next_link'] = 'Siguiente&nbsp;&gt;';
		$config['prev_link'] = '&lt;&nbsp;Anterior';
		$config['first_link'] = '&lt;&lt;&nbsp;Primero'; //Texto del enlace que nos lleva a la página	&lt;
		$config['last_link'] = 'Último&nbsp;&gt;&gt;'; //Texto del enlace que nos lleva a la última página
		$this->pagination->initialize($config);

		$d['lista'] = $this->medico_model->obtenerListaMedicos($config['per_page'],
		$this->uri->segment(4)); //le pasamos el total de elementos por página y el offset
		
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['tipo_medico']	= $this -> medico_model -> tipos_medico();
		
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/medico_busqueda',$d);
		$this->load->view('core/core_fin');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function buscarMedico()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/administrar_medico/index');	
		//----------------------------------------------------------
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		$d['primer_apellido'] 	= $this->input->post('primer_apellido');
		$d['segundo_apellido'] 	= $this->input->post('segundo_apellido');
		$d['primer_nombre'] 	= $this->input->post('primer_nombre');
		$d['segundo_nombre'] 	= $this->input->post('segundo_nombre');
		$d['id_especialidad'] 	= $this->input->post('id_especialidad');
		$d['id_tipo_medico'] 	= $this->input->post('id_tipo_medico');
		//----------------------------------------------------------
		//Configuración paginador
		$this->load->library('pagination');
		$config['base_url'] = site_url('core/administrar_medico/index');
		$config['total_rows'] = $this->medico_model->obtenerNumListaMedicosCon($d);
		$config['uri_segment'] = 4;
		$config['per_page'] = '50'; //Número de noticias por página
		$config['num_links'] = '3'; //Número de enlaces antes y después de la página actual
		$config['next_link'] = 'Siguiente&nbsp;&gt;';
		$config['prev_link'] = '&lt;&nbsp;Anterior';
		$config['first_link'] = '&lt;&lt;&nbsp;Primero'; //Texto del enlace que nos lleva a la página	&lt;
		$config['last_link'] = 'Último&nbsp;&gt;&gt;'; //Texto del enlace que nos lleva a la última página
		$this->pagination->initialize($config);

		$d['lista'] = $this->medico_model->obtenerListaMedicosCon($d,$config['per_page'],
		$this->uri->segment(4)); //le pasamos el total de elementos por página y el offset
		
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['tipo_medico']	= $this -> medico_model -> tipos_medico();
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/medico_busqueda',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
/////////////////////////////////////////////////////////////////////////////////////////////////	
	function crearMedico()
	{
		$d = array();
		$d['numero_documento'] 	= $this->input->post('numero_documentoC');
		//----------------------------------------------------------
		$existe = false;
		$verTer = $this -> tercero_model ->verificaTercero($d['numero_documento']);
		
		if($verTer != 0){
			
			$verMed = $this -> medico_model ->verificarMedico($verTer);
			
			if($verMed != 0){
				$dat['mensaje'] = "Ya existe un tercero con el número de documento de identidad ".$d['numero_documento']."!!";
				$dat['urlRegresar'] = site_url('core/administrar_medico/index');
				$this -> load -> view('core/presentacionMensaje', $dat);
				return;
			}else{
				$existe = true;	
			}
		}
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/administrar_medico');
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['pais']				= $this -> tercero_model -> obtenerPais();
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['tipo_medico']	= $this -> medico_model -> tipos_medico();	
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		if($existe){
			$d['tercero'] = $this -> tercero_model -> obtenerTercero($verTer);
			$this -> load -> view('core/medico_crear_edit',$d);
		}else{
			$this -> load -> view('core/medico_crear',$d);
		}
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function crearMedico_()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['numero_documento'] 	= $this->input->post('numero_documento');	
		$verTer = $this -> tercero_model ->verificaTercero($d['numero_documento']);
		if($verTer != 0){
			$dat['mensaje'] = "Ya existe un tercero con el número de documento de identidad ".$d['numero_documento']."!!";
			$dat['urlRegresar'] = site_url('core/administrar_medico/index');
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
		
		$d['id_especialidad']		= $this->input->post('id_especialidad');
		$d['tarjeta_profesional'] 	= $this->input->post('tarjeta_profesional');
		$d['estado'] 	= $this->input->post('estado');
		$d['fecha_inicio'] = $this->input->post('fecha_inicio');
		$d['fecha_fin'] = $this->input->post('fecha_fin');
		$d['id_tipo_medico'] 	= $this->input->post('id_tipo_medico');
		
		$d['_password'] 	= $this->input->post('_password');
		$d['_username'] 	= $this->input->post('_username');
		
		$d['observaciones'] 	= $this->input->post('observaciones');
		//----------------------------------------------------------
		$r = $this -> tercero_model -> crearTerceroDb($d);
		//----------------------------------------------------------
		$d['id_tercero'] 	= $r['id_tercero'];
		//----------------------------------------------------------
		$r = $this -> medico_model -> crearMedicoDb($d);
		//----------------------------------------------------------
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación del medico apellidos ".$d['id_tercero']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('core/administrar_medico/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Se creo el medico con id ".$r['id_medico']);
		//----------------------------------------------------------
		$dt['mensaje']  = "Se ha creado el profesional de la salud exitosamente!!";
		$dt['urlRegresar'] 	= site_url("core/administrar_medico/index");
		 
		//----------------------------------------------------------
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
	function crearMedicoEdit_()
	{
	//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
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
		$r = $this -> tercero_model -> editarTerceroDb($d);
		//----------------------------------------------------------
		$d['id_especialidad']		= $this->input->post('id_especialidad');
		$d['tarjeta_profesional'] 	= $this->input->post('tarjeta_profesional');
		$d['estado'] 	= $this->input->post('estado');
		$d['fecha_inicio'] = $this->input->post('fecha_inicio');
		$d['fecha_fin'] = $this->input->post('fecha_fin');
		$d['id_tipo_medico'] 	= $this->input->post('id_tipo_medico');
		$d['observaciones'] 	= $this->input->post('observaciones');
		$d['id_medico']		= $this->input->post('id_medico');	
		$d['_password'] 	= $this->input->post('_password');
		$d['_username'] 	= $this->input->post('_username');
		//----------------------------------------------------------
		$r = $this -> medico_model -> crearMedicoDb($d);
		//----------------------------------------------------------
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la modificación del medico con el ID ".$d['id_medico']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('core/administrar_medico/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Se modifico el medico con id ".$d['id_medico']);
		//----------------------------------------------------------
		$dt['mensaje']  = "Se ha modificado el profesional de la salud exitosamente!!";
		$dt['urlRegresar'] 	= site_url("core/administrar_medico/index");
		 
		//----------------------------------------------------------
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;		
	}
///////////////////////////////////////////////////////////////////	
	function editarMedico($id_medico)
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/administrar_medico');
		$d['especialidades']= $this -> medico_model -> tipos_especialidades();
		$d['tipo_medico']	= $this -> medico_model -> tipos_medico();
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['medico'] = $this -> medico_model -> obtenerMedicoConsulta($id_medico);
		$d['tercero'] = $this -> medico_model -> obtenerTercero($d['medico']['id_tercero']);
		$d['pais'] = $this -> tercero_model -> obtenerPais();
		$d['departamento']	 	= $this -> tercero_model -> obtenerDepartamento();
		$d['municipio'] 		= $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/medico_editar', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////	
	function editarMedico_()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
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
		$r = $this -> tercero_model -> editarTerceroDb($d);
		//----------------------------------------------------------
		$d['id_especialidad']		= $this->input->post('id_especialidad');
		$d['tarjeta_profesional'] 	= $this->input->post('tarjeta_profesional');
		$d['estado'] 	= $this->input->post('estado');
		$d['fecha_inicio'] = $this->input->post('fecha_inicio');
		$d['fecha_fin'] = $this->input->post('fecha_fin');
		$d['id_tipo_medico'] 	= $this->input->post('id_tipo_medico');
		$d['observaciones'] 	= $this->input->post('observaciones');
		$d['id_medico']		= $this->input->post('id_medico');	
		//----------------------------------------------------------
		$r = $this -> medico_model -> editarMedicoDb($d);
		//----------------------------------------------------------
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la modificación del medico con el ID ".$d['id_medico']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('core/administrar_medico/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Se modifico el medico con id ".$d['id_medico']);
		//----------------------------------------------------------
		$dt['mensaje']  = "Se ha modificado el profesional de la salud exitosamente!!";
		$dt['urlRegresar'] 	= site_url("core/administrar_medico/index");
		 
		//----------------------------------------------------------
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
	}
	
/////////////////////////////////////////////////////////////////////////////////////////////////
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
/////////////////////////////////////////////////////////////////////////////////////////////////
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
/////////////////////////////////////////////////////////////////////////////////////////////////
	function noAplicaMunicipio()
	{
		$cadena = '';
		$cadena .='<select name="municipio" id="municipio">';
		$cadena .= '<option value="99999">-No aplica-</option>';
		$cadena .='</select>';
		echo $cadena;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function verificarUsuario()
	{
		$username 	= $this->input->post('_username');
		$cadena = '';
		if($this->medico_model->verificarDisponibilidad($username)){
		$cadena =	form_input(array('name' => '_username',
							'id'=> '_username',
							'maxlength' => '20',
							'size'=> '20',
							'autocomplete' => 'off',
							'value' => $username,
							'class'=>"fValidate['alphanumtilde']"));
		$cadena .= "<b></b>&nbsp;Disponible</b>";					
		}else{
			$cadena = form_input(array('name' => '_username',
							'id'=> '_username',
							'maxlength' => '20',
							'size'=> '20',
							'autocomplete' => 'off',
							'class'=>"fValidate['alphanumtilde']"));
			$cadena .= "<b><a href='#username' onClick='verificarUsuario()'>&nbsp;Verificar disponibilidad</a></b>	&nbsp;<font color='#8A0808'>No disponible</font>";	
		}
		echo $cadena;
		
	}
}
