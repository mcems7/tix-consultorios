<tr><th colspan="2">Impresi&oacute;n diagnostica</th></tr>
<tr><td colspan="2" class="campo_centro">
Para asegurar la calidad de la información ingresada en la historia clínica referente a la morbilidad hospitalaria se deben ingresar los diagnósticos de la atención en estricto orden de relevancia.
</td></tr>
<tr><td colspan="2">
<div id="div_lista_dx">
</div>
</td></tr>
<tr><td colspan="2" id="div_dx">
<?php
	echo $this->load->view('util/util_dx_Simple');
?>
<tr><td colspan="2">
<table>
<tr><td class="campo">Tipo de diagnóstico:</td>	
<td>
<input type="radio" name="tipo_dx" value="1" id="tipo_dx_0" />&nbsp;Impresión diagnóstica<br />
<input type="radio" name="tipo_dx" value="2" id="tipo_dx_1" />&nbsp;Confirmado nuevo<br />
<input type="radio" name="tipo_dx" value="3" id="tipo_dx_2" />&nbsp;Confirmado repetido<br />
<input type="hidden" value="0" name="orden_dx" id="orden_dx" />
</td>
<td style="font-weight:900;">
<ol>
<li>Diagnóstico principal.</li>
<li>Diagnóstico relacionado 1.</li>
<li>Diagnóstico relacionado 2.</li>
<li>Diagnóstico relacionado 3.</li>
<li>Diagnóstico relacionado 4.</li>
</ol>
</td>
</tr>
</table>
</td></tr>
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'agregar_dX()',
				'value' => 'Agregar diagnostico',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>