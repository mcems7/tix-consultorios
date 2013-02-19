<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Hospi_Impresion_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos para la gestión de la impresión de documentos
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 11 de marzo de 2012
*/

class Hospi_impresion_model extends Model 
{
    function __construct()
    {        
        parent::Model();

				$this->load->database();
    }


	function obtenerEmpresa()
	{
		$this->db->select('core_empresa.razon_social,
		core_empresa.nit,
		core_empresa.direccion,
		core_empresa.indicativo,
		core_empresa.telefono1,
		core_empresa.logo,
		core_empresa.fax,
		core_empresa.correo,
		core_departamento.nombre departamento,
		core_municipio.nombre municipio,
		
');
		$this->db->from('core_empresa');
		$this->db->join('core_departamento','core_departamento.id_departamento = core_empresa.id_departamento');
		$this->db->join('core_municipio','core_municipio.id_municipio = core_empresa.id_municipio');
		$this->db->where('id_empresa',1);
		$result = $this->db->get();
		return $result->row_array();
	}

	//////////////////////////////////////////
	function ConsultaSv($id_atencion)
	
			{
	$this->db->from('hospi_signos_enfermeria');
	
	$this->db->where('id_atencion',$id_atencion);
	
	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}

}
?>