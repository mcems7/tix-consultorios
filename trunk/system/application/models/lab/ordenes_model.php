<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Laboratorio_model
 *Tipo: modelo
 *Descripcion: Brinda acceso a datos de las funcionalidades del modulo de laboratorio
 *Autor: Diego Ivan Carvajal Gil <dcarvajal@opuslibertati.org>
 *Fecha de creación: 24 de Octubre de 2011
*/
class Ordenes_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
    
    $this->load->database();
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////

 

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


function obtenerOrdenesInterpretar($id_ordenes)
	{
		$this->db->select('core_cups_subcategoria.desc_subcategoria As cups,
		lab_ordenes.fecha_realizado,
		lab_ordenes.id_ordenes,
		lab_ordenes.verificado,
		lab_resultados.registro_numero,
		lab_resultados.interpretada,
		lab_ordenes.id_paciente');
$this->db->from('lab_resultados');

$this->db->join('lab_ordenes','lab_resultados.id_orden = lab_ordenes.id_ordenes');
$this->db->join('core_cups_subcategoria','core_cups_subcategoria.id_subcategoria = lab_ordenes.cups');



$this->db->where('lab_resultados.id_orden',$id_ordenes);
   $this->db->group_by('lab_resultados.registro_numero');

	$result = $this->db->get();
	$num = $result->num_rows();
		if($num == 0){
			return $num;
		}else{
			return $result->result_array();
		}
	}	
	
	
	function OrdenInterpretar($id_ordenes,$registro_numero)
	{
		$this->db->select('	
		lab_resultados.registro_numero,
		lab_resultados.id_clinico,
		lab_resultados.numero,
		lab_resultados.texto,
		lab_resultados.lista,
		lab_resultados.id_orden,
		lab_clinicos.nombre As clinico,
		lab_clinicos.idpadre,
		lab_clinicos.valorminimonumerico,
		lab_clinicos.valormaximonumerico');
			$this->db->from('lab_resultados');
			$this->db->join('lab_clinicos','lab_resultados.id_clinico = lab_clinicos.id');

			$this->db->where('lab_resultados.id_orden',$id_ordenes);
			$this->db->where('lab_resultados.registro_numero',$registro_numero);
 

				$result = $this->db->get();
				$num = $result->num_rows();
				if($num == 0)
				{
				return $num;
				}else{
				return $result->result_array();
		}
	}	
	
	function OrdenInterpretada($id_ordenes,$registro_numero)
	{
		$this->db->select('	
		lab_ordenes_interpretadas.Interpretacion');
			$this->db->from('lab_ordenes_interpretadas');
			

			$this->db->where('lab_ordenes_interpretadas.id_orden',$id_ordenes);
			$this->db->where('lab_ordenes_interpretadas.registro_numero',$registro_numero);
 

				$result = $this->db->get();
				$num = $result->num_rows();
				if($num == 0)
				{
				return $num;
				}else{
				return $result->result_array();
				}
		
     }
	
	function RutaArchivo($id_ordenes,$registro_numero)
	{
		$this->db->select('	
		lab_resultados_detalle.ruta_archivos');
			$this->db->from('lab_resultados_detalle');
			

			$this->db->where('lab_resultados_detalle.id_orden',$id_ordenes);
			$this->db->where('lab_resultados_detalle.registro_numero',$registro_numero);
 

				$result = $this->db->get();
				$num = $result->num_rows();
				if($num == 0)
				{
				return $num;
				}else{
					$dato = $result->result_array();
				return $dato[0];
				
		}
	}	

	function obtenercontenedorpadre($id_ordenes,$registro_numero)
	{
			$this->db->select('	
		    lab_clinicos.idpadre As contenedor');
			$this->db->from('lab_resultados');
			$this->db->join('lab_clinicos','lab_resultados.id_clinico = lab_clinicos.id');

			$this->db->where('lab_resultados.id_orden',$id_ordenes);
			$this->db->where('lab_resultados.registro_numero',$registro_numero);
			$this->db->group_by('lab_clinicos.idpadre');
 

				$result = $this->db->get();
				$num = $result->num_rows();
				if($num == 0)
				{
				return $num;
				}else{
				return $result->result_array();
		
				}
	
	
	}
	
	
	
	
	function obtenernombrecont($contenedor)
	{
			$this->db->select('	
		    lab_clinicos.nombre,
			lab_clinicos.id');
			$this->db->from('lab_clinicos');

			$this->db->where('lab_clinicos.id',$contenedor);
			
			$this->db->group_by('lab_clinicos.id');
 

				$result = $this->db->get();
				$num = $result->num_rows();
				if($num == 0)
				{
				return $num;
				}else{
				$dato = $result->result_array();
				return $dato[0];
				}
	
	
	}
	
	function guardarInterpretacion($datos)
	{
		 $update = array(
		  'id_orden'=>$datos['id_orden'],
          'id_usuario' => $datos['id_usuario'],
          'registro_numero' => $datos['registro_numero'],
		  'interpretacion' => $datos['interpretacion'],
		 			     );
		    
	     
	   $this -> db -> insert('lab_ordenes_interpretadas',$update);
	 
		   $update2 = array(
		  'id_orden'=>$datos['id_orden'],
          'registro_numero' => $datos['registro_numero'],
		  'interpretada' => 'SI',  
		  
          					);

$this->db->where('id_orden', $datos['id_orden']);
$this->db->where('registro_numero', $datos['registro_numero']);
$this->db->update('lab_resultados', $update2); 

$this->db->where('id_orden', $datos['id_orden']);
$this->db->where('registro_numero', $datos['registro_numero']);
$this->db->update('lab_resultados_detalle', $update2); 

		
		
	}
	
	function obtenerordenlab($id_paciente)
	
	{

			$this->db->from('lab_ordenes');
			$this->db->join('lab_resultados_detalle','lab_resultados_detalle.id_orden = lab_ordenes.id_ordenes');
			$this->db->where('lab_ordenes.id_paciente',$id_paciente);
			$this->db->where('lab_resultados_detalle.interpretada','NO');
			
			
			
 

				$result = $this->db->get();
				$num = $result->num_rows();
				
				return $num;
						
	}

	
	
////////////////////FIN//////////////////////////
}
?>