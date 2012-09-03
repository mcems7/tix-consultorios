<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Insumos_model
 *Tipo: modelo
 *Descripcion: Gestión Urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 26 de agosto de 2010
*/
class Insumos_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
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
		  urg_ordenamiento.id_orden,
		  urg_ordenamiento.id_servicio,
		  urg_ordenamiento.fecha_creacion,
		  urg_ordenamiento.id_atencion,
		  urg_ordenamiento.verificado,
		  urg_ordenamiento.id_medico,
		  urg_ordenamiento.insumos,
		  core_cama.numero_cama');
$this->db->from('urg_ordenamiento');
$this->db->join('urg_atencion','urg_ordenamiento.id_atencion = urg_atencion.id_atencion');
$this->db->join('core_paciente','urg_atencion.id_paciente = core_paciente.id_paciente');
$this->db->join('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
$this->db->join('core_medico','urg_ordenamiento.id_medico = core_medico.id_medico');
$this->db->join('core_tercero core_tercero1','core_medico.id_tercero = core_tercero1.id_tercero');
$this->db->join('urg_observacion','urg_atencion.id_atencion = urg_observacion.id_atencion','left');
$this->db->join('core_cama','urg_observacion.id_cama = core_cama.id_cama','left');
$this->db->where('urg_atencion.activo','SI');
$this->db->where('urg_ordenamiento.verificado','SI');
$this->db->where('urg_ordenamiento.insumos','NO');
$this->db->where('urg_ordenamiento.id_servicio',$id_servicio);
$this->db->order_by('urg_ordenamiento.fecha_creacion','DESC');
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}



	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}


