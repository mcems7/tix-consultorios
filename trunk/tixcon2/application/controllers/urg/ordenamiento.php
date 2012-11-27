<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Ordenamiento
 *Tipo: controlador
 *Descripcion: Permite gestionar el ordenamiento de insumos médicos
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 28 de septiembre de 2010
*/
class Ordenamiento extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this -> load -> model('urg/urgencias_model');
		$this -> load -> model('core/paciente_model');
		$this -> load -> model('core/tercero_model');
		$this -> load -> library('lib_edad');
		$this -> load -> helper( array('url','form') );
		$this -> load -> model('core/Registro'); 
	}
///////////////////////////////////////////////////////////////////
/*
* Vista con el formato de ingreso de la orden de insumos médicos
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100928
* @version		20100928
*/	
	function main($id_atencion)
	{
		//----------------------------------------------------------
		$d = array();
		$d['id_atencion'] = $id_atencion;
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		
		$id_serv = $d['atencion']['id_servicio'];
		if($id_serv == 16 || $id_serv == 17 || $id_serv == 18){
		$d['urlRegresar'] 	= site_url('urg/observacion/main/'.$id_atencion);
		}else{
		$d['urlRegresar'] 	= site_url('urg/gestion_atencion/main/'.$id_atencion);
		}
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['ordenes'] = $this -> urgencias_model -> obtenerOrdenes($id_atencion);
    $d['verificar_orden'] = $this -> urgencias_model -> obtenerUltOrden ($id_atencion);
    //print_r($d['ordenes']);die();
		//-----------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_ordListado', $d);
		$this->load->view('core/core_fin');
		//----------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
/*
* Crear una nueva orden de insumos médicos
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100928
* @version		20100928
*/	
	function crearOrden($id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['orden'] = $this->urgencias_model->obtenerUltOrden($id_atencion);
		$d['urlRegresar'] 	= site_url('urg/ordenamiento/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['med']['vias'] = $this -> urgencias_model -> obtenerVarMedi('vias');
		$d['med']['unidades'] = $this -> urgencias_model -> obtenerVarMedi('unidades');
		$d['med']['frecuencia'] = $this -> urgencias_model -> obtenerVarMedi('frecuencia');
		$d['cuidados'] = $this -> urgencias_model -> obtenerCuidadosE();
		if($d['atencion']['id_servicio'] != 14){
		$d['tipo_cups'] = $this -> urgencias_model -> obtenerTiposCupsUrg(); 
		}else{
		$d['tipo_cups'] = $this -> urgencias_model -> obtenerTiposCupsUrgGine();
		}
		//---------------------------------------------------------------
		$d['dietas'] = $this -> urgencias_model -> obtenerDietas();
		$d['o2'] = $this -> urgencias_model -> obtenerOxigeno();
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this ->load -> view('urg/urg_ordCrear', $d);
		//---------------------------------------------------------------
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function crearOrdenEdit($id_atencion)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['orden'] = $this->urgencias_model->obtenerUltOrden($id_atencion);
		$d['urlRegresar'] 	= site_url('urg/ordenamiento/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['med']['vias'] = $this -> urgencias_model -> obtenerVarMedi('vias');
		$d['med']['unidades'] = $this -> urgencias_model -> obtenerVarMedi('unidades');
		$d['med']['frecuencia'] = $this -> urgencias_model -> obtenerVarMedi('frecuencia');
		//---------------------------------------------------------------
		$d['cuidados'] = $this -> urgencias_model -> obtenerCuidadosE();
		$d['dietas'] = $this -> urgencias_model -> obtenerDietas();
		$d['o2'] = $this -> urgencias_model -> obtenerOxigeno();
		if($d['atencion']['id_servicio'] == 14){
		$d['tipo_cups'] = $this -> urgencias_model -> obtenerTiposCupsUrgGine();
		}else{
		$d['tipo_cups'] = $this -> urgencias_model -> obtenerTiposCupsUrg(); 
		}
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$d['id_oxigeno_valor'] = $this -> urgencias_model -> obtenerTipoOxigeno($d['orden']['id_tipo_oxigeno']);
		$d['ordenDietas'] = $this -> urgencias_model -> obtenerDietasOrden($d['orden']['id_orden']);
		$d['ordenCuid'] = $this -> urgencias_model -> obtenerCuidadosOrden($d['orden']['id_orden']);
		$d['ordenMedi'] = $this -> urgencias_model -> obtenerMediOrdenNueva($d['orden']['id_orden']);
		
		$d['ordenCups'] = $this -> urgencias_model -> obtenerCupsOrden($d['orden']['id_orden']);
		$d['ordenCupsLaboratorios'] = $this -> urgencias_model -> obtenerCupsLaboratorios($d['orden']['id_orden']);
		$d['ordenCupsImagenes'] = $this -> urgencias_model -> obtenerCupsImagenes($d['orden']['id_orden']);
		//---------------------------------------------------------------
		// Calculo de tiempo para orden totalmente nueva;
		$fecha_ord = explode(" ", $d['orden']['fecha_creacion']);
		list($anno, $mes, $dia) = explode( '-', $fecha_ord[0] );
		list($hora, $min, $seg)= explode( ':', $fecha_ord[1] );
		$fecha_orden = mktime( $hora , $min , $seg , $mes , $dia , $anno );

		$hora_limite = mktime('6','00' ,'00' ,date('m'),date('d'),date('Y'));
		$fecha = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
		
		
		if($fecha >= $hora_limite){
			if($hora_limite >= $fecha_orden){
				$d['bandera'] = 'Nuevo';
			}else{
				$d['bandera'] = 'Continua';
			}
		}else{
			$d['bandera'] = 'Continua';
		}
	
		
		//die();
		//---------------------------------------------------------------
		$this -> load -> view('urg/urg_ordCrearEdit', $d);
		//---------------------------------------------------------------
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}


function consultarOrden($id_orden)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['orden'] = $this->urgencias_model->obtenerOrden($id_orden);
    $id_atencion = $d['orden']['id_atencion'];
    $d['urlRegresar']   = site_url('urg/ordenamiento/main/'.$id_atencion);
    $d['ordenDietas'] = $this -> urgencias_model -> obtenerDietasOrden($id_orden);
    $d['ordenMedi'] = $this -> urgencias_model -> obtenerMediOrden($id_orden);
    $d['ordenCups'] = $this -> urgencias_model -> obtenerCupsOrden($id_orden);
    $d['ordenCupsLaboratorios'] = $this -> urgencias_model -> obtenerCupsLaboratorios($id_orden);
    $d['ordenCupsImagenes'] = $this -> urgencias_model -> obtenerCupsImagenes($id_orden);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['dietas'] = $this -> urgencias_model -> obtenerDietas();
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
    $d['ordenCuid'] = $this -> urgencias_model -> obtenerCuidadosOrden($id_orden);
    $d['ordenInsumos'] = $this -> urgencias_model -> obtenerOrdenInsumos($id_orden);
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $this -> load -> view('urg/urg_ordConsultar', $d);
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////
	
/*
* Verifica la ultimo ordenamiento medico registrado
*
* @author William Alberto Ospina Zapata <wospina@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since    20101116
* @version    20101116
*/  
	function verificarOrdenEdit($id_atencion)
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['orden'] = $this->urgencias_model->obtenerUltOrden($id_atencion);
    $d['urlRegresar']   = site_url('urg/ordenamiento/main/'.$id_atencion);
    $d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
    $d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
    $d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
    $d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
    $d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
    $d['med']['vias'] = $this -> urgencias_model -> obtenerVarMedi('vias');
    $d['med']['unidades'] = $this -> urgencias_model -> obtenerVarMedi('unidades');
    $d['med']['frecuencia'] = $this -> urgencias_model -> obtenerVarMedi('frecuencia');
    //print_r($d['med']['vias']);die();
    //---------------------------------------------------------------
    $d['cuidados'] = $this -> urgencias_model -> obtenerCuidadosE();
    $d['dietas'] = $this -> urgencias_model -> obtenerDietas();
    $d['o2'] = $this -> urgencias_model -> obtenerOxigeno();
    //---------------------------------------------------------------
    $this->load->view('core/core_inicio');
    $d['id_oxigeno_valor'] = $this -> urgencias_model -> obtenerTipoOxigeno($d['orden']['id_tipo_oxigeno']);
    $d['ordenDietas'] = $this -> urgencias_model -> obtenerDietasOrden($d['orden']['id_orden']);
    $d['ordenCuid'] = $this -> urgencias_model -> obtenerCuidadosOrden($d['orden']['id_orden']);
    $d['ordenMedi'] = $this -> urgencias_model -> obtenerMediOrden($d['orden']['id_orden']);
    $d['ordenCups'] = $this -> urgencias_model -> obtenerCupsOrden($d['orden']['id_orden']);
    $d['ordenCupsLaboratorios'] = $this -> urgencias_model -> obtenerCupsLaboratorios($d['orden']['id_orden']);
	$d['ordenCupsImagenes'] = $this -> urgencias_model -> obtenerCupsImagenes($d['orden']['id_orden']);
	$this -> load -> view('urg/urg_ordVerificarEdit', $d);
    //---------------------------------------------------------------
    $this->load->view('core/core_fin'); 
    //---------------------------------------------------------------
  }
///////////////////////////////////////////////////////////////////
	function agregarDieta()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_dieta'] = $this->input->post('id_dieta_');
		$d['dieta'] = $this->urgencias_model->obtenerDieta($d['id_dieta']);
		echo $this->load->view('urg/urg_ordInfoDieta',$d);
	}
///////////////////////////////////////////////////////////////////	
	function tipoOxigeno()
	{
		$id_o2 = $this->input->post('id_oxigeno');
		$tipos = $this -> urgencias_model -> obtenerTipoOxigeno($id_o2);
		$cadena = '';
		if($tipos != 0){
		$cadena .= '<select name="id_oxigeno_valor" id="id_oxigeno_valor">';
		$cadena .= '<option value="0" selected="selected">-Seleccione uno-</option>';
		foreach($tipos as $d)
		{
			$cadena .= '<option value="'.$d['id_oxigeno_valor'].'">'.$d['tipo_oxigeno'].'</option>';
		}
		$cadena .= '</select>';
		echo $cadena;
		}else{
			echo "No aplica";
		}
	}
///////////////////////////////////////////////////////////////////
/*
* Metodo de autocompletado para diagnosticos simple 
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100901
* @version		20100901
* @return		HTML
*/	
	function medicamentos($l)
	{
		$l = preg_replace("/[^a-z0-9 ]/si","",$l);
		$this->load->database();
		$this->db->like('medicamento',$l);
		$r = $this->db->get('coam_medicamentos');
		$dat = $r -> result_array();
		foreach($dat as $d)
		{
			echo $d["id"]."###".$d["medicamento"]."|";
		}
	}
///////////////////////////////////////////////////////////////////


/*
* Agregar medicamento al listado 
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100930
* @version		20100930
* @return		HTML
*/	
	function agregarMedicamento()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['pos'] = $this->input->post('pos');
		$d['atc'] = $this->input->post('atc_ID');
		$d['dosis'] = $this->input->post('dosis');
		$d['id_unidad'] = $this->input->post('id_unidad');
		$d['frecuencia'] = $this->input->post('frecuencia');
		$d['id_frecuencia'] = $this->input->post('id_frecuencia');
		$d['id_via'] = $this->input->post('id_via');
		$d['observacionesMed'] = mb_strtoupper($this->input->post('observacionesMed'),'utf-8');
		$d['via'] = $this->urgencias_model->obtenerValorVarMedi($d['id_via']);
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia']);
		$d['unidad'] = $this->urgencias_model->obtenerValorVarMedi($d['id_unidad']);
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc']);
		$pos = $this->urgencias_model->obtenerMedicamentoPos($d['atc']);
		$d['pos'] = $pos['pos'];
		$d['bandera'] = 'Nuevo';
		echo $this->load->view('urg/urg_ordInfoMedicamento',$d);
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
* @copyright    GNU GPL 3.0
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
* @copyright    GNU GPL 3.0
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
		$d['observacionesCups'] =  mb_strtoupper($this->input->post('observacionesCups'),'utf-8');
		$d['cantidadCups'] = $this->input->post('cantidadCups');
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		echo $this->load->view('urg/urg_ordInfoProcedimiento',$d);
	}
