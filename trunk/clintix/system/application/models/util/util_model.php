<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Urgencias_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades del modulo de Urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 26 de agosto de 2010
*/
class Util_model extends Model 
{
///////////////////////////////////////////////////////////////////////
function __construct()
{        
	parent::Model();
	
	$this->load->database();
}
///////////////////////////////////////////////////////////////////////
function obtenerDxCon($id_dx)
{
	$this->db->where('id_diag',$id_dx);
	$result = $this->db->get('core_diag_item');
	$diag = $result->row_array();
	$cadena = "<strong>".$diag['id_diag']."</strong>"." ".$diag['diagnostico'];
	return $cadena;
}
///////////////////////////////////////////////////////////////////////
function obtenerDxCap()
{
	$result = $this->db->get('core_diag_capitulo');
	return $result->result_array();
}
///////////////////////////////////////////////////////////////////////	
function obtenerDxNivel1($cap)
{
	$this -> db -> where('id_capitulo',$cap);
	$result = $this->db->get('core_diag_nivel1');
	return $result->result_array();
}
///////////////////////////////////////////////////////////////////////	
function obtenerDxNivel2($nivel1)
{
	$this -> db -> where('id_nivel1',$nivel1);
	$result = $this->db->get('core_diag_nivel2');
	return $result->result_array();
}
///////////////////////////////////////////////////////////////////////
function obtenerDx($nivel2)
{
	$this -> db -> where('id_nivel2',$nivel2);
	$result = $this->db->get('core_diag_item');
	return $result->result_array();
}
///////////////////////////////////////////////////////////////////////	
function obtenerDietas()
{
	$this->db->order_by('dieta','ASC');
	$result = $this->db->get('core_dietas');
	return $result->result_array();
}
///////////////////////////////////////////////////////////////////////
function obtenerTipoOxigeno($id_o2)
{
	$this->db->where('id_oxigeno',$id_o2);
	$result = $this->db->get('core_oxigeno_tipo');
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
	return $result->result_array();
	}
}
///////////////////////////////////////////////////////////////////////
function obtenerDieta($id_dieta)
{
	$this->db->where('id_dieta',$id_dieta);
	$result = $this->db->get('core_dietas');
	$cad = $result->row_array();
	return $cad['dieta'];
}
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
}