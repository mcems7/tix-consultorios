<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Impresion_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos para la gestión de la impresión de documentos
 *Autor: Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
 *Fecha de creación: 24 de febrero de 2011
*/

class Impresion_model extends Model 
{
    function __construct()
    {        
        parent::Model();

				$this->load->database();
    }

///////////////////////////////////////////////////////////////////
/*
* Buscar las atenciones de un paciente en el área de urgencias que corresponden con los parámetros dados
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110224
* @version 20110224
* @return  vector
* @access  public 
*/  
///////////////////////////////////////////////////////////////////

	function verificarAtencionUrg($datos)
	{
		$this->db->select('*');
		$this->db->from('core_tercero');
		$this->db->join('core_paciente','core_tercero.id_tercero = core_paciente.id_tercero');
		$this->db->join('core_tipo_documentos','core_tercero.id_tipo_documento = 
		core_tipo_documentos.id_tipo_documento');
  	$this->db->join('urg_atencion','core_paciente.id_paciente = urg_atencion.id_paciente');
		$this->db->join('core_servicios_hosp','urg_atencion.id_servicio = 
		core_servicios_hosp.id_servicio');
		//$this->db->where_not_in('urg_atencion.id_estado',array('1','7','8','9'));

		if(!empty($datos['numero_documento']))
			$this->db->where('core_tercero.numero_documento',$datos['numero_documento']);
		if(!empty($datos['nombre1']))
			$this->db->like('core_tercero.primer_nombre',$datos['nombre1']);
		if(!empty($datos['nombre2']))
			$this->db->like('core_tercero.segundo_nombre',$datos['nombre2']);
		if(!empty($datos['apellido1']))
			$this->db->like('core_tercero.primer_apellido',$datos['apellido1']);
		if(!empty($datos['apellido2']))
			$this->db->like('core_tercero.segundo_apellido',$datos['apellido2']);

		$result = $this->db->get();

		if($result -> num_rows() == 0)
			return null;

		return $result -> result_array();
	}
	
///////////////////////////////////////////////////////////////////
/*
* Buscar las atenciones de un paciente en el área de hospitalización que corresponden con los parámetros dados
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110224
* @version 20110224
* @return  vector
* @access  public 
*/  
/////////////////////////////////////////////////////////////////// 

	function verificarAtencionHosp($datos)
	{
		$this->db->select('*');
		$this->db->from('core_tercero');
		$this->db->join('core_paciente','core_tercero.id_tercero = core_paciente.id_tercero');
  	$this->db->join('hosp_atencion','core_paciente.id_paciente = hosp_atencion.id_paciente');
		$this->db->join('core_servicios_hosp','hosp_atencion.id_servicio = 
		core_servicios_hosp.id_servicio');	
		$this->db->where('hosp_atencion.id_estado','1');
		if(!empty($datos['numero_documento']))
			$this->db->where('core_tercero.numero_documento',$datos['numero_documento']);
		if(!empty($datos['nombre1']))
			$this->db->like('core_tercero.primer_nombre',$datos['nombre1']);
		if(!empty($datos['nombre2']))
			$this->db->like('core_tercero.segundo_nombre',$datos['nombre2']);
		if(!empty($datos['apellido1']))
			$this->db->like('core_tercero.primer_apellido',$datos['apellido1']);
		if(!empty($datos['apellido2']))
			$this->db->like('core_tercero.segundo_apellido',$datos['apellido2']);

		$result = $this->db->get();

		if($result -> num_rows() == 0)
			return null;

		return $result -> result_array();
	}
	
///////////////////////////////////////////////////////////////////
/*
* Obtiene las órdenes médicas de una atención
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110225
* @version 20110225
* @return  vector
* @access  public 
*/  
///////////////////////////////////////////////////////////////////
	
	function obtenerOrdenes($id_atencion)
	{
		$this->db->select('core_tipo_medico.descripcion As tipo,
		core_especialidad.descripcion As esp,
		core_tercero.primer_apellido,
		core_tercero.segundo_apellido,
		core_tercero.primer_nombre,
		core_tercero.segundo_nombre,
		urg_ordenamiento.id_orden,
		urg_ordenamiento.id_servicio,
		urg_ordenamiento.fecha_creacion,
		urg_ordenamiento.id_atencion,
		urg_ordenamiento.verificado,
		urg_ordenamiento.id_medico,
		urg_ordenamiento.insumos');
		$this->db->from('core_medico');
		$this->db->join('urg_ordenamiento','core_medico.id_medico = urg_ordenamiento.id_medico');
		$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
		$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
		$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
		$this->db->where('urg_ordenamiento.id_atencion',$id_atencion);
		$this->db->order_by('urg_ordenamiento.fecha_creacion','DESC');
		$result = $this->db->get();
		$num = $result->num_rows();

		if($num == 0)
		{
			return $num;
		}
		else
		{
			return $result->result_array();
		}
	}

///////////////////////////////////////////////////////////////////
/*
* Obtiene las evoluciones de una atención
*
* @author  Mario Alberto Martínez Martínez <mmartinez@opuslibertati.org>
* @site    http://www.opuslibertati.org
* @since   20110224
* @version 20110224
* @return  vector
* @access  public 
*/  
///////////////////////////////////////////////////////////////////

	function obtenerEvoluciones($id_atencion)
	{
		$this->db->select('core_especialidad.descripcion As esp,
		core_medico.id_medico,
		core_tercero.primer_apellido,
		core_tercero.segundo_apellido,
		core_tercero.primer_nombre,
		core_tercero.segundo_nombre,
		urg_evoluciones.id_evolucion,
		urg_evoluciones.verificado,
		urg_evoluciones.fecha_evolucion,
		urg_evoluciones.id_atencion,
		urg_evoluciones.verificado,
		core_evoluciones_tipo.tipo_evolucion');
		$this->db->from('core_medico');
		$this->db->join('urg_evoluciones','core_medico.id_medico = urg_evoluciones.id_medico');
		$this->db->join('core_evoluciones_tipo','urg_evoluciones.id_tipo_evolucion = core_evoluciones_tipo.id_tipo_evolucion');
		$this->db->join('core_especialidad','core_medico.id_especialidad = core_especialidad.id_especialidad');
		$this->db->join('core_tipo_medico','core_medico.id_tipo_medico = core_tipo_medico.id_tipo_medico');
		$this->db->join('core_tercero','core_medico.id_tercero = core_tercero.id_tercero');
		$this->db->where('id_atencion',$id_atencion);
		$this->db->order_by('fecha_evolucion','DESC');
		$result = $this->db->get();
		$num = $result->num_rows();

		if($num == 0)
		{
			return $num;
		}
		else
		{
			return $result->result_array();
		}
	}
	
	//////////////////////////////////////////
	function ConsultaSv($id_atencion)
	
			{
	$this->db->from('urg_signos_enfermeria');
	
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