///////////////////////////////////////////////////////////////////
/*
* Verifica y confirma las ordenes médicas gestionadas por internos
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20101001
* @version		20101001
* @return		HTML
*/
	function ordConfirma()
	{
		$d['_username'] 		= $this->input->post('user_log');
		$d['_password'] 		= md5($this->input->post('pass_log'));
		$dat['med'] = $this -> urgencias_model -> verificarMedicoConsulta($d);
		if($dat['med'] == 0){
			
			echo "<script>alert('Verifique los datos del usuario e intente de nuevo!!');</script>";
			echo $this->load->view('urg/urg_ordConfirm');	
		}else{
			echo $this->load->view('urg/urg_ordMedConfirm',$dat);
		}
		
	}
///////////////////////////////////////////////////////////////////
	function crearOrden_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_atencion'] 	= $this->input->post('id_atencion');
		$d['id_medico'] 	= $this->input->post('id_medico');
		$d['id_dieta'] 		= $this->input->post('id_dieta');
		$d['cama_cabeza'] 	= $this->input->post('cama_cabeza');
		$d['cama_pie'] 		= $this->input->post('cama_pie');
		$d['oxigeno'] 		= $this->input->post('oxigeno');
		$d['id_oxigeno'] 	= $this->input->post('id_oxigeno');
		$d['id_oxigeno_valor'] 	= $this->input->post('id_oxigeno_valor');
		$d['liquidos'] 		= $this->input->post('liquidos');
		
		$d['id_cuidado'] = $this->input->post('id_cuidado_');
		$d['frecuencia_cuidado'] = $this->input->post('frecuencia_cuidado_');
		$d['id_frecuencia_cuidado'] = $this->input->post('id_frecuencia_cuidado_');
		
		$d['cuidados_generales'] = mb_strtoupper($this->input->post('cuidados_generales'),'utf-8');
		
		$d['id'] 	= $this->input->post('id_');
		$d['atc'] 	= $this->input->post('atc_');
		$d['dosis'] 	= $this->input->post('dosis_');
		$d['id_unidad'] 	= $this->input->post('id_unidad_');
		$d['frecuencia'] 	= $this->input->post('frecuencia_');
		$d['id_frecuencia'] 	= $this->input->post('id_frecuencia_');
		$d['id_via'] 	= $this->input->post('id_via_');
		$d['pos'] 	= $this->input->post('pos_');
		
		$d['bandera'] 	= $this->input->post('bandera');
		
		$d['observacionesMed'] 	= $this->input->post('observacionesMed_');
		$d['cups'] 	= $this->input->post('cups_');
		$d['observacionesCups'] 	=$this->input->post('observacionesCups_');
		$d['cantidadCups'] 	= $this->input->post('cantidadCups_');
		
		$d['verificado'] = $this->input->post('verificado');
		$d['id_medico_verifica'] = $this->input->post('id_medico_verifica');
		$d['fecha_verificado'] 	= $this->input->post('fecha_verificado');
		$d['fecha_ini_ord'] 	= $this->input->post('fecha_ini_ord');
		$atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
		$d['id_servicio'] = $atencion['id_servicio']; 
		//----------------------------------------------------------
		$cont = 0;
		$n = count($d['pos']);
		for($i=0;$i<$n;$i++)
		{
			if($d['pos'][$i] == 'NO')
				$cont++;
		}
		//----------------------------------------------------------
		
		$this -> urgencias_model -> actualizarEstado($d['id_atencion'],'4');
		$r = $this -> urgencias_model -> crearOrdenDb($d);
		if($r['error'])
		{
			$this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
			,'aplicacion',"Error en la creación del ordenamiento en la ".$d['id_atencion']);
			$dat['mensaje'] = "La operación no se realio con exito.";
			$dat['urlRegresar'] = site_url('urg/ordenamiento/main/'.$d['id_atencion']);
			$this -> load -> view('core/presentacionMensaje', $dat);
			return;
		}
		//----------------------------------------------------
		if($cont > 0){
			redirect('urg/ordenamiento/formatoNoPos/'.$r['id_orden']);		
		}else{
			$dt['mensaje']  = "La orden médica ha sido almacenado correctamente!!";
			$dt['urlRegresar'] 	= site_url("urg/ordenamiento/main/".$d['id_atencion']);
			$this -> load -> view('core/presentacionMensaje', $dt);
			return;
		}
		//----------------------------------------------------------
		
	}
