<h2 class="subtitulo">Agenda Médico</h2> 
    <table width="100%" class="tabla_form">
    
<?php
foreach($fechas as $item)
{
   echo '<tr><th colspan="2">'.$item['fecha'].'</th></tr>';
   echo '<tr><td><table class="tabla_interna"><tr>';
   $contador=0;
   foreach($agenda as $item_agenda)
   {
       if($item['fecha']== $item_agenda['fecha'])
        echo '<td> <Strong>Hora:</Strong>'.arreglo_a_hora($item_agenda['orden_intervalo'],$parametros_agenda).':00</br>'.$item_agenda['consultorio'].'</td>';
       if($contador==5)
       {
           $contador=-1;
           echo '</tr><tr>';
       }
       $contador++;
   }
   echo '</tr></td></tr></table>';
}
?>
    </table>
