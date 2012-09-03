<?php 
/*
###########################################################################
#Esta obra es distribuida bajo los términos de la licencia GPL Versión 3.0#
###########################################################################
*/
/*
 *OPUSLIBERTATI http://www.opuslibertati.org
 *Proyecto: SISTEMA DE INFORMACIÓN - GESTIÓN HOSPITALARIA
 *Nobre: datos_listas_helper
 *Tipo: helper
 *Descripcion: Permite generar valores en formato de impresión de valores
 *             de listas de las remisiones.
 *Autor: José Miguel Londoño Montilla <jlondono@opuslibertati.org>
 *Fecha de creación: 06 de Febrero de 2011
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *funciones para manejo de intervalos
 */
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function valor_tipo_cita($tipo_cita)
{
    if("consulta_primera_vez"==$tipo_cita)
        return "Primera Vez";
    if("consulta_control"==$tipo_cita)
        return "Control";
    if("control_pos_operatorio"==$tipo_cita)
        return "Control Pos Operatorio";
    if("consulta_procedimiento"==$tipo_cita)
        return "Procedimiento";
    return "Repetitiva";
}
///////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function valor_prioridad($prioridad)
{
    if($prioridad=="adulto_mayor")
        return "Adulto Mayor";
    if($prioridad=="alto_riesgo")
        return "Alto Riesgo";
    if($prioridad=="riesgo_cardiovascular")
        return "Riesgo Cardio Vascular";
    if($prioridad=="discapacitados")
        return "Discapacitados";
    if($prioridad=="epileptico")
        return "Epiléptico";
    if($prioridad=="programas_especiales")
        return "Programas Especiales";
    if($prioridad=="alto_costo")
        return "Alto Costo";
    if($prioridad=="anticoagulados")
        return "Anticuagulados";
    if($prioridad=="menores")
        return "Menores de 1 Año";
    return "Enfermedad General";
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function valor_motivo_consulta($valor)
{

  if($valor==1) return "Accidente Trabajo";
  if($valor==2) return "Accidente Tránsito";
  if($valor==3) return "Accidente Rábico";
  if($valor==4) return "Accidente Ofíbico";
  if($valor==5) return "Otro Accidente";
  if($valor==6) return "Evento Catastrófico";
  if($valor==7) return "Lesión por Agresión";
  if($valor==8) return "Lesión Autoinfligida";
  if($valor==9) return "Sospecha Maltrato Físico";
  if($valor==10) return "Sospecha Abuso Sexual";
  if($valor==11) return "Sospecha Violencia Sexual";
  if($valor==12) return "Sospecha Maltr. Emocional";
  if($valor==13) return "Enfermedad General";
  if($valor==14) return "Enfermedad Profesional";
  return "Otra";
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function valor_prioritaria($valor)
{
    if($valor=="prioritaria") return "Prioritaria";
    return "No Prioritaria";
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function estado_cita($valor)
{
    if($valor=="solicitada")    return "Solicitada";
    if($valor=="autorizada")    return "Autorizada";
    if($valor=="asignada")      return "Asignada";
    if($valor=="confirmada")    return "Confirmada";
    if($valor=="rechazada")     return "Rechazada";
    if($valor=="cancelada")     return "Cancelada";
    if($valor=="cancelada")     return "Cancelada";
    if($valor=="atendida")     return "atendida";
}