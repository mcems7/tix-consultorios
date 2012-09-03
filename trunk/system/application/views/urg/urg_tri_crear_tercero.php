<script language="javascript">
window.addEvent("domready", function(){
  
  botones = new Fx.Slide('botones');
  <?php
	if($tipo == 'tercero')
	{
		echo "slideTri.hide();";
	}else{
		echo "botones.hide();";
	}
?>	
 
		 
});
</script>
<div id="datos_tercero">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr><td width="40%">Primer apellido:</td>
<td width="60%">
<?=form_input(array('name' => 'primer_apellido',
					'id'=> 'primer_apellido',
					'class'=>"fValidate['alphanumtilde']",
					'maxlength'   => '20',
					'size'=> '20'))?></td></tr>
<tr><td>Segundo apellido:</td><td>
<?=form_input(array('name' => 'segundo_apellido',
					'id'=> 'segundo_apellido',
					'maxlength'   => '20','size'=> '20',
					'class'=>"fValidate['alphanumtilde']",
					'value' => ' '))?></td></tr>
<tr><td>Primer nombre:</td><td>
<?=form_input(array('name' => 'primer_nombre',
					'id'=> 'primer_nombre',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']"))?></td></tr>
<tr><td>Segundo nombre:</td><td>
<?=form_input(array('name' => 'segundo_nombre',
					'id'=> 'segundo_nombre',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']",
					'value' => ' '))?></td></tr>
<tr><td>Tipo documento:</td><td>
<select name="id_tipo_documento" id="id_tipo_documento">
<option value="0" selected="selected">-Seleccione uno-</option>
<?
foreach($tipo_documento as $d)
{
	echo '<option value="'.$d['id_tipo_documento'].'">'.$d['tipo_documento'].'</option>';
}
?>
</select>
</td></tr>
<tr><td>Número de documento:</td><td>
<?=form_input(array('name' => 'numero_documento',
					'id'=> 'numero_documento',
					'maxlength'   => '20',
					'size'=> '20',
					'readonly' => 'readonly',
					'value' => $numero_documento,
					'class'=>"fValidate['nit']"))?></td></tr>
<tr><td>Fecha de nacimiento:</td>
<td><input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="" size="10" maxlength="10" class="fValidate['dateISO8601']">
&nbsp;(aaaa-mm-dd)</td></tr>
</table>
</div>
<div id="botones">
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?
$data = array(	'name' => 'bc',
				'onclick' => 'comprobar()',
				'value' => 'Comprobar',
				'type' =>'button');
echo form_input($data);
?>
</center>
</div>
<div id="lista_terceros">
</div>