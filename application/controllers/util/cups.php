<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Cups
 *Tipo: controlador
 *Descripcion: Utilidades para cups
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 11 de marzo de 2012
*/
class Cups extends CI_Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::__construct();			
		$this->load->model('util/util_model');	
		$this->load->model('urg/urgencias_model');	
	}
///////////////////////////////////////////////////////////////////
/*
* Cups comunes urgencias
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120311
* @version		20120311
* @return		HTML
*/	
function cups_urgencias($id_tipo)
{
	$cupsUrg = $this->urgencias_model->obtenerCupsUrg($id_tipo);
	
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
/*
* Agrega un cups
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120311
* @version		20120311
* @return		HTML
*/	
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
* Agrega un cups de combo urgencias
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120311
* @version		20120311
* @return		HTML
*/	
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
/*
* Vista para agregar cups avanzados
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120311
* @version		20120311
* @return		HTML
*/
function cupsAvanzados()
{
	$d['secciones'] = $this->urgencias_model->obtenerCupsSec();	
	echo $this->load->view('util/util_cups_avanzado',$d);
}
///////////////////////////////////////////////////////////////////
function cupsCaps($sec)
{
	$capitulos = $this->urgencias_model->obtenerCupsCap($sec);
	
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
function cupsSimple()
{
	echo $this->load->view('util/util_cups_simple');
}
///////////////////////////////////////////////////////////////////	
function cupsGrupos($cap)
{
	$grupos = $this->urgencias_model->obtenerCupsGrup($cap);
	
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
	$subGrupos = $this->urgencias_model->obtenerCupsSubGrup($gru);
	
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
	$categorias = $this->urgencias_model->obtenerCupsCategorias($sgru);
	
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
	$subCate = $this->urgencias_model->obtenerCupsSubCate($cate);
	
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
function cupscompletar($l)
{
	$l = preg_replace("/[^a-z0-9 ]/si","",$l);
	$this->load->database();
	$this->db->like('desc_subcategoria',$l);
	$r = $this->db->get('core_cups_subcategoria');
	$dat = $r->result_array();
	foreach($dat as $d)
	{
		echo $d["id_subcategoria"]."###".$d["desc_subcategoria"]."|";
	}
}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>