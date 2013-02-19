<?php
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Epi_model
 *Tipo: modelo
 *Descripcion: Gestión de la vigilancia epidemiologica
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 20 de septiembre de 2012
*/
class Epi_model extends Model 
{
//////////////////////////////////////////////////////////////////////////////////////////////////////////
function __construct()
{        
	parent::Model();	
	$this->load->database();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Verifica la atención si hay DX de obligatorio informe
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120926
* @version		20120926
*/
function verificarAtencionVigilanciaEdit($d)
{
	if(count($d['dx']) > 0 && strlen($d['dx'][0]) > 0)
	{
		for($i=0;$i<count($d['dx']);$i++)
		{ 
			//Se verifica si el DX es de reporte
			$res = $this->verificarDxMorb($d['dx'][$i]);
			if($res == 'SI'){
				$d['id_diag'] = $d['dx'][$i];
				// Se verifica que no se duplique el DX para esa atención
				if($this->verificaExisteDXReporte($d['id_diag'],$d['id_atencion'])){
					$this->agregarCasoVigilanciaMorb($d);
				}else{
					$this->editarCasoVigilancia($d);}
					
			}
		}
	}		
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Verifica si el DX a reportar ya se encuentra en la lista
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120926
* @version		20120926
*/
function verificaExisteDXReporte($dx,$id_atencion)
{
	$this->db->where('dx',$dx);
	$this->db->where('id_atencion',$id_atencion);
	$result = $this->db->get('epi_reporte_dx_sivigila');
	$num = $result->num_rows();
	if($num == 0){
		return true;
	}else{
		return false;
	}	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Verifica si el DX es de morbilidad
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120926
* @version		20120926
*/
function verificarDxMorb($dx)
{
	$this->db->where('id_diag',$dx);
	$this->db->limit(1);
	$result = $this->db->get('core_diag_item');
	$row = $result -> row_array();
	return $row['morb'];
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Metodo principal
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120926
* @version		20120926
*/
function verificarAtencionVigilancia($d)
{
	if(count($d['dx']) > 0 && strlen($d['dx'][0]) > 0)
	{
		for($i=0;$i<count($d['dx']);$i++)
		{ 
			//Se verifica si el DX es de reporte
			$res = $this->verificarDxMorb($d['dx'][$i]);
			if($res == 'SI'){
				$d['id_diag'] = $d['dx'][$i];
				// Se verifica que no se duplique el DX para esa atención
				if($this->verificaExisteDXReporte($d['id_diag'],$d['id_atencion']))
					$this->agregarCasoVigilanciaMorb($d);
			}
		}
	}	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Se crea el reporte de DX
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120926
* @version		20120926
*/
function agregarCasoVigilanciaMorb($d)
{
	$insert = array(
		'id_paciente' => $d['id_paciente'],
		'id_atencion' => $d['id_atencion'],
		'dx' => $d['id_diag'],
		'tipo' => 'Morbilidad',
		'fecha' => date('Y-m-d H:i:s'),
		'id_medico' => $d['id_medico_verifica'],
		'id_servicio' => $d['id_servicio'],
	);
	$this->db->insert('epi_reporte_dx_sivigila',$insert);	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Se edita el DX con el id del medico que verifica
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120926
* @version		20120926
*/
function editarCasoVigilancia($d)
{
	$update = array(
		'id_medico' => $d['id_medico_verifica'],
	);
	$this->db->where('dx',$d['id_diag']);
	$this->db->where('id_atencion',$d['id_atencion']);
	$this->db->update('epi_reporte_dx_sivigila',$update);	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Listado de reportes segun el criterio de busqueda
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120926
* @version		20120926
*/
function obtenerListado($d)
{
$this->db->SELECT(" 
  CONCAT(core_tercero.primer_nombre, ' ', core_tercero.segundo_nombre, ' ', core_tercero.primer_apellido, ' ', core_tercero.segundo_apellido) AS paciente,
  core_tercero.numero_documento,
  core_tipo_documentos.tipo_documento,
  core_servicios_hosp.nombre_servicio,
  CONCAT(core_tercero1.primer_nombre, ' ', core_tercero1.segundo_nombre, ' ', core_tercero1.primer_apellido, ' ', core_tercero1.segundo_apellido) AS medico,
  CONCAT('<strong>',core_diag_item.id_diag,'</strong> - ',core_diag_item.diagnostico) AS dx,
  epi_reporte_dx_sivigila.fecha,
  epi_reporte_dx_sivigila.id_atencion,
  epi_reporte_dx_sivigila.id_reporte,
  epi_reporte_dx_sivigila.estado,
  core_diag_item.id_diag",FALSE);
$this->db->FROM('core_paciente');
$this->db->JOIN('epi_reporte_dx_sivigila','core_paciente.id_paciente = epi_reporte_dx_sivigila.id_paciente');
$this->db->JOIN('core_tercero','core_paciente.id_tercero = core_tercero.id_tercero');
$this->db->JOIN('core_tipo_documentos','core_tercero.id_tipo_documento = core_tipo_documentos.id_tipo_documento');
$this->db->JOIN('core_servicios_hosp','epi_reporte_dx_sivigila.id_servicio = core_servicios_hosp.id_servicio');
$this->db->JOIN('core_medico','epi_reporte_dx_sivigila.id_medico = core_medico.id_medico');
$this->db->JOIN('core_tercero core_tercero1','core_medico.id_tercero = core_tercero1.id_tercero');
$this->db->JOIN('core_diag_item','epi_reporte_dx_sivigila.dx = core_diag_item.id_diag');
if(strlen($d['estado']) > 2)
	$this->db->where('epi_reporte_dx_sivigila.estado',$d['estado']);
if(strlen($d['fecha_inicio']) > 2 && strlen($d['fecha_fin']) > 2){
	$this->db->where('epi_reporte_dx_sivigila.fecha >=', $d['fecha_inicio']." 00:00:00");
	$this->db->where('epi_reporte_dx_sivigila.fecha <=', $d['fecha_fin']." 23:59:59");
}
$result = $this->db->get();
$num = $result -> num_rows();
if($num == 0){
return $num;}
$res = $result -> result_array();
return  $res;	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Se obtiene el caso para consulta
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120926
* @version		20120926
*/
function obtenerCaso($id_reporte)
{
$this->db->SELECT(" 
  epi_reporte_dx_sivigila.id_paciente,
  epi_reporte_dx_sivigila.id_atencion,
  epi_reporte_dx_sivigila.estado,
  epi_reporte_dx_sivigila.fecha,
  epi_reporte_dx_sivigila.id_medico,
  core_servicios_hosp.nombre_servicio,
  CONCAT('<strong>',core_diag_item.id_diag,'</strong> - ',core_diag_item.diagnostico) AS dx,",false);
$this->db->FROM('core_servicios_hosp');
$this->db->JOIN('epi_reporte_dx_sivigila','core_servicios_hosp.id_servicio = epi_reporte_dx_sivigila.id_servicio');
$this->db->JOIN('core_diag_item','epi_reporte_dx_sivigila.dx = core_diag_item.id_diag');
$this->db->where('epi_reporte_dx_sivigila.id_reporte',$id_reporte);
$result = $this->db->get();
return $result -> row_array();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Se cambia el estado del reporte
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120926
* @version		20120926
*/
function inactivar_reporte($id_reporte)
{
	$update = array(
		'estado' => 'Inactivo',
		'fecha_inactiva' => date('Y-m-d H:i:s')
	);	
	$this->db->where('id_reporte',$id_reporte);
	$this->db->update('epi_reporte_dx_sivigila',$update);	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
* Se cambia el estado del reporte
*
* @author Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
* @author http://www.opuslibertati.org
* @copyright    GNU GPL 3.0
* @since		20120928
* @version		20120928
*/
function activar_reporte($id_reporte)
{
	$update = array(
		'estado' => 'Activo',
		'fecha_inactiva' => '0000-00-00 00:00:00'	);	
	$this->db->where('id_reporte',$id_reporte);
	$this->db->update('epi_reporte_dx_sivigila',$update);	
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
}