///////////////////////////////////////////////////////////////////
/*
* Verifica, confirma y actualiza las ordenes médicas gestionadas por internos
*
* @author William Alberto Ospina Zapata <wospina@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since    20101116
* @version    20101116
* @return   HTML
*/
  function verificarOrden_()
  {
    //---------------------------------------------------------------
    $d = array();
    //---------------------------------------------------------------
    $d['id_orden']   = $this->input->post('id_orden');
    $d['id_atencion']   = $this->input->post('id_atencion');
    $d['id_medico']   = $this->input->post('id_medico');
    $d['id_dieta']    = $this->input->post('id_dieta');
    $d['cama_cabeza']   = $this->input->post('cama_cabeza');
    $d['cama_pie']    = $this->input->post('cama_pie');
    $d['oxigeno']     = $this->input->post('oxigeno');
    $d['id_oxigeno']  = $this->input->post('id_oxigeno');
    $d['id_oxigeno_valor']  = $this->input->post('id_oxigeno_valor');
    $d['liquidos']    = $this->input->post('liquidos');
    
    $d['id_cuidado'] = $this->input->post('id_cuidado_');
    $d['frecuencia_cuidado'] = $this->input->post('frecuencia_cuidado_');
    $d['id_frecuencia_cuidado'] = $this->input->post('id_frecuencia_cuidado_');
    
    $d['cuidados_generales'] = mb_strtoupper($this->input->post('cuidados_generales'),'utf-8');
    
    $d['atc']   = $this->input->post('atc_');
    $d['dosis']   = $this->input->post('dosis_');
    $d['id_unidad']   = $this->input->post('id_unidad_');
    $d['frecuencia']  = $this->input->post('frecuencia_');
    $d['id_frecuencia']   = $this->input->post('id_frecuencia_');
    $d['id_via']  = $this->input->post('id_via_');
    $d['observacionesMed']  = $this->input->post('observacionesMed_');
    $d['cups']  = $this->input->post('cups_');
    $d['observacionesCups']   = $this->input->post('observacionesCups_');
	$d['cantidadCups']   = $this->input->post('cantidadCups_');
    
    $d['verificado'] = $this->input->post('verificado');
    $d['id_medico_verifica'] = $this->input->post('id_medico_verifica');
    $d['fecha_verificado']  = $this->input->post('fecha_verificado');
    $d['fecha_ini_ord']   = $this->input->post('fecha_ini_ord');
    
    $atencion = $this -> urgencias_model -> obtenerAtencion($d['id_atencion']);
    $d['id_servicio'] = $atencion['id_servicio']; 
    //----------------------------------------------------------
    $this -> urgencias_model -> actualizarEstado($d['id_atencion'],'4');
    $r = $this -> urgencias_model -> verificarOrdenDb($d);
    if($r['error'])
    {
      $this -> Registro -> agregar($this -> session -> userdata('id_usuario'),'core',__CLASS__,__FUNCTION__
      ,'aplicacion',"Error en la creación del ordenamiento en la ".$d['id_atencion']);
      $dat['mensaje'] = "La operación no se realio con exito.";
      $dat['urlRegresar'] = site_url('urg/ordenamiento/main/'.$d['id_atencion']);
      $this -> load -> view('core/presentacionMensaje', $dat);
      return;
    }
    //----------------------------------------------------
    $dt['mensaje']  = "La orden médica ha sido verificada correctamente!!";
    $dt['urlRegresar']  = site_url("urg/ordenamiento/main/".$d['id_atencion']);
    $this -> load -> view('core/presentacionMensaje', $dt);
    return; 
    //----------------------------------------------------------
    
  }
