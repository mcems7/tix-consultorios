<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hospi_insumos_model
 *Tipo: modelo
 *Descripcion: Gestion de insumos a ordenes medicas hospitalizacion
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 11 de marzo de 2012
*/
class Hospi_insumos_model extends Model 
{
/////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
		$this->load->database();
    }
/////////////////////////////////////////////////////////////////
function obtenerOrdenesServicio($id_servicio)
{
	$this->db->select('core_tercero.primer_apellido As pa_pac,
	core_tercero.segundo_apellido As sa_pac,
	core_tercero.primer_nombre As pn_pac,
	core_tercero.segundo_nombre As sn_pac,
	core_tercero1.primer_apellido,
	core_tercero1.segundo_apellido,
	core_tercero1.primer_nombre,
	core_tercero1.segundo_nombre,
	hospi_ordenamiento.id_orden,
	hospi_ordenamiento.id_servicio,
	hospi_ordenamiento.fecha_creacion,
	hospi_ordenamiento.id_atencion,
	hospi_ordenamiento.id_medico,
	hospi_ordenamiento.insumos,
	core_cama.numero_cama');
	$this->db->from('hospi_ordenamiento');
	$this->db->join('hospi_atencion','hospi_ordenamiento.id_atencion = hospi_atencion.id_atencion');
	$this->db->join('core_paciente','hospi_atencion.id_paciente = core_paciente.id_paciente');
	$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
	$this->db->join('core_medico','hospi_ordenamiento.id_medico = core_medico.id_medico');
	$this->db->join('core_tercero core_tercero1','core_medico.id_tercero = core_tercero1.id_tercero');
	$this->db->join('core_cama','hospi_atencion.id_cama = core_cama.id_cama');
	$this->db->where('hospi_ordenamiento.insumos','NO');
	$this->db->where('hospi_ordenamiento.id_servicio',$id_servicio);
	$this->db->order_by('hospi_ordenamiento.fecha_creacion','DESC');
	$result = $this->db->get();
	$num = $result->num_rows();
	if($num == 0){
	return $num;
	}else{
	return $result->result_array();
	}
}
/////////////////////////////////////////////////////////////////
function asignarPagadorCups($tipo,$id,$pagador)
{
	if($tipo == 'lab'){
		$update = array('pagador' => $pagador);
		$this->db->where('id',$id);
		$res = $this->db->update('hospi_orde_laboratorios',$update);
	}else if($tipo == 'img'){
		$update = array('pagador' => $pagador);
		$this->db->where('id',$id);
		$res = $this->db->update('hospi_orde_imagenes',$update);
	}else if($tipo == 'otro'){
		$update = array('pagador' => $pagador);
		$this->db->where('id',$id);
		$res = $this->db->update('hospi_orde_cups',$update);
	}
	
	return $res;
}
/////////////////////////////////////////////////////////////////
}


