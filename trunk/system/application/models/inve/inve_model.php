<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Inve_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades del modulo de Inventarios
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 02 de abril de 2012
*/
class Inve_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct()
{        
	parent::Model();	
	$this->load->database();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerNumListaProductos()
{
	return $this->db->count_all('inve_productos');			
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerListaProductos($number_items,$offset)
{
	$this->db->limit($number_items,$offset);
	$result = $this->db->get('inve_productos');
	return $result->result_array();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerNumListaProductosCon($d)
{
	if(strlen($d['descripcion']) > 0){$this->db->like('descripcion',$d['descripcion']);}
	
	if(strlen($d['tipo_producto']) > 0){
		if($d['tipo_producto'] == 'Medicamento'){
			if(strlen($d['principio_activo']) > 0){$this->db->like('principio_activo',$d['principio_activo']);}
			if(strlen($d['atc']) > 0){$this->db->like('atc',$d['atc']);}
			if(strlen($d['cum']) > 0){$this->db->like('cum',$d['cum']);}
		}
	}

	$result = $this->db->get('inve_productos');
	$n = $result -> num_rows();
	return $n;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerListaProductosCon($d,$number_items,$offset)
{
	if($d['tipo_producto'] == 'Medicamento'){
		if(strlen($d['descripcion']) > 0){
			$this->db->like('descripcion',$d['descripcion']);
			$this->db->or_like('principio_activo',$d['descripcion']);
		}
		
		if(strlen($d['principio_activo']) > 0){$this->db->like('principio_activo',$d['principio_activo']);}
		
		if(strlen($d['atc']) > 0){$this->db->like('atc',$d['atc']);}
		
		if(strlen($d['cum']) > 0){$this->db->like('cum',$d['cum']);}
		
	}else{
		if(strlen($d['descripcion']) > 0){$this->db->like('descripcion',$d['descripcion']);}
	}
	
	$this->db->limit($number_items,$offset);
	$result = $this->db->get('inve_productos');
	return $result->result_array();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerPrincipioActivoLista()
{
	$this->db->order_by('principio_activo','ASC');
	$res = $this->db->get('inve_med_principio_activo ');
	return $res->result_array();	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function crearProducto_($d)
{
	$insert = array(
		'producto' => $d['producto'],
		'marca' => $d['marca'],
		'tipo_producto' => $d['tipo_producto'],
		'descripcion' => $d['descripcion'],
		'estado' => $d['estado'],
		'principio_activo' => $d['principio_activo'],
		'cum' => $d['cum'],
		'atc' => $d['atc'],
		'invima' => $d['invima'],
		'pos' => $d['pos'],
		'fecha_creacion' => date('Y-m-d H:i:s'),
		'fecha_modificacion' => date('Y-m-d H:i:s')
	);
	$this->db->insert('inve_productos',$insert);	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function obtenerProducto($id_producto)
{
	$this->db->where('id_producto',$id_producto);
	$res = $this->db->get('inve_productos');
	return $res->row_array();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function editarProducto_($d)
{
	$update = array(
		'producto' => $d['producto'],
		'marca' => $d['marca'],
		'descripcion' => $d['descripcion'],
		'estado' => $d['estado'],
		'principio_activo' => $d['principio_activo'],
		'cum' => $d['cum'],
		'atc' => $d['atc'],
		'invima' => $d['invima'],
		'pos' => $d['pos'],
		'fecha_modificacion' => date('Y-m-d H:i:s')
	);
	$this->db->where('id_producto',$d['id_producto']);
	$this->db->update('inve_productos',$update);	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}