///////////////////////////////////////////////////////////////////
	function agregarCuidado()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_cuidado'] = $this->input->post('id_cuidado');
		$d['frecuencia_cuidado'] = $this->input->post('frecuencia_cuidado');
		$d['id_frecuencia_cuidado'] = $this->input->post('id_frecuencia_cuidado');
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia_cuidado']);
		$d['cuidado'] = $this->urgencias_model->obtenerCuidadoDetalle($d['id_cuidado']);
		echo $this->load->view('urg/urg_ordInfoCuidado',$d);	
	}
///////////////////////////////////////////////////////////////////
	function formatoNoPos($id_orden)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['orden'] = $this->urgencias_model->obtenerOrden($id_orden);
		$id_atencion = $d['orden']['id_atencion'];
		$d['ordenMedi'] = $this -> urgencias_model -> obtenerMediOrdenNoPos($id_orden);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['orden']['id_medico']);
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$this -> load -> view('urg/urg_ordNoPos', $d);
		$this->load->view('core/core_fin'); 
		//---------------------------------------------------------------
	}
///////////////////////////////////////////////////////////////////
	function agregarPosSustituto()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$cont   = $this->input->post('cont');
		$d['atc_pos']   = $this->input->post($cont.'atc_pos');		
		$d['atcNoPos']   = $this->input->post($cont.'atcNoPos');
		$d['dias_tratamientoPos']   = $this->input->post($cont.'dias_tratamientoPos');
		$d['dosis_diariaPos']   = $this->input->post($cont.'dosis_diariaPos');
		$d['cantidad_mes']   = $this->input->post($cont.'cantidad_mes');
		$d['resp_clinica']   = $this->input->post($cont.'resp_clinica');
		$d['resp_clinica_cual']   = $this->input->post($cont.'resp_clinica_cual');
		$d['contraindicacion']   = $this->input->post($cont.'contraindicacion');
		$d['contraindicacion_cual']   = $this->input->post($cont.'contraindicacion_cual');
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc_pos']);
		$this -> load -> view('urg/urg_ordInfoMedicamentoNoPos', $d);
		//--------------------------------------------------------------- 
	}
