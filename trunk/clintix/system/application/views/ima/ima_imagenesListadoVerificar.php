<h1 class="tituloppal">Imagenes Diagnosticas</h1>

<table width="100%" class="tabla_form">
<tr><th style="text-align:center">
Ordenes De Imaginologia

</th></tr>
<?php
$n = count($lista);
if($n>0)
{
?>
<table style="width:100%" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Numero Documento</td>
<td class="campo_centro">Paciente</td>
<td class="campo_centro">Examen</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
  $i = 1;
  foreach($lista as $d)
  {
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['numero_documento']?></td>
<td><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></td>
<td><?=$d['desc_subcategoria']?></td>
<td class="opcion"><a href="<?=site_url()?>/ima/ima_verificar/consultarTranscripcion/<?=$d['id']?>"><strong>Verificar</strong></a></td>

<?php
$i++;
  }

}else{
?>

<tr><td colspan="4" class="campo_centro">No se encontraron registros</td></tr>

<?php
}
?>

</table>