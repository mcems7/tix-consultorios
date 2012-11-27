<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Diagnosticos
 *Tipo: controlador
 *Descripcion: Permite gestionar los diagnosticos desde cualquier parte d ela aplicacion
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 09 de marzo de 2012
*/
class Diagnosticos extends Controller
{
///////////////////////////////////////////////////////////////////
	function __construct()
	{
		parent::Controller();			
		$this->load->model('util/util_model');	
	}
///////////////////////////////////////////////////////////////////
/*
* Agrega los diagnosticos al listado de la consulta
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20101019
* @version		20101019
* @return		HTML
*/	
function agregar_dx()
{
	//---------------------------------------------------------------
	$d = array();
	//---------------------------------------------------------------
	$d['dx_ID'] = $this->input->post('dx_ID');
	$d['tipo_dx'] = $this->input->post('tipo_dx');
	$d['dx'] = $this->util_model->obtenerDxCon($d['dx_ID']);
	echo $this->load->view('util/util_dxInfo',$d);
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
function completarDx($l)
{
	$l = preg_replace("/[^a-z0-9 ]/si","",$l);
	$this->load->database();
	$this->db->like('diagnostico',$l);
	$this->db->or_like('id_diag',$l);
	$r = $this->db->get('core_diag_item');
	$dat = $r -> result_array();
	foreach($dat as $d)
	{
		echo $d["id_diag"]."###<strong>".$d["id_diag"]."</strong> ".$d["diagnostico"]."|";
	}
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
	function dxSimple()
	{
		echo $this->load->view('util/util_dx_Simple');
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
	function dxAvanzados()
	{
		$d['capitulos'] = $this -> util_model -> obtenerDxCap();		
		echo $this->load->view('util/util_dx_Avanzado',$d);
	}
///////////////////////////////////////////////////////////////////
/*
* Organiza el select con la lista de capitulos de diagnosticos CIE10 
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100906
* @version		20100906
* @return		HTML
*/	
	function dxCaps($cap)
	{
		$nivel1 = $this ->util_model->obtenerDxNivel1($cap);
		
		$cadena ='';
		$cadena .= '<select name="nivel1" id="nivel1" onChange="nivel1Dx()">';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($nivel1 as $d)
			{
				$cadena .='<option value="'.$d['id_nivel1'].'">'.$d['desc_nivel1'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;		
	}
///////////////////////////////////////////////////////////////////
/*
* Organiza el select con la lista de subgrupos de diagnosticos  CIE10
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100906
* @version		20100906
* @return		HTML
*/
	function dxNivel1($nivel1)
	{
		$nivel2 = $this->util_model->obtenerDxNivel2($nivel1);
		
		$cadena ='';
		$cadena .= '<select name="nivel2" id="nivel2" onChange="nivel2Dx()">';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($nivel2 as $d)
			{
				$cadena .='<option value="'.$d['id_nivel2'].'">'.$d['desc_nivel2'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;
	}
///////////////////////////////////////////////////////////////////	
/*
* Organiza el select con la lista de diagnosticos CIE10
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20100906
* @version		20100906
* @return		HTML
*/
	function dxNivel2($nivel2)
	{
		$diag = $this->util_model->obtenerDx($nivel2);
		
		$cadena ='';
		$cadena .= '<select id="dx_hidden" name="dx_ID"';
		$cadena .= '<option value="0">-Seleccione-</option>';
		
			foreach($diag as $d)
			{
				$cadena .='<option value="'.$d['id_diag'].'"><strong>'.$d['id_diag']."</strong>&nbsp;".$d['diagnostico'].'</option>';
			}
		
		$cadena .= '</select>';
		echo  $cadena;
	}
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
}
?>