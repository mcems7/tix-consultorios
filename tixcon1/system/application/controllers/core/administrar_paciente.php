<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Administrar_paciente extends Controller {

	function __construct()
	{
		parent::Controller();
		$this -> load -> helper('form');
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
		$config['base_url'] = site_url('core/administrar_paciente/index');
		$config['total_rows'] = $this->paciente_model->obtenerNumListaPac();
		$config['uri_segment'] = 4;
		$config['per_page'] = '30'; //Número de noticias por página
		$config['num_links'] = '3'; //Número de enlaces antes y después de la página actual
		$config['next_link'] = 'Siguiente&nbsp;&gt;';
		$config['prev_link'] = '&lt;&nbsp;Anterior';
		$config['first_link'] = '&lt;&lt;&nbsp;Primero'; //Texto del enlace que nos lleva a la página	&lt;
		$config['last_link'] = 'Último&nbsp;&gt;&gt;'; //Texto del enlace que nos lleva a la última página
		$this->pagination->initialize($config);

		$d['lista'] = $this->paciente_model->obtenerListaPac($config['per_page'],
		$this->uri->segment(4)); //le pasamos el total de elementos por página y el offset
		
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/paciente_busqueda',$d);
		$this->load->view('core/core_fin');
	}

/////////////////////////////////////////////////////////////////////////////////////////////////
	function buscarPaciente()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/home/index');	
		//----------------------------------------------------------
		$d['primer_apellido'] 	= $this->input->post('primer_apellido');
		$d['primer_nombre'] 	= $this->input->post('primer_nombre');
		$d['segundo_apellido'] 	= $this->input->post('segundo_apellido');
		$d['segundo_nombre'] 	= $this->input->post('segundo_nombre');
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		$d['id_cobertura'] 	= $this->input->post('id_cobertura');
		//----------------------------------------------------------
		//Configuración paginador
		$this->load->library('pagination');
		$config['base_url'] = site_url('core/administrar_paciente/index');
		$config['total_rows'] = $this->paciente_model->obtenerNumListaPacCon($d);
		$config['uri_segment'] = 4;
		$config['per_page'] = '30'; //Número de noticias por página
		$config['num_links'] = '3'; //Número de enlaces antes y después de la página actual
		$config['next_link'] = 'Siguiente&nbsp;&gt;';
		$config['prev_link'] = '&lt;&nbsp;Anterior';
		$config['first_link'] = '&lt;&lt;&nbsp;Primero'; //Texto del enlace que nos lleva a la página	&lt;
		$config['last_link'] = 'Último&nbsp;&gt;&gt;'; //Texto del enlace que nos lleva a la última página
		$this->pagination->initialize($config);

		$d['lista'] = $this->paciente_model->obtenerListaPacCon($d,$config['per_page'],
		$this->uri->segment(4)); //le pasamos el total de elementos por página y el offset
		
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/paciente_busqueda',$d);
		$this->load->view('core/core_fin');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function veriPaciente()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/administrar_paciente');
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/paciente_verificar', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function verificarPaciente_()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		$verTer = $this -> tercero_model -> verificaTercero($d['numero_documento']);
		//Verifica la existencia del tercero en el sistema
		if($verTer != 0){
			$verPas = $this -> paciente_model -> verificarPaciente($verTer);
			//Verifica la existencia del tercero como paciente
			if($verPas != 0){
				redirect('core/administrar_paciente/editarPaciente/'.$verPas);
			}else{
				redirect('core/administrar_paciente/crearPaciente/'.$verTer);
			}
		}else{
			redirect('core/administrar_paciente/crearTerceroPaciente');
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function crearTerceroPaciente()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/administrar_paciente');
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['pais']				= $this -> tercero_model -> obtenerPais();
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['entidad'] = $this -> paciente_model -> obtenerEntidades();
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/paciente_crear_ter', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function crearPaciente($id_tercero)
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/administrar_paciente');
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['pais']				= $this -> tercero_model -> obtenerPais();
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['entidad'] = $this -> paciente_model -> obtenerEntidades();
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($id_tercero);
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/paciente_crear', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function crearPacienteTer_()
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
		
		$d['genero'] 	= $this->input->post('genero');
		$d['estado_civil'] 	= $this->input->post('estado_civil');
		$d['id_entidad'] 	= $this->input->post('id_entidad');
		$d['id_cobertura'] = $this->input->post('id_cobertura');
		$d['tipo_afiliado'] = $this->input->post('tipo_afiliado');
		$d['nivel_categoria'] 	= $this->input->post('nivel_categoria');
		$d['desplazado'] 	= $this->input->post('desplazado');
		$d['observaciones'] = $this->input->post('observaciones');
		//----------------------------------------------------------
		$r = $this -> tercero_model -> crearTerceroDb($d);
		//----------------------------------------------------------
		$d['id_tercero'] 	= $r['id_tercero'];
		//----------------------------------------------------------
		$r = $this -> paciente_model -> crearPacienteDb($d);
		//----------------------------------------------------------
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación del paciente ".$d['id_tercero']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('core/administrar_paciente/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Se creo el paciente con id ".$r['id_paciente']);
		//----------------------------------------------------------
		$dt['mensaje']  = "Se ha creado el paciente exitosamente!!";
		$dt['urlRegresar'] 	= site_url("core/administrar_paciente/index");
		 
		//----------------------------------------------------------
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------	
	}

