<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax-dynamic-list.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
<script type="text/javascript" src="<?=base_url()?>resources/js/mootools1-2-0.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/fValidator.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/validaciones.js"></script>
<link rel="Shortcut Icon" href="<?=base_url()?>resources/img/e.png" type="image/x-icon" />
<link rel="stylesheet" href="<?=base_url()?>resources/menu/menu_style.css" type="text/css" />

<link rel="stylesheet" href="<?=base_url()?>resources/styles/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>resources/styles/general.css" type="text/css" media="screen" />
<!--Mediabox-->
<script type="text/javascript" src="<?=base_url()?>resources/js/mediabox.js"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>resources/styles/mediaboxAdvBlack.css" media="screen"></LINK>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Agenda Citas</th></tr>
<tr><td colspan="2">   
        <div style="display: block; width: 700px; overflow-x: scroll;">
<table class="tabla_interna" width="100%" >
<tr class ="campo_centro">
    <td><div style="width:160px">Médico</div></td>
    <?php
        for($i=0;$i<count($agenda);$i++)
        {
            echo "<td><div style='width:60px'><center>$agenda[$i]</center></div></td>";
        }
    ?>
</tr>
<?php
  
	foreach($arreglo_agenda as $item)
    {
        $i=0;
        echo "<tr>";
        echo '<td id="medico'.$item['id'].'" onClick="pacientes_medico_agenda(\''.$item['id'].'\',\''.$item['nombre'].'\')"><a href="#" onClick="return false">'.$item['nombre']."</a></td>";
		$bloqueado=$item['bloqueado'];
        foreach($item as $key => $value)  
        {
          if(($key!='nombre'&&$key!='id'&&$key!='bloqueado')||$key=='0')
		  
            {if ($bloqueado == 'NO'){
               echo '<td><center><a href="#" onClick="pacientes_medico_agenda(\''.$item['id'].'\',\''.$item['nombre'].'\');return false">'.estado_intervalo($arreglo_disponibilidades[$item['id']],$key,$tiempos_disponibles,$i,$agenda).'</a><center></td>';
               $i++;
            }else{
				echo '<td><center>block<center></td>';
               $i++;

								
				}
        }
		}
         echo "</tr>";
		
    }

 function estado_intervalo($arreglo_disponibilidad_medico, $id_intervalo,$tiempos_disponibles,$posicion_agenda,$agenda)
  {
      $mensaje='<span style="color: GREY">NO</span>';
      $indice=-1;
      //print_r($arreglo_disponibilidad_medico);
      foreach($arreglo_disponibilidad_medico as $item)
      {
          if($item['orden_intervalo']==$id_intervalo)
          {
              $mensaje='<span id="hora'.$indice.'" style="color: GREEN">60</span>';
              foreach($tiempos_disponibles as $key=>$value)
              {
                //echo "key: $key intervalo:$id_intervalo".print_r($item);;
                  if($key==$item['id_agenda_dia_detalle'])
                  {
                      $color="green";
                      $mensaje='<span id="hora'.$item['id_agenda_dia_detalle'].'" style="font-size: 16px;font-weight: bold;color: '.$color.'">'.
                              (60-$value[0]['duracion']).'</span>';
                  }
                     
              }
              $indice=$item['id_agenda_dia_detalle'];
          }
      }
      return '<div style="width:60px; min-height:30px;" onClick="hora_seleccionada(\''.$indice.'\',\''.$agenda[$posicion_agenda].'\')">'.$mensaje.'</div>';
  }
?>
</table>
            </div>
    </td></tr>
</table>