///////////////////////////////////////////////////////////////////	
	function formatoNoPos_()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['id_atencion']   = $this->input->post('id_atencion');
		$d['id_orden']   = $this->input->post('id_orden');
		$d['atcNoPos']   = $this->input->post('atcNoPos');
		$d['resumen_historia']   = $this->input->post('resumen_historia');
		$d['dias_tratamiento']   = $this->input->post('dias_tratamiento');
		$d['dosis_diaria']   = $this->input->post('dosis_diaria');
		$d['cantidad_mes']   = $this->input->post('cantidad_mes');
		$d['ventajas']   = $this->input->post('ventajas');
		
		$d['atc_pos']   = $this->input->post('atc_pos_');
		$d['atcNoPosSus']   = $this->input->post('atcNoPos_');
		$d['dias_tratamientoPos']   = $this->input->post('dias_tratamientoPos_');
		$d['dosis_diariaPos']   = $this->input->post('dosis_diariaPos_');
		$d['cantidad_mesPos']   = $this->input->post('cantidad_mesPos_');
		$d['resp_clinica']   = $this->input->post('resp_clinica_');
		$d['resp_clinica_cual']   = $this->input->post('resp_clinica_cual_');
		$d['contraindicacion']   = $this->input->post('contraindicacion_');
		$d['contraindicacion_cual']   = $this->input->post('contraindicacion_cual_');
		//--------------------------------------------------------------- 
		$this -> urgencias_model -> formatoNoPosDb($d);
		//---------------------------------------------------------------
		redirect("urg/ordenamiento/main/".$d['id_atencion']);
	}