///////////////////////////////////////////////////////////////////
	function crearPaciente_()
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
		$d['genero'] 	= $this->input->post('genero');
		$d['estado_civil'] 	= $this->input->post('estado_civil');
		$d['id_entidad'] 	= $this->input->post('id_entidad');
		$d['id_cobertura'] = $this->input->post('id_cobertura');
		$d['tipo_afiliado'] = $this->input->post('tipo_afiliado');
		$d['nivel_categoria'] 	= $this->input->post('nivel_categoria');
		$d['desplazado'] 	= $this->input->post('desplazado');
		//----------------------------------------------------------
		$r = $this -> paciente_model -> crearPacienteDb($d);
		//----------------------------------------------------------
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación del paciente ".$d['id_tercero']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('core/administrar_paciente/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Se creo el paciente con id ".$r['id_paciente']);
		//----------------------------------------------------------
		$dt['mensaje']  = "Se ha creado el paciente exitosamente!!";
		$dt['urlRegresar'] 	= site_url("core/administrar_paciente/index");
		 
		//----------------------------------------------------------
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
		//----------------------------------------------------------	
		
	}
///////////////////////////////////////////////////////////////////
	function editarPaciente($id_paciente)
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/administrar_paciente');
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($id_paciente);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['tipo_usuario']	= $this -> paciente_model -> tipos_usuario();
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();		
		$d['pais']				= $this -> tercero_model -> obtenerPais();
		$d['departamento']	 	= $this -> tercero_model -> obtenerDepartamento();	
		$d['municipio'] 		= $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
		$d['entidad'] = $this -> paciente_model -> obtenerEntidades();
		
		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/paciente_editar', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////	
	function editarPacienteTer_()
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
		$d['genero'] 	= $this->input->post('genero');
		$d['estado_civil'] 	= $this->input->post('estado_civil');
		$d['id_entidad'] 	= $this->input->post('id_entidad');
		$d['id_cobertura'] = $this->input->post('id_cobertura');
		$d['tipo_afiliado'] = $this->input->post('tipo_afiliado');
		$d['nivel_categoria'] 	= $this->input->post('nivel_categoria');
		$d['desplazado'] 	= $this->input->post('desplazado');
		$d['id_paciente'] 	= $this->input->post('id_paciente');
		//----------------------------------------------------------
		$r = $this -> paciente_model -> editarPacienteDb($d);
		//----------------------------------------------------------
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la modificación del paciente con el ID ".$d['id_paciente']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('core/administrar_paciente/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Se modifico el paciente con id ".$d['id_paciente']);
		//----------------------------------------------------------
		$dt['mensaje']  = "Se ha modificado el paciente exitosamente!!";
		$dt['urlRegresar'] 	= site_url("core/administrar_paciente/index");
		 
		//----------------------------------------------------------
		$this -> load -> view('core/presentacionMensaje', $dt);
		return;	
	}	
/////////////////////////////////////////////////////////////////////////////////////////////////
}