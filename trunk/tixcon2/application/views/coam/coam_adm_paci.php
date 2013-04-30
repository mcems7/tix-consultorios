<?php
$this->load->view('coam/coam_adm');
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
	echo form_open('/coam/coam_admision/admTerceroExiste_',$attributes);
	echo form_hidden('id_tercero',$tercero['id_tercero']);
	echo form_hidden('id_cita',$cita['id_cita']);
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
    <td>Masculino&nbsp;<input name="genero" id="genero" type="radio" value="Masculino"/>
    Femenino&nbsp;<input name="genero" id="genero" type="radio" value="Femenino" />
    &nbsp;Indefinido<input name="genero" id="genero" type="radio" value="Indefinido" />
	</td>
  </tr>
  <tr>
    <td class="campo">Estado civil:</td>
    <td><select name="estado_civil" id="estado_civil">
    <option value="0">-Seleccione uno-</option>
      <option value="Soltero">Soltero</option>
      <option value="Casado">Casado</option>
      <option value="Viudo">Viudo</option>
      <option value="Unión libre">Unión libre</option>
    </select></td>
  </tr>
<tr><td class="campo">Entidad:</td>
<td><select name="id_entidad" id="id_entidad">
<option value="0" selected="selected">-Seleccione uno-</option>
<?
foreach($entidad as $d)
{
	echo '<option value="'.$d['id_entidad'].'">'.$d['razon_social'].'</option>';
}
?>
</select></td></tr>
<tr><td class="campo">Consultorio:</td>
<td><select name="id_consultorio" id="id_consultorio">
<option value="0">-Seleccione uno-</option>
<?
foreach($consultorios as $d)
{
	if($cita['id_consultorio'] == $d['id_consultorio']){
	echo '<option value="'.$d['id_consultorio'].'" selected="selected">'.$d['consultorio'].'</option>';
	}else{
	echo '<option value="'.$d['id_consultorio'].'">'.$d['consultorio'].'</option>';
	}
}
?>
</select></td></tr>  
  <tr>
    <td class="campo">Observaciones:</td>
    <td><?=form_textarea(array('name' => 'observaciones',
								'id'=> 'observaciones',
								'rows' => '3',
								'cols'=> '30'))?></td>
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