///////////////////////////////////////////////////////////////////
	function cups_urgencias($id_tipo)
	{
		$cupsUrg = $this->urgencias_model -> obtenerCupsUrg($id_tipo);
		
		$cadena = '';
		$cadena .='<select name="id_subcategoriaUrg" id="id_subcategoriaUrg">';
		$cadena .='<option value="0" selected="selected">-Seleccione uno-</option>';
		foreach($cupsUrg as $d)
		{
			$cadena .='<option value="'.$d['id_subcategoria'].'">'.$d['descripcion'].'</option>';
		}
		$cadena .='</select>';
		
		echo $cadena;
	}
///////////////////////////////////////////////////////////////////
	function agregarProcedimientoUrg()
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['cups'] = $this->input->post('id_subcategoriaUrg');
		$d['observacionesCups'] =  mb_strtoupper($this->input->post('observacionesCups'),'utf-8');
		
		$d['cantidadCups'] = '1';
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		
		echo $this->load->view('urg/urg_ordInfoProcedimiento',$d);
	}
///////////////////////////////////////////////////////////////////
	function crearOrdenBase($id_atencion,$id_orden)
	{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['orden'] = $this->urgencias_model->obtenerOrdenRepetir($id_orden);
		$d['urlRegresar'] 	= site_url('urg/ordenamiento/main/'.$id_atencion);
		$d['atencion'] = $this -> urgencias_model -> obtenerAtencion($id_atencion);
		$d['paciente'] = $this -> paciente_model -> obtenerPacienteConsulta($d['atencion']['id_paciente']);
		$d['tercero'] = $this -> paciente_model -> obtenerTercero($d['paciente']['id_tercero']);
		$d['id_medico'] = $this -> urgencias_model -> obtenerIdMedico($this->session->userdata('id_usuario'));
		$d['medico'] = $this -> urgencias_model -> obtenerMedico($d['id_medico']);
		$d['med']['vias'] = $this -> urgencias_model -> obtenerVarMedi('vias');
		$d['med']['unidades'] = $this -> urgencias_model -> obtenerVarMedi('unidades');
		$d['med']['frecuencia'] = $this -> urgencias_model -> obtenerVarMedi('frecuencia');
		//---------------------------------------------------------------
		$d['cuidados'] = $this -> urgencias_model -> obtenerCuidadosE();
		$d['dietas'] = $this -> urgencias_model -> obtenerDietas();
		$d['o2'] = $this -> urgencias_model -> obtenerOxigeno();
		if($d['atencion']['id_servicio'] == 14){
		$d['tipo_cups'] = $this -> urgencias_model -> obtenerTiposCupsUrgGine();
		}else{
		$d['tipo_cups'] = $this -> urgencias_model -> obtenerTiposCupsUrg(); 
		}
		//---------------------------------------------------------------
		$this->load->view('core/core_inicio');
		$d['id_oxigeno_valor'] = $this -> urgencias_model -> obtenerTipoOxigeno($d['orden']['id_tipo_oxigeno']);
		$d['ordenDietas'] = $this -> urgencias_model -> obtenerDietasOrden($d['orden']['id_orden']);
		$d['ordenCuid'] = $this -> urgencias_model -> obtenerCuidadosOrden($d['orden']['id_orden']);
		$d['ordenMedi'] = $this -> urgencias_model -> obtenerMediOrden($d['orden']['id_orden']);
		$d['ordenCups'] = $this -> urgencias_model -> obtenerCupsOrden($d['orden']['id_orden']);
		$d['ordenCupsLaboratorios'] = $this -> urgencias_model -> obtenerCupsLaboratorios($d['orden']['id_orden']);
		$d['ordenCupsImagenes'] = $this -> urgencias_model -> obtenerCupsImagenes($d['orden']['id_orden']);
		$this -> load -> view('urg/urg_ordCrearEdit', $d);
		//---------------------------------------------------------------
		$this->load->view('core/core_fin');	
		//---------------------------------------------------------------
	}

