<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
class Administrar_ter extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this -> load -> helper('form');
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
		$config['base_url'] = site_url('core/administrar_ter/index');
		$config['total_rows'] = $this->tercero_model->obtenerNumListaTer();
		$config['uri_segment'] = 4;
		$config['per_page'] = '25'; //Número de noticias por página
		$config['num_links'] = '2'; //Número de enlaces antes y después de la página actual
		$config['next_link'] = 'Siguiente&nbsp;&gt;';
		$config['prev_link'] = '&lt;&nbsp;Anterior';
		$config['first_link'] = '&lt;&lt;&nbsp;Primero'; //Texto del enlace que nos lleva a la página	&lt;
		$config['last_link'] = 'Último&nbsp;&gt;&gt;'; //Texto del enlace que nos lleva a la última página
		$this->pagination->initialize($config);

		$d['lista'] = $this->tercero_model->obtenerListaTer($config['per_page'],
		$this->uri->segment(4)); //le pasamos el total de elementos por página y el offset
		
		$d['primer_apellido'] 	= "";
		$d['primer_nombre'] 	= "";
		$d['segundo_apellido'] 	= "";
		$d['segundo_nombre'] 	= "";
		$d['numero_documento'] 	= "";
		$d['razon_social'] 	= "";
		
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/tercero_busqueda',$d);
		$this->load->view('core/core_fin');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function buscarTercero()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/administrar_ter/index');	
		//----------------------------------------------------------
		$d['primer_apellido'] 	= $this->input->post('primer_apellido');
		$d['primer_nombre'] 	= $this->input->post('primer_nombre');
		$d['segundo_apellido'] 	= $this->input->post('segundo_apellido');
		$d['segundo_nombre'] 	= $this->input->post('segundo_nombre');
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		$d['razon_social'] 	= $this->input->post('razon_social');
		//----------------------------------------------------------
		//Configuración paginador
		$this->load->library('pagination');
		$config['base_url'] = site_url('core/administrar_ter/buscarTercero');
		$config['total_rows'] = $this->tercero_model->obtenerNumListaTerCon($d);
		$config['uri_segment'] = 4;
		$config['per_page'] = '25'; //Número de noticias por página
		$config['num_links'] = '2'; //Número de enlaces antes y después de la página actual
		$config['next_link'] = 'Siguiente&nbsp;&gt;';
		$config['prev_link'] = '&lt;&nbsp;Anterior';
		$config['first_link'] = '&lt;&lt;&nbsp;Primero'; //Texto del enlace que nos lleva a la página	&lt;
		$config['last_link'] = 'Último&nbsp;&gt;&gt;'; //Texto del enlace que nos lleva a la última página
		$this->pagination->initialize($config);

		$d['lista'] = $this->tercero_model->obtenerListaTerCon($d,$config['per_page'],
		$this->uri->segment(4)); //le pasamos el total de elementos por página y el offset

		//----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/tercero_busqueda',$d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
/////////////////////////////////////////////////////////////////////////////////////////////////	
	function crearTercero()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 	= site_url('core/administrar_ter/index');
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['pais']				= $this -> tercero_model -> obtenerPais();
		//----------------------------------------------------------
		
		$this->load->view('core/core_inicio');
		$this -> load -> view('core/tercero_crear', $d);
		$this->load->view('core/core_fin');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function crearTercero_()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
		$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
		$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
		$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
		$d['razon_social'] 	= mb_strtoupper($this->input->post('razon_social'),'utf-8');
		$d['fecha_nacimiento'] 	= $this->input->post('fecha_nacimiento');
		$d['id_tipo_documento'] 	= $this->input->post('id_tipo_documento');
		$d['numero_documento'] 	= $this->input->post('numero_documento');
		$d['pais'] 	= $this->input->post('pais');
		$d['departamento'] 	= $this->input->post('departamento');
		$d['municipio'] 	= $this->input->post('municipio');
		$d['vereda'] 	= mb_strtoupper($this->input->post('vereda'),'utf-8');
		$d['zona'] 	= $this->input->post('zona');
		$d['direccion'] 	= mb_strtoupper($this->input->post('direccion'),'utf-8');
		$d['telefono'] 	= $this->input->post('telefono');
		$d['celular'] 	= $this->input->post('celular');
		$d['fax'] 	= $this->input->post('fax');
		$d['email'] 	= $this->input->post('email');
		$d['observaciones'] 	= mb_strtoupper($this->input->post('observaciones'),'utf-8');
		$d['id_usuario'] 	= $this -> session -> userdata('id_usuario');	
		//----------------------------------------------------------
		$r = $this -> tercero_model -> crearTerceroDb($d);
		//----------------------------------------------------------
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación del tercero apellidos ".$d['primer_apellido']." ".$d['segundo_apellido']."documento de identidad ".$d['numero_documento']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('core/administrar_ter/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Se creo el tercero con id ".$r['id_tercero']);
		//----------------------------------------------------------
		redirect('core/administrar_ter');
		//----------------------------------------------------------	
	}
///////////////////////////////////////////////////////////////////	
function editarTercero($id_tercero)
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['urlRegresar'] 		= site_url('core/administrar_ter/index');
		$d['tercero']			= $this -> tercero_model -> obtenerTercero($id_tercero);
		$d['tipo_documento']	= $this -> tercero_model -> tipos_documento();
		$d['pais']				= $this -> tercero_model -> obtenerPais();
		$d['departamento']	 	= $this -> tercero_model -> obtenerDepartamento();
		$d['municipio'] 		= $this -> tercero_model -> obtenerMunicipio($d['tercero']['departamento']);
		//----------------------------------------------------------

		$this->load->view('core/core_inicio');
		$this -> load -> view('core/tercero_editar', $d);
		$this->load->view('core/core_fin');
	}
///////////////////////////////////////////////////////////////////	
	function editarTercero_()
	{
		//----------------------------------------------------------
		$d = array();
		//----------------------------------------------------------
		$d['id_tercero'] 	= $this->input->post('id_tercero');
		$d['primer_apellido'] 	= mb_strtoupper($this->input->post('primer_apellido'),'utf-8');
		$d['segundo_apellido'] 	= mb_strtoupper($this->input->post('segundo_apellido'),'utf-8');
		$d['primer_nombre'] 	= mb_strtoupper($this->input->post('primer_nombre'),'utf-8');
		$d['segundo_nombre'] 	= mb_strtoupper($this->input->post('segundo_nombre'),'utf-8');
		$d['razon_social'] 	= mb_strtoupper($this->input->post('razon_social'),'utf-8');
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
		$d['id_usuario'] 	= $this -> session -> userdata('id_usuario');	
		//----------------------------------------------------------
		$r = $this -> tercero_model -> editarTerceroDb($d);
		//----------------------------------------------------------
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la modificación del tercero con el ID ".$d['id_tercero']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('core/administrar_ter/index');
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------------
		$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Se modifico el tercero con id ".$d['id_tercero']);
		//----------------------------------------------------------
		redirect('core/administrar_ter');
		//----------------------------------------------------------	
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
	function pdf ()
	{
		$data = 0;
		$this ->load->plugin('to_pdf');
		$html = $this->load->view( 'welcome_message' , $data , true );
		pdf_create ($html,'pruebas'); 
	}
}