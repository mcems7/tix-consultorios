<?php
$this->load->view('coam/coam_adm');
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
	echo form_open('/coam/coam_admision/admPacienteExiste_',$attributes);
	echo form_hidden('id_tercero',$tercero['id_tercero']);
	echo form_hidden('id_paciente',$paciente['id_paciente']);
?>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Admisión de un paciente</h2>
<center>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Datos generales</th></tr>
  <tr>
    <td width="40%" class="campo">Primer apellido:</td>
    <td width="60%">
<?=form_input(array('name' => 'primer_apellido',
					'id'=> 'primer_apellido',
					'class'=>"fValidate['alphanumtilde']",
					'maxlength'   => '20',
					'size'=> '20',
					'value' => $tercero['primer_apellido']))?></td>
  </tr>
  <tr>
    <td class="campo">Segundo apellido:</td>
    <td>
<?=form_input(array('name' => 'segundo_apellido',
					'id'=> 'segundo_apellido',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']",
					'value' => $tercero['segundo_apellido']))?>	
	</td>
  </tr>
  <tr>
    <td class="campo">Primer nombre:</td>
    <td>
<?=form_input(array('name' => 'primer_nombre',
					'id'=> 'primer_nombre',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']",
					'value' => $tercero['primer_nombre']))?></td>
  </tr>
  <tr>
    <td class="campo">Segundo nombre:</td>
    <td>
<?=form_input(array('name' => 'segundo_nombre',
					'id'=> 'segundo_nombre',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']",
					'value' => $tercero['segundo_nombre']))?>
    </td>
  </tr>
  <tr>
    <td class="campo">Fecha de nacimiento:</td>
    <td><input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="<?=$tercero['fecha_nacimiento']?>" size="10" maxlength="10" class="fValidate['dateISO8601']">&nbsp;(aaaa-mm-aa)
	</td>
  </tr>
  <tr>
    <td class="campo">
	Tipo documento:
        </td>
 
    <td><select name="id_tipo_documento" id="id_tipo_documento">
    <?
		foreach($tipo_documento as $d)
		{
				if($tercero['id_tipo_documento'] == $d['id_tipo_documento']){
				echo '<option value="'.$d['id_tipo_documento'].'" selected="selected">'.$d['tipo_documento'].'</option>';
				}else{
				echo '<option value="'.$d['id_tipo_documento'].'">'.$d['tipo_documento'].'</option>';
				}
		}
	?>
    </select></td>
  </tr>
  <tr>
    <td class="campo">Número de documento:</td>
    <td><?=form_input(array('name' => 'numero_documento',
							'id'=> 'numero_documento',
							'maxlength'   => '20',
							'size'=> '20',
							'class'=>"fValidate['alphanumtilde']",
							'value' => $tercero['numero_documento']))?></td>
  </tr>
  <tr>
    <td class="campo">País:</td>
    <td><select name="pais" id="pais" onchange="obtenerDepartamento(0,0)">
 <?
		foreach($pais as $d)
		{	
			
			if($tercero['pais'] == $d['PAI_PK']){
				echo '<option value="'.$d['PAI_PK'].'" selected="selected">'.$d['PAI_NOMBRE'].'</option>';
			}else{
				echo '<option value="'.$d['PAI_PK'].'">'.$d['PAI_NOMBRE'].'</option>';
			}
			
		}
?>
    </select></td>
  </tr>
  <tr>
    <td class="campo">Departamento:</td>
    <td id="div_lista_departamentos">
    <select name="departamento" id="departamento" onchange="obtenerMunicipio()">
    <option value="0">-Seleccione uno-</option>
     <?
		foreach($departamento as $d)
		{	
			if($tercero['departamento'] == 999){
				echo '<option value="999">-No aplica-</option>';
			}else{
				if($tercero['departamento'] == $d['id_departamento']){
					echo '<option value="'.$d['id_departamento'].'" selected="selected">'.$d['nombre'].'</option>';
				}else{
					echo '<option value="'.$d['id_departamento'].'">'.$d['nombre'].'</option>';}	
			}
		}
