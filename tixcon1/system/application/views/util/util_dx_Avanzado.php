<script language="javascript">
function capituloDx()
{
	var cap = $('capitulo').value;
	var var_url = '<?=site_url()?>/util/diagnosticos/dxCaps/'+cap;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('tdnivel1').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
//////////////////////////////////////////////////////////////////////////////////////////
function nivel1Dx()
{
	var nivel1s = $('nivel1').value;
	var var_url = '<?=site_url()?>/util/diagnosticos/dxNivel1/'+nivel1s;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('tdnivel2').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
//////////////////////////////////////////////////////////////////////////////////////////
function nivel2Dx()
{
	var nivel2s = $('nivel2').value;
	var var_url = '<?=site_url()?>/util/diagnosticos/dxNivel2/'+nivel2s;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('tdnivel3').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
</script>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo_centro">Asistente de codificación de diagnostico</td></tr>
<tr><td>
<select name="capitulo" id="capitulo" onChange="capituloDx()">
  <option value="0">-Seleccione-</option>
<?php
	foreach($capitulos as $d)
	{
		echo '<option value="'.$d['id_capitulo'].'">'.$d['desc_capitulo'].'</option>';
	}
?>
</select>
</td></tr>
  <tr>
    <td id="tdnivel1"><select>
  <option value="0">-Seleccione-</option>
</select></td>
  </tr>
  <tr>
    <td id="tdnivel2"><select>
  <option value="0">-Seleccione-</option>
</select></td>
  </tr>
  <tr>
    <td id="tdnivel3"><select id="dx_hidden">
  <option value="0">-Seleccione-</option>
</select></td>
  </tr>
 <tr><td><?
$data = array(	'name' => 'ba',
				'onclick' => "simple()",
				'value' => 'Búsqueda simple',
				'type' =>'button');
echo form_input($data);
?></td></tr>
</table>
</center>
<input type="hidden" id="dx" value="111">