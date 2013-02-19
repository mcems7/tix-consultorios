<table width="100%" border="1" cellspacing="2" cellpadding="0" style="border-collapse:collapse; border-style:solid; border-width:1px">
<tr>
<td class="campo_centro">Fecha orden</td>
<td class="campo_centro">Dosis</td>
<td class="campo_centro">Unidad</td>
<td class="campo_centro">Frecuencia</td>
<td class="campo_centro">Vía</td>
<td class="campo_centro">Despacho</td>
<td class="campo_centro">Cantidad despachada</td>
</tr>

<?php
	foreach($lista as $d)
	{
		$via = $this->farmacia_model->obtenerValorVarMedi($d['id_via']);
    	$uni_frecuencia = $this->farmacia_model->obtenerValorVarMedi($d['id_frecuencia']);
    	$unidad = $this->farmacia_model->obtenerValorVarMedi($d['id_unidad']);
?>
<tr>
<td align="center"><?=$d['fecha_creacion']?></td>
<td align="center"><?=$d['dosis']?></td>
<td align="center"><?=$unidad?></td>
<td align="center"><?="Cada ".$d['frecuencia']." ".$uni_frecuencia?></td>
<td align="center"><?=$via?></td>
<td align="center"><?=$d['despachoMed']?></td>
<td align="center"><?=$d['cantidadMed']?></td>
</tr>
<?php
	}
?>
<tr><td colspan="7">
<span class="texto_barra_med">
<a href="#div_<?=$d['atc']?>" onclick="resetDiv('<?=$d['atc']?>')" title="Ocultar historial del medicamento">
Ocultar historial del medicamento
<img src="<?=base_url()?>resources/img/triangulo.png"/></a></span>
</td>
</tr>
</table>

