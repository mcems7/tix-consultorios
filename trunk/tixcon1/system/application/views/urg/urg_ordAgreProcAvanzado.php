<script language="javascript">
//////////////////////////////////////////////////////////////////////////////////////////
function capituloSec()
{
	var sec = $('seccion').value;
	var var_url = '<?=site_url()?>/urg/ordenamiento/cupsCaps/'+sec;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('TDcapitulo').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
//////////////////////////////////////////////////////////////////////////////////////////
function gruposCap()
{
	var cap = $('id_capitulo').value;
	var var_url = '<?=site_url()?>/urg/ordenamiento/cupsGrupos/'+cap;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('TDgrupo').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
//////////////////////////////////////////////////////////////////////////////////////////
function subGGru()
{
	var gru = $('id_grupo').value;
	var var_url = '<?=site_url()?>/urg/ordenamiento/cupsSubGrupos/'+gru;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('TDsubGrupo').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();
}
//////////////////////////////////////////////////////////////////////////////////////////
function CubGcate()
{
	var sgru = $('id_subgrupo').value;
	var var_url = '<?=site_url()?>/urg/ordenamiento/cupsCategorias/'+sgru;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('TDcategorias').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}

function CubCaSubca()
{
	var cate = $('id_categoria').value;
	var var_url = '<?=site_url()?>/urg/ordenamiento/cupsSubCate/'+cate;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('TDsubCate').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send()	
}
</script>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td>
<select name="seccion" id="seccion" onChange="capituloSec()">
  <option value="0">-Seleccione-</option>
<?php
	foreach($secciones as $d)
	{
		echo '<option value="'.$d['id_seccion'].'">'.$d['desc_seccion'].'</option>';
	}
?>
</select>
</td></tr>
  <tr>
    <td id="TDcapitulo"><select>
  <option value="0">-Seleccione-</option>
</select></td>
  </tr>
  <tr>
    <td id="TDgrupo"><select>
  <option value="0">-Seleccione-</option>
</select></td>
  </tr>
  <tr>
    <td id="TDsubGrupo"><select>
  <option value="0">-Seleccione-</option>
</select></td>
  </tr>
    <tr>
    <td id="TDcategorias"><select>
  <option value="0">-Seleccione-</option>
</select></td>
  </tr>
    <tr>
    <td id="TDsubCate"><select id="cups_hidden">
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
<tr><td>
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td class="campo" width="20%">Cantidad:</td>
<td width="80%">
<?=form_input(array('name' => 'cantidadCups',
							'id'=> 'cantidadCups',
							'maxlength' => '4',
							'value' => '0',
							'size'=> '4',
							'class'=>"fValidate['integer']"))?></td></tr>
<tr><td class="campo" width="20%">Observaciones:</td>
<td width="80%"><?=form_textarea(array('name' => 'observacionesCups',
							'id'=> 'observacionesCups',
							'rows' => '5',
							'cols'=> '45'))?></td></tr>
</table>
<input type="hidden" id="flagCups" name="flagCups" value="avanzado">
</td></tr>
</table>
</center>