///////////////////////////////////////////////////////////////////
function consultaMedicaModi($id,$id_orden,$marca)
{
		//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['marca'] = $marca;
		$d['medicamento'] = $this->urgencias_model->obtenerMediOrdenModiId($id_orden,$id);
		$d['nomMedi'] = $this->urgencias_model->obtenerNomMedicamento($d['medicamento']['atc']);
		$d['vias'] = $this -> urgencias_model -> obtenerVarMedi('vias');
    	$d['unidades'] = $this -> urgencias_model -> obtenerVarMedi('unidades');
    	$d['frecuencia'] = $this -> urgencias_model -> obtenerVarMedi('frecuencia');
		echo $this->load->view('urg/urg_ordAgreMedicamentoModi',$d);
}
///////////////////////////////////////////////////////////////////
/*
* Agrega al listado los medicamentos que son modificados
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110610
* @version		20110610
* @return		HTML
*/
function agregarMedicamentoModi()
{
	//---------------------------------------------------------------
		$d = array();
		//---------------------------------------------------------------
		$d['pos'] = $this->input->post('pos');
		$d['atc'] = $this->input->post('atcModi');
		$d['dosis'] = $this->input->post('dosisModi');
		$d['id_unidad'] = $this->input->post('id_unidadModi');
		$d['frecuencia'] = $this->input->post('frecuenciaModi');
		$d['id_frecuencia'] = $this->input->post('id_frecuenciaModi');
		$d['id_via'] = $this->input->post('id_viaModi');
		$d['observacionesMed'] = mb_strtoupper($this->input->post('observacionesMedModi'),'utf-8');
		$d['via'] = $this->urgencias_model->obtenerValorVarMedi($d['id_via']);
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia']);
		$d['unidad'] = $this->urgencias_model->obtenerValorVarMedi($d['id_unidad']);
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc']);
		$pos = $this->urgencias_model->obtenerMedicamentoPos($d['atc']);
		$d['pos'] = $pos['pos'];
		$d['bandera'] = 'Modificado';
		echo $this->load->view('urg/urg_ordInfoMedicamento',$d);
}
///////////////////////////////////////////////////////////////////
}
?>
