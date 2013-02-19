<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Administrar_funcionario extends Controller {

	function __construct()
	{
		parent::Controller();
		$this -> load -> helper('form');
		$this -> load -> model('core/funcionario_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model'); 	
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
		$config['base_url'] = site_url('core/administrar_funcionario/index');
		$config['total_rows'] = $this->funcionario_model->obtenerNumListaFuncionarios();
		$config['uri_segment'] = 4;
		$config['per_page'] = '30'; //Número de noticias por página
		$config['num_links'] = '3'; //Número de enlaces antes y después de la página actual
		$config['next_link'] = 'Siguiente&nbsp;&gt;';
		$config['prev_link'] = '&lt;&nbsp;Anterior';
		$config['first_link'] = '&lt;&lt;&nbsp;Primero'; //Texto del enlace que nos lleva a la página	&lt;
		$config['last_link'] = 'Último&nbsp;&gt;&gt;'; //Texto del enlace que nos lleva a la última página
		$this->pagination->initialize($config);

		$d['lista'] = $this->funcionario_model->obtenerListaFuncionarios($config['per_page'],
		$this->uri->segment(4)); //le pasamos el total de elementos por página y el offset
		
		$d['dependencias']= $this -> funcionario_model -> listaDependencias();
		
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/funcionario_busqueda',$d);
		$this->load->view('core/core_fin');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function buscarFuncionario()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/administrar_funcionario/index');	
		//----------------------------------------------------------
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		$d['primer_apellido'] 	= $this->input->post('primer_apellido');
		$d['segundo_apellido'] 	= $this->input->post('segundo_apellido');
		$d['primer_nombre'] 	= $this->input->post('primer_nombre');
		$d['segundo_nombre'] 	= $this->input->post('segundo_nombre');
		$d['id_dependencia'] 	= $this->input->post('id_dependencia');
		//----------------------------------------------------------
		//Configuración paginador
		$this->load->library('pagination');
		$config['base_url'] = site_url('core/administrar_funcionario/index');
		$config['total_rows'] = $this->funcionario_model->obtenerNumListaFuncionariosCon($d);
		$config['uri_segment'] = 4;
		$config['per_page'] = '30'; //Número de noticias por página
		$config['num_links'] = '3'; //Número de enlaces antes y después de la página actual
		$config['next_link'] = 'Siguiente&nbsp;&gt;';
		$config['prev_link'] = '&lt;&nbsp;Anterior';
		$config['first_link'] = '&lt;&lt;&nbsp;Primero'; //Texto del enlace que nos lleva a la página	&lt;
		$config['last_link'] = 'Último&nbsp;&gt;&gt;'; //Texto del enlace que nos lleva a la última página
		$this->pagination->initialize($config);

		$d['lista'] = $this->funcionario_model->obtenerListaFuncionariosCon($d,$config['per_page'],
		$this->uri->segment(4)); //le pasamos el total de elementos por página y el offset
		
		$d['dependencias']= $this -> funcionario_model -> listaDependencias();
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/funcionario_busqueda',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
/////////////////////////////////////////////////////////////////////////////////////////////////	
	function crearFuncionario()
	{
		//----------------------------------------------------------
		$d = array();
		$d['numero_documento'] 	= $this->input->post('numero_documentoC');
		$existe = false;
		$verTer = $this -> tercero_model ->verificaTercero($d['numero_documento']);
		if($verTer != 0){
			
			$verFun = $this -> funcionario_model ->verificarFuncionario($verTer);
			
			if($verFun != 0){
				$dat['mensaje'] = "Ya existe un tercero con el número de documento de identidad ".$d['numero_documento']."!!";
				$dat['urlRegresar'] = site_url('core/administrar_funcionario/index');
				$this -> load -> view('core/presentacionMensaje', $dat);
				return;
			}else{
				$existe = true;	
			}
		}
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/administrar_funcionario');
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['pais']				= $this -> tercero_model -> obtenerPais();
		$d['dependencias']= $this -> funcionario_model -> listaDependencias();
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
				if($existe){
			$d['tercero'] = $this -> tercero_model -> obtenerTercero($verTer);
			$this -> load -> view('core/funcionario_crear_edit',$d);
		}else{
			$this -> load -> view('core/funcionario_crear',$d);
		}
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function crearFuncionario_()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['numero_documento'] 	= $this->input->post('numero_documento');	
		$verTer = $this -> tercero_model ->verificaTercero($d['numero_documento']);
		if($verTer != 0){
			$dat['mensaje'] = "Ya existe un tercero con el número de documento de identidad ".$d['numero_documento']."!!";
			$dat['urlRegresar'] = site_url('core/administrar_funcionario/index');
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
		
		$d['id_dependencia']		= $this->input->post('id_dependencia');
		$d['cargo'] 	= mb_strtoupper($this->input->post('cargo'),'utf-8');
		$d['estado'] 	= $this->input->post('estado');
		$d['fecha_inicio'] = $this->input->post('fecha_inicio');
		$d['fecha_fin'] = $this->input->post('fecha_fin');
		
		$d['_password'] 	= $this->input->post('_password');
		$d['_username'] 	= $this->input->post('_username');
		
		$d['observaciones'] 	= $this->input->post('observaciones');
		//----------------------------------------------------------
		$r = $this -> tercero_model -> crearTerceroDb($d);
		//----------------------------------------------------------
		$d['id_tercero'] 	= $r['id_tercero'];
		//----------------------------------------------------------
		$r = $this -> funcionario_model -> crearFuncionarioDb($d);
		//----------------------------------------------------------
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación del funcionario ".$d['id_tercero']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('core/administrar_funcionario/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Se creo el funcionario con id ".$r['id_funcionario']);
		//----------------------------------------------------------
		$dt['mensaje']  = "Se ha creado el funcionario exitosamente!!";
		$dt['urlRegresar'] 	= site_url("core/administrar_funcionario/index");
		 
		//----------------------------------------------------------
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////
	function crearFuncionarioEdit_()
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
		$d['id_dependencia']		= $this->input->post('id_dependencia');
		$d['cargo'] 	= mb_strtoupper($this->input->post('cargo'),'utf-8');
		$d['estado'] 	= $this->input->post('estado');
		$d['fecha_inicio'] = $this->input->post('fecha_inicio');
		$d['fecha_fin'] = $this->input->post('fecha_fin');
		$d['observaciones'] 	= $this->input->post('observaciones');
		$d['id_funcionario']		= $this->input->post('id_funcionario');	
		$d['_password'] 	= $this->input->post('_password');
		$d['_username'] 	= $this->input->post('_username');
		//----------------------------------------------------------
		$r = $this -> funcionario_model -> crearFuncionarioDb($d);
		//----------------------------------------------------------
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la modificación del funcionario con el ID ".$d['id_funcionario']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('core/administrar_funcionario/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Se modifico el funcionario con id ".$d['id_funcionario']);
		//----------------------------------------------------------
		$dt['mensaje']  = "Se ha modificado el funcionario exitosamente!!";
		$dt['urlRegresar'] 	= site_url("core/administrar_funcionario/index");
		 
		//----------------------------------------------------------
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
	}
///////////////////////////////////////////////////////////////////	
	function editarFuncionario($id_funcionario)
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/administrar_funcionario');
		$d['dependencias']= $this -> funcionario_model -> listaDependencias();
	
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['funcionario'] = $this -> funcionario_model -> obtenerFuncionarioConsulta($id_funcionario);
		$d['tercero'] = $this -> funcionario_model -> obtenerTercero($d['funcionario']['id_tercero']);
		$d['pais'] = $this -> tercero_model -> obtenerPais();
		$d['departamento']	 	= $this -> tercero_model -> obtenerDepartamento();
		$d['municipio'] 		= $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/funcionario_editar', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////	
	function editarFuncionario_()
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
		$d['id_dependencia']		= $this->input->post('id_dependencia');
		$d['cargo'] 	= mb_strtoupper($this->input->post('cargo'),'utf-8');
		$d['estado'] 	= $this->input->post('estado');
		$d['fecha_inicio'] = $this->input->post('fecha_inicio');
		$d['fecha_fin'] = $this->input->post('fecha_fin');
		$d['observaciones'] 	= $this->input->post('observaciones');
		$d['id_funcionario']		= $this->input->post('id_funcionario');	
		//----------------------------------------------------------
		$r = $this -> funcionario_model -> editarFuncionarioDb($d);
		//----------------------------------------------------------
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la modificación del funcionario con el ID ".$d['id_funcionario']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('core/administrar_funcionario/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Se modifico el funcionario con id ".$d['id_funcionario']);
		//----------------------------------------------------------
		$dt['mensaje']  = "Se ha modificado el funcionario exitosamente!!";
		$dt['urlRegresar'] 	= site_url("core/administrar_funcionario/index");
		 
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
		if($this->funcionario_model->verificarDisponibilidad($username)){
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
