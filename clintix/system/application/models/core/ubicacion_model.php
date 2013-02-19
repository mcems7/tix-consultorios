<?php
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nombre: atenciones_model
 *Tipo: modelo
 *Descripcion: Contiene todas las operaciones requeridas en la base de datos
 *             para la manipulación de los datos de las zonas geográficas requeridas
 *             por los módulos
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
class ubicacion_model extends Model 
{
     function __construct()
    {   
        parent::Model();
        $this->load->database();
        $this->load->helper('array');
     }
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function departamentos()
{
    return $this->db->get('core_departamento ')->result_array();
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function departamentos_filtrado($l)
{
    $l = preg_replace("/[^a-z0-9 ]/si","",$l);
    $this->db->like('nombre',$l);
    $r = $this->db->get('core_departamento ');
    $dat = $r -> result_array();
    foreach($dat as $d)
    {
       echo $d["id_departamento"]."###".$d["nombre"]."|";
    }
}
////////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function municipios_filtrado_id_departamento($id_departamento)
{
    $this->db->SELECT('id_municipio, nombre');
    $this->db->FROM('core_municipio');
    $this->db->WHERE('id_departamento',$id_departamento);
    return $this->db->get()->result_array();
}
}
///////////////////////////////////////////////////////////////////////////////