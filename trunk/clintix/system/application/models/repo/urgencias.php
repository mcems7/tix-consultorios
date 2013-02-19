<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: Urgencias
 *Tipo: modelo
 *Descripcion: Acceso a datos de los reportes del servicio de urgencias
 *Autor: Carlos Andrés Jaramillo Patiño <cjaramillo@opuslibertati.org>
 *Fecha de creación: 12 de julio de 2011
*/
class Urgencias extends Model 
{
//////////////////////////////////////////////////////////////////////////
    function __construct()
    {        
        parent::Model();
		
		$this->load->database();
    }
//////////////////////////////////////////////////////////////////////////
function morbilidad($d)
{
	$sql = "SELECT 
  urg_consulta_diag.id_diag AS CIE10,
  core_diag_item.diagnostico AS DIAGNOSTICO,
  SUM(1) AS TOTAL
FROM
  urg_consulta_diag
  INNER JOIN core_diag_item ON (core_diag_item.id_diag = urg_consulta_diag.id_diag)
  INNER JOIN urg_consulta ON (urg_consulta_diag.id_consulta = urg_consulta.id_consulta)
  INNER JOIN urg_atencion ON (urg_consulta.id_atencion = urg_atencion.id_atencion)   ";
 $bandera = 0;
if($d['servicio'] == 1) { 
$bandera = 1;
$sql .="WHERE urg_atencion.id_servicio = '16' OR 
  urg_atencion.id_servicio = '12'";
}else if($d['servicio'] == 2) {
$bandera = 1;
$sql .="WHERE urg_atencion.id_servicio = '17' OR 
  urg_atencion.id_servicio = '13'";
}else if($d['servicio'] == 3) { 
$bandera = 1;
$sql .="WHERE urg_atencion.id_servicio = '19' OR 
  urg_atencion.id_servicio = '14'";
}

if(strlen($d['fecha_inicio'])> 0 && strlen($d['fecha_fin'])> 0){
if($bandera == 0)
$sql .= " WHERE ";
else
$sql .= " AND ";
$sql .= " urg_atencion.fecha_ingreso BETWEEN '".$d['fecha_inicio']." 00:00:00' AND '".$d['fecha_fin']." 23:59:59'";
}
$sql .= " GROUP BY
  urg_consulta_diag.id_diag,
  core_diag_item.diagnostico
ORDER BY
  TOTAL DESC
LIMIT ".$d['total'];

$result = $this->db->query($sql);
return $result->result_array();
}
//////////////////////////////////////////////////////////////////////////
function contar_morbilidad($d)
{
	$sql = "SELECT 
  urg_consulta_diag.id_diag AS CIE10,
  core_diag_item.diagnostico AS DIAGNOSTICO,
  SUM(1) AS TOTAL
FROM
  urg_consulta_diag
  INNER JOIN core_diag_item ON (core_diag_item.id_diag = urg_consulta_diag.id_diag)
  INNER JOIN urg_consulta ON (urg_consulta_diag.id_consulta = urg_consulta.id_consulta)
  INNER JOIN urg_atencion ON (urg_consulta.id_atencion = urg_atencion.id_atencion)   ";
 $bandera = 0;
if($d['servicio'] == 1) { 
$bandera = 1;
$sql .="WHERE urg_atencion.id_servicio = '16' OR 
  urg_atencion.id_servicio = '12'";
}else if($d['servicio'] == 2) {
$bandera = 1;
$sql .="WHERE urg_atencion.id_servicio = '17' OR 
  urg_atencion.id_servicio = '13'";
}else if($d['servicio'] == 3) { 
$bandera = 1;
$sql .="WHERE urg_atencion.id_servicio = '19' OR 
  urg_atencion.id_servicio = '14'";
}

if(strlen($d['fecha_inicio'])> 0 && strlen($d['fecha_fin'])> 0){
if($bandera == 0)
$sql .= " WHERE ";
else
$sql .= " AND ";
$sql .= " urg_atencion.fecha_ingreso BETWEEN '".$d['fecha_inicio']." 00:00:00' AND '".$d['fecha_fin']." 23:59:59'";
}
$sql .= " GROUP BY
  urg_consulta_diag.id_diag,
  core_diag_item.diagnostico";

$result = $this->db->query($sql);
return $result->num_rows();
}
//////////////////////////////////////////////////////////////////////////
}


