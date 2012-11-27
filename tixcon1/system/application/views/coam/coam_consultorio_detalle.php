<table width="100%" class="tabla_interna" cellpadding="5">
<tr>
<td class='campo_centro'>No.</td>
<td class='campo_centro'>Fecha y hora de llegada</td>
<td class='campo_centro'>Nombre e identificación del paciente</td>
<td class='campo_centro'>Estado</td>
<td class='campo_centro'>Opciones</td>
</tr>
<?php
$n = count($lista);
if($n>0)
{
	$i = 1;
	foreach($lista as $d)
	{
?>
<tr class="fila">
<td align="center"><strong><?=$i?></strong></td>
<input type='hidden' name='id_estado<?=$d['id_atencion']?>' id='id_estado<?=$d['id_atencion']?>' value='<?=$d['id_estado']?>' />
<?php 
$res = $this->lib_tiempo->alerta($d['fecha_ingreso'],'3');
?>
<td>	
<?=$d['fecha_ingreso']?><br />Tiempo de espera:&nbsp;<?=$res['tiempo']?>
</td>
<td> <a href="#" onclick="consultaPaciente('<?=$d['id_atencion']?>')" class="vpaciente">
<?=$d['primer_nombre']." ".$d['segundo_nombre']." ".$d['primer_apellido']." ".$d['segundo_apellido']?></a><br /><?=$d['tipo_documento'].": ".$d['numero_documento']?><br />
 Edad:&nbsp;<?=$this->lib_edad->edad($d['fecha_nacimiento'])?></td>
<td align="center">
<?php
echo $d['estado'];
?>
</td>
<td align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
<a href="<?=site_url('coam/coam_gestion_atencion/retiro_voluntario/'.$d['id_atencion'])?>">
<img  src="<?=base_url()?>resources/images/against.gif" alt="Retiro voluntario" title="Retiro voluntario" width="20px" height="20px"/>
</a></td>
    <td>
</td>
    <td>  
     <a href="#" onclick="no_responde('<?=$d['id_atencion']?>')">
<img  src="<?=base_url()?>resources/images/x.gif" alt="No responde a llamado" title="No responde a llamado" width="20px" height="20px"/>
</a> </td>
  </tr>
</table>
 </td>
</tr>	
<?php
$i++;
	}
}else{
?>
<tr><td colspan="6" align="center">No hay pacientes en la sala de espera del consultorio</td></tr>
<?php
}
?>
</table>