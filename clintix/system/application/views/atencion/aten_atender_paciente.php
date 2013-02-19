<table width="100%" class="tabla_form">
<tr><th colspan="2">Atención Paciente</th></tr>
<tr><td colspan="2">

<h2 class="subtitulo">Datos Básicos</h2>        
<table width="100%" class="tabla_interna">
<tr>
  <td class="campo">Nombre: </td><td><?=$datos_cita['primer_nombre']?> <?=$datos_cita['segundo_nombre']?> <?=$datos_cita['primer_apellido']?> <?=$datos_cita['segundo_apellido']?></td>
  <td  class="campo"> Edad: </td> <td  class="campo"> </td>
</tr>
</table>
</td></tr>
<tr><td colspan="2">
<?=form_close();?>
        <table width="90%" class="tabla_interna"></table>
    </td>
</tr>
</table>