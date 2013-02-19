<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Ordenes
 *Tipo: controlador
 *Descripcion: Utilidades para ordenes medicas
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 11 de marzo de 2012
*/
class Ordenes extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this->load->model('util/util_model');	
		$this->load->model('hospi/hospi_model');	
		$this->load->model('urg/urgencias_model');	
	}
///////////////////////////////////////////////////////////////////
/*
* Agrega las dietas
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20101019
* @version		20101019
* @return		HTML
*/	
function agregarDieta()
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['id_dieta'] = $this->input->post('id_dieta_');
	$d['dieta'] = $this->util_model->obtenerDieta($d['id_dieta']);
	echo $this->load->view('util/util_orden_info_dieta',$d);
}
///////////////////////////////////////////////////////////////////
/*
* Agrega tipo de oxigeno
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20101019
* @version		20101019
* @return		HTML
*/	
function tipoOxigeno()
{
	$id_o2 = $this->input->post('id_oxigeno');
	$tipos = $this->util_model->obtenerTipoOxigeno($id_o2);
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
function medicamentos($l)
{
	$l = preg_replace("/[^a-z0-9 ]/si","",$l);
	$this->load->database();
	$this->db->like('principio_activo',$l);
	$r = $this->db->get('core_medicamento');
	$dat = $r->result_array();
	foreach($dat as $d)
	{
		echo $d["atc_full"]."###".$d["principio_activo"]." ".$d["descripcion"]."|";
	}
}
///////////////////////////////////////////////////////////////////
function consultaMedicaModi($id,$id_orden,$marca)
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['marca'] = $marca;
	$d['medicamento'] = $this->hospi_model->obtenerMediOrdenModiId($id_orden,$id);
	$d['nomMedi'] = $this->urgencias_model->obtenerNomMedicamento($d['medicamento']['atc']);
	$d['vias'] = $this->urgencias_model->obtenerVarMedi('vias');
	$d['unidades'] = $this->urgencias_model->obtenerVarMedi('unidades');
	$d['frecuencia'] = $this->urgencias_model->obtenerVarMedi('frecuencia');
	echo $this->load->view('urg/urg_ordAgreMedicamentoModi',$d);
}
///////////////////////////////////////////////////////////////////
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
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>