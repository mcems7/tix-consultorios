<?php
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Admin_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades del modulo de gestión administrativa de pacientes
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 20 de agosto de 2011
*/
class Admin_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
		
		$this->load->database();
    }
///////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene las camas ocupadas por servicio
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110820
* @version		20110820
* @return		array[object]
*/
function obtenerCamasServicio($id_servicio)
{	
	$this->db->SELECT('core_cama.id_cama,
	core_cama.id_servicio,
	core_cama.id_estado,
	core_cama.numero_cama,
	core_estados_camas.estado,
	core_estados_camas.icono');
	$this->db->FROM('core_cama');
	$this->db->JOIN('core_estados_camas','core_cama.id_estado = core_estados_camas.id_estado');
	$this->db->where('core_cama.id_estado','2');
	$this->db->where('core_cama.id_servicio',$id_servicio);
	$this->db->order_by('core_cama.id_cama','ASC');
	$result =	 $this->db->get();
	return $result->result_array();
}
///////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene el paciente de una cama
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110820
* @version		20110820
* @return		array[object]
*/
function obtenerAtencionCama($id_cama)
{
	$this->db->select('
	core_tercero.primer_apellido,
	core_tercero.segundo_apellido,
	core_tercero.primer_nombre,
	core_tercero.segundo_nombre,
	core_tercero.fecha_nacimiento,
	urg_observacion.id_atencion,
	core_tercero1.razon_social,
	urg_observacion.estado,
	urg_observacion.id_cama,
	core_tipo_documentos.tipo_documento');
	$this->db->from('urg_observacion');
	$this->db->JOIN('urg_atencion','urg_observacion.id_atencion = urg_atencion.id_atencion');
	$this->db->JOIN('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
	$this->db->JOIN('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->JOIN('core_eapb','core_paciente.id_entidad = core_eapb.id_entidad');
	$this->db->JOIN('core_tercero core_tercero1','core_eapb.id_tercero = core_tercero1.id_tercero');
	$this->db->JOIN('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
	$this->db->where('urg_observacion.estado','activo');
	$this->db->where('urg_observacion.id_cama',$id_cama);
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
		return $num;
	}else{
	return $result->row_array();
	}	
}
///////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene el funcionario que realiza la nota de trabajo social
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110820
* @version		20110820
* @return		array[object]
*/
function obtenerFuncionario($id_usuario)
{
	$this->db->from('core_tercero');
	$this->db->join('core_usuario','core_tercero.numero_documento = core_usuario.numero_documento');
	$this->db->join('core_funcionario','core_funcionario.id_tercero = core_tercero.id_tercero');
	$this->db->where('core_usuario.id_usuario',$id_usuario);
	$result = $this ->db->get();
	$num = $result -> num_rows();
	if($num == 0){
	return $num;}
	return $result -> row_array();
}
///////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene las nota de trabajo social de una atencion indicada
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110820
* @version		20110820
* @return		array[object]
*/
function obtenerNotasAtencion($id_atencion)
{
	$this->db->select('
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  admin_trabajo_social.titulo_nota,
  admin_trabajo_social.fecha_nota,
  admin_trabajo_social.id_nota');
	$this->db->from('admin_trabajo_social');
	$this->db->join('core_funcionario','admin_trabajo_social.id_funcionario = core_funcionario.id_funcionario');
	$this->db->join('core_tercero','core_funcionario.id_tercero = core_tercero.id_tercero');
	$this->db->where('admin_trabajo_social.id_atencion',$id_atencion);
	$result = $this ->db->get();
	$num = $result -> num_rows();
	if($num == 0){
	return $num;}
	return $result -> result_array();
	
}
///////////////////////////////////////////////////////////////////////////////////
/*
* Obtiene la nota de trabajo social que fue especificada
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110820
* @version		20110820
* @return		array[object]
*/
function obtenerNotaTrabajoSocial($id_nota)
	{
		$this->db->select('
  core_tercero.primer_apellido,
  core_tercero.segundo_apellido,
  core_tercero.primer_nombre,
  core_tercero.segundo_nombre,
  admin_trabajo_social.id_funcionario,
  admin_trabajo_social.id_nota,
  admin_trabajo_social.titulo_nota,
  admin_trabajo_social.nota,
  admin_trabajo_social.fecha_nota,
  admin_trabajo_social.id_atencion');
	$this->db->from('admin_trabajo_social');
	$this->db->join('core_funcionario','admin_trabajo_social.id_funcionario = core_funcionario.id_funcionario');
	$this->db->join('core_tercero','core_funcionario.id_tercero = core_tercero.id_tercero');
	$this->db->where('id_nota',$id_nota);
	$result = $this->db->get();
	return $result->row_array();
}
///////////////////////////////////////////////////////////////////////////////////
/*
* Almacena una nota de trabajo social
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20110821
* @version		20110821
* @return		integer
*/
function crearNotaDb($d)
{
	$insert = array(
		'titulo_nota'	=> $d['titulo_nota'],
		'nota' 			=> $d['nota'],
		'fecha_nota' 	=> date('Y-m-d H:i:s'),
		'id_usuario'	=> $this -> session -> userdata('id_usuario'),
		'id_funcionario'=> $d['id_funcionario'],
		'id_atencion' 	=> $d['id_atencion']);
	$this->db->insert('admin_trabajo_social',$insert);
	return $this->db->insert_id();	
}
///////////////////////////////////////////////////////////////////////////////////
}