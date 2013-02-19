<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *funciones para manejo de intervalos
 */
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function arreglo_intervalo($parametros_agenda)
{
    $agenda=array();
    for($i=0;$i<= $parametros_agenda[0]['horaFin']-$parametros_agenda[0]['horaInicio'];$i++)
      {
          $agenda[$i]=($parametros_agenda[0]['horaInicio']+$i)."-".($parametros_agenda[0]['horaInicio']+$i+1);
      }
    return $agenda;
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function intervalo_a_hora($intervalo, $parametros_agenda)
{
    $agenda=arreglo_intervalo($parametros_agenda);
    return $agenda[$intervalo];
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function arreglo_horas($parametros_agenda)
{
    $agenda=array();
    for($i=0;$i<= $parametros_agenda[0]['horaFin']-$parametros_agenda[0]['horaInicio'];$i++)
      {
          $agenda[$i]=($parametros_agenda[0]['horaInicio']+$i);
      }
    return $agenda;
}
///////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////
function arreglo_a_hora($intervalo, $parametros_agenda)
{
    $agenda=arreglo_horas($parametros_agenda);
    return $agenda[$intervalo];
}
?>