<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: Lab_ordenes
 *Tipo: modelo
 *Descripcion: Brinda acceso a las ordenes de laboratorio
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 24 de Octubre de 2011
*/
class Lab_ordenes extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
    
    $this->load->database();
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////

  function obtenerNombreEntidad($id_paciente)
  {
    $this->db->select('core_paciente.id_entidad, core_eapb.id_tercero, core_tercero.razon_social');
    $this->db->from('core_paciente');
    $this->db->join('core_eapb','core_paciente.id_entidad = core_eapb.id_entidad');
    $this->db->join('core_tercero','core_tercero.id_tercero = core_eapb.id_tercero');
    $this->db->where('core_paciente.id_paciente',$id_paciente);
    $result = $this->db->get();
    return $result->row_array();
     
  }

function obtenerOrdenes($id_paciente)
	{
		$this->db->select('core_cups_subcategoria.desc_subcategoria As cups,
		lab_ordenes.fecha_realizado,
		lab_ordenes.id_ordenes,
		lab_ordenes.verificado,
		lab_ordenes.id_paciente');
$this->db->from('lab_ordenes');
$this->db->join('core_cups_subcategoria','core_cups_subcategoria.id_subcategoria = lab_ordenes.cups');

$this->db->where('lab_ordenes.id_paciente',$id_paciente);
$this->db->order_by('lab_ordenes.fecha_realizado','DESC');
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}


////////////////////FIN//////////////////////////
}
?>