?>
    </select></td>
  </tr>
  <tr>
    <td class="campo">Municipio:</td>
    <td id="div_lista_municipios">
    <select name="municipio" id="municipio">
    <option value="0">-Seleccione uno-</option>
      <?
		foreach($municipio as $d)
		{	
			if($tercero['municipio'] == 99999){
				echo '<option value="99999">-No aplica-</option>';
			}else{
				if($tercero['municipio'] == $d['id_municipio']){
					echo '<option value="'.$d['id_municipio'].'" selected="selected">'.$d['nombre'].'</option>';
				}else{
					echo '<option value="'.$d['id_municipio'].'">'.$d['nombre'].'</option>';}	
			}
		}
	?>
    </select></td>
  </tr>
  <tr>
    <td class="campo">Barrio / Vereda:</td>
    <td><?=form_input(array('name' => 'vereda',
							'id'=> 'vereda',
							'maxlength' => '200',
							'size'=> '40',
							'class'=>"fValidate['alphanumtilde']",
							'value' => $tercero['vereda']))?></td>
  </tr>
   <tr>
    <td class="campo">Zona:</td>
     <?php
	$res1 = '';
	$res2 = '';
	if($tercero['zona'] == "Rural")
	{
		$res2 = 'checked="checked"';
	}else{
		$res1 = 'checked="checked"';
	}
	?>
    <td>Urbana&nbsp;<input name="zona" id="zona" type="radio" value="Urbana" <?=$res1?> />
    Rural&nbsp;<input name="zona" id="zona" type="radio" value="Rural" <?=$res2?>/></td>
  </tr>
   <tr>
    <td class="campo">Direcci&oacute;n:</td>
    <td><?=form_input(array('name' => 'direccion',
							'id'=> 'direccion',
							'maxlength' => '200',
							'size'=> '40',
							'class'=>"fValidate['required']",
							'value' => $tercero['direccion']))?></td>
  </tr>
  <tr>
    <td class="campo">Teléfono:</td>
    <td><?=form_input(array('name' => 'telefono',
							'id'=> 'telefono',
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['phone']",
							'value' => $tercero['telefono']))?></td>
  </tr>
   <tr>
    <td class="campo">Celular:</td>
    <td><?=form_input(array('name' => 'celular',
							'id'=> 'celular',
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['phone']",
							'value' => $tercero['celular']))?></td>
  </tr>
   <tr>
    <td class="campo">Fax:</td>
    <td><?=form_input(array('name' => 'fax',
							'id'=> 'fax',
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['phone']",
							'value' => $tercero['fax']))?></td>
  </tr>
  <tr>
    <td class="campo">Correo electrónico:</td>
    <td><?=form_input(array('name' => 'email',
							'id'=> 'email',
							'maxlength' => '60',
							'size'=> '40',
							'class'=>"fValidate['email']",
							'value' => $tercero['email']))?></td>
  </tr>
 <tr>
    <td class="campo">Genero:</td>
<?php
$res1 = '';
$res2 = '';
$res3 = '';
if($paciente['genero'] == 'Masculino'){
	$res1 = 'checked="checked"';
}else if($paciente['genero'] == 'Femenino'){
	$res2 = 'checked="checked"';
}else if($paciente['genero'] == 'Indefinido'){
	$res3 = 'checked="checked"';
}
?>
    <td>Masculino&nbsp;<input name="genero" id="genero" type="radio" value="Masculino" <?=$res1?>/>
    Femenino&nbsp;<input name="genero" id="genero" type="radio" value="Femenino" <?=$res2?>/>
    &nbsp;Indefinido<input name="genero" id="genero" type="radio" value="Indefinido" <?=$res3?>/>
	</td>
  </tr>
  <tr>
    <td class="campo">Estado civil:</td>
<?php
$res1 = '';
$res2 = '';
$res3 = '';
$res4 = '';
if($paciente['estado_civil'] == 'Soltero'){
	$res1 = 'selected="selected"';
}else if($paciente['estado_civil'] == 'Casado'){
	$res2 = 'selected="selected""';
}else if($paciente['estado_civil'] == 'Viudo'){
	$res3 = 'selected="selected"';
}else if($paciente['estado_civil'] == 'Unión libre'){
	$res4 = 'selected="selected"';
}
?>
    <td><select name="estado_civil" id="estado_civil">
    <option value="0">-Seleccione uno-</option>
      <option value="Soltero" <?=$res1?>>Soltero</option>
      <option value="Casado" <?=$res2?>>Casado</option>
      <option value="Viudo" <?=$res3?>>Viudo</option>
      <option value="Unión libre" <?=$res4?>>Unión libre</option>
    </select></td>
  </tr>
  
<tr><td class="campo">Tipo usuario:</td>
<td><select name="id_cobertura" id="id_cobertura">
<option value="0">-Seleccione uno-</option>
<?
foreach($tipo_usuario as $d)
{
	if($paciente['id_cobertura'] == $d['id_cobertura'] ){
	echo '<option value="'.$d['id_cobertura'].'" selected="selected">'.$d['cobertura'].'</option>';
	}else{
	echo '<option value="'.$d['id_cobertura'].'">'.$d['cobertura'].'</option>';
	}
}
?>
</select></td></tr>
<tr><td class="campo">Entidad:</td>
<td><select name="id_entidad" id="id_entidad" style="font-size:9px" onchange="obtenerContratosEntidad()">
<option value="0" selected="selected">-Seleccione uno-</option>
<?
foreach($entidad as $d)
{
	if($paciente['id_entidad'] == $d['id_entidad'] ){
	echo '<option value="'.$d['id_entidad'].'" selected="selected">'.$d['razon_social'].'</option>';
	}else{
	echo '<option value="'.$d['id_entidad'].'">'.$d['razon_social'].'</option>';
	}
}
?>
</select>
<script language="javascript">
obtenerContratosEntidad();
</script>
</td></tr>
<tr><td class="campo">Tipo de afiliado:</td>
<?php
$res1 = '';
$res2 = '';
$res3 = '';
$res4 = '';
if($paciente['tipo_afiliado'] == 'Cotizante'){
	$res1 = 'selected="selected"';
}else if($paciente['tipo_afiliado'] == 'Beneficiario'){
	$res2 = 'selected="selected""';
}else if($paciente['tipo_afiliado'] == 'Adicional'){
	$res3 = 'selected="selected"';
}else if($paciente['tipo_afiliado'] == 'Particular'){
	$res4 = 'selected="selected"';
}
?>
<td><select name="tipo_afiliado" id="tipo_afiliado">
    <option value="0">-Seleccione uno-</option>
    <option value="Cotizante" <?=$res1?>>Cotizante</option>
    <option value="Beneficiario" <?=$res2?>>Beneficiario</option>
    <option value="Adicional" <?=$res3?>>Adicional</option>
      <option value="Particular" <?=$res4?>>Particular</option>
</select></td></tr>
<tr><td class="campo">Nivel o categoria:</td>
<td>
<?=form_input(array('name' => 'nivel_categoria',
							'id'=> 'nivel_categoria',
							'maxlength' => '2',
							'size'=> '2',
							'class'=>"fValidate['integer']",
							'value' => $paciente['nivel_categoria']))?>
</td></tr>
<tr><td class="campo">Desplazado:</td>
<?php
$res1 = '';
$res2 = '';
if($paciente['desplazado'] == 'SI'){
	$res1 = 'checked="checked"';
}else if($paciente['desplazado'] == 'NO'){
	$res2 = 'checked="checked"';
}
?>
<td>Si&nbsp;<input name="desplazado" id="desplazado" type="radio" value="SI" <?=$res1?>/>
    No&nbsp;<input name="desplazado" id="desplazado" type="radio" value="NO" <?=$res2?>/></td>
</tr>  
  <tr>
    <td class="campo">Observaciones:</td>
    <td><?=form_textarea(array('name' => 'observaciones',
								'id'=> 'observaciones',
								'value' => $paciente['observaciones'],
								'rows' => '3',
								'cols'=> '30'))?></td>
  </tr>
<tr><td colspan="2" class="linea_azul">&nbsp;</td></tr>
<tr><td class='campo'>Paciente remitido:</td>
<td>
Si&nbsp;<input name="remitido" id="remitido" type="radio" value="SI" onchange="paciente_remitido('SI')"/>&nbsp;
No&nbsp;<input name="remitido" type="radio" id="remitido" onchange="paciente_remitido('NO')" value="NO" checked="checked"/>
<div id="div_remitido"><br />
Entidad remitente:&nbsp;
<select name="codigo_entidad" id="codigo_entidad">
  <option value="0">-Seleccione una-</option>
<?php
	foreach($entidades_remision as $d)
	{
		echo '<option value="'.$d['codigo_entidad'].'">'.$d['nombre'].'</option>';
	}
?>
</select>
</div>
</td>
</tr>

<tr><td  class="campo">Contrato:</td><td id="div_contrato">
<select name="id_contrato" id="id_contrato">
    <option value="0">-Seleccione uno-</option>   
    </select></td></tr>
    
<tr><td  class="campo">Servicio hospitalario:</td><td >
<select name="id_servicio" id="id_servicio">
    <option value="0">-Seleccione uno-</option>
<?php
	foreach($servicios as $d)
	{
		echo '<option value="'.$d['id_servicio'].'">'.$d['nombre_servicio'].'</option>';	
	}
?>      
    </select></td></tr>
<tr><td class="campo" width="40%">Origen de la atenci&oacute;n:</td>
<td width="60%">
<select name="id_origen" id="id_origen" onchange="verificar_entidad()">
<option value="0" selected="selected">-Seleccione uno-</option>
<?
	foreach($origen as $d)
	{		
		echo '<option value="'.$d['id_origen'].'">'.$d['origen'].'</option>';
	}
?>
</select>
</td>
</tr>
<tr><td class="campo" width="40%">Responsable de pago:</td>
<td id="responsable_pago">
</td>
</tr>
<tr>
    <td class="campo">Observaciones admisión:</td>
    <td><?=form_textarea(array('name' => 'observaciones_adm',
								'id'=> 'observaciones_adm',
								'value' => '',
								'rows' => '3',
								'cols'=> '50'))?></td>
  </tr>
<tr><td colspan="2" class="linea_azul">&nbsp;</td></tr>
  <tr><td colspan="2" align="center">
  <?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Guardar')?>
  </td></tr>
</table>
<?=form_close();?>
</center>