<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo_centro">CIE10</td><td class="campo_centro">DIAGNOSTICO</td><td class="campo_centro">TOTAL</td></tr>
<?php
foreach($lista as $d)
{
?>
<tr><td class="campo_centro"><?=$d['CIE10']?></td>
<td><?=$d['DIAGNOSTICO']?></td>
<td class="campo_centro"><?=$d['TOTAL']?></td>
</tr>
<?php
}
?>
</table>
<center>
<?php
$url = 'repo/rep_morbilidad/imprimir/'.$servicio.'/'.$total.'/'.$fecha_inicio.'/'.$fecha_fin;
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url($url)."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</center>