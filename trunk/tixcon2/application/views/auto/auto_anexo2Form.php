<script type="text/javascript">////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	return true;	
}
////////////////////////////////////////////////////////////////////////////////
function obtenerMunicipio()
{
	var var_url = '<?=site_url()?>/auto/main/obtenerMunicipio';
	
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onSuccess: function(html){$('div_lista_municipios').set('html', html);},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
		
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	var exValidatorA = new fValidator("formulario");
});
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Central de autorizaciones - Anexo técnico No. 2</h1>
<h2 class="subtitulo">Informe de la atención inicial de urgencias</h2>
<center>
<?php
$fecha = date('Y-m-d');
$hora = date('H:i');
$id_depa = substr($empresa['id_municipio'], 0, 2);
$id_muni = substr($empresa['id_municipio'], 2, 3);
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/auto/main/anexo2_',$attributes);
echo form_hidden('id_paciente',$paciente['id_paciente']);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('fecha_anexo',$fecha);
echo form_hidden('hora_anexo',$hora);
echo form_hidden('cod_depa_empresa',$id_depa);
echo form_hidden('cod_muni_empresa',$id_muni);
echo form_hidden('numero_informe',$conse);
echo form_hidden('id_empresa',$empresa['id_empresa']);
echo form_hidden('id_entidad',$entidad['id_entidad']);

?>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Información general</th></tr>
<tr><td colspan="2">

<table width="100%" class="tabla_interna">
<tr>
  <td class="campo">Número de la atención:</td><td><? printf("%04d",$conse);?></td>
<td class="campo">Fecha:</td><td><?=$fecha?></td>
<td class="campo">Hora:</td><td><?=$hora?></td></tr>
</table>
</td></tr>
<tr><th colspan="2">Información del prestador</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><td class="campo">Nombre:</td><td colspan="3"><?=$empresa['razon_social']?></td><td class="campo">Nit:</td><td><?=$empresa['nit']?> - <?=$empresa['nit_dv']?></td></tr>
<tr><td class="campo">Código:</td><td><?=$empresa['codigo']?></td><td class="campo">Dirección prestador:</td><td colspan="3"><?=$empresa['direccion']?></td></tr>
<tr><td class="campo">Teléfono:</td><td>(<?=$empresa['indicativo']?>) <?=$empresa['telefono1']?></td><td class="campo">Departamento:</td><td><?=$empresa['depa']?> <strong><?=$id_depa?></strong></td><td class="campo">Municipio:</td><td><?=$empresa['muni']?> <strong><?=$id_muni?></strong></td></tr>
</table>
</td></tr>
<tr><th colspan="2">Entidad a la que se le informa</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><td class="campo">Nombre pagador:</td><td><?=$entidad['razon_social']?></td><td class="campo">Código:</td><td><?=$entidad['codigo_eapb']?></td></tr>
</table>
</td></tr>
<tr>
  <th colspan="2">Datos del paciente</th></tr>
<tr><td>
<table width="100%" class="tabla_interna">
<tr>
<td><?=$tercero['primer_apellido']?>
</td><td>
<?=$tercero['segundo_apellido']?>
</td>
<td>
<?=$tercero['primer_nombre']?>
</td><td>
<?=$tercero['segundo_nombre']?>
</td></tr>
<td class="campo_centro">Primer apellido</td><td class="campo_centro">Segundo apellido</td>
<td class="campo_centro">Primer nombre</td><td class="campo_centro">Segundo nombre</td></tr>
</table>
<table width="100%" class="tabla_interna">
<tr><td class="campo">Tipo identificación:</td><td><select name="id_tipo_documento" id="id_tipo_documento">
<option value="0">-Seleccione uno-</option>
<?
foreach($tipo_documento as $d)
{
	if($tercero['id_tipo_documento'] == $d['id_tipo_documento'])
	{
		echo '<option value="'.$d['id_tipo_documento'].'" selected="selected">'.$d['tipo_documento'].'</option>';
	}else{
		echo '<option value="'.$d['id_tipo_documento'].'">'.$d['tipo_documento'].'</option>';	
	}
}
?>
</select>
<td class="campo">Número documento:</td><td>
<?=form_input(array('name' => 'numero_documento',
					'id'=> 'numero_documento',
					'maxlength'   => '20',
					'size'=> '10',
					'value' => $tercero['numero_documento'],
					'class'=>"fValidate['nit']"))?>
</td></tr><tr>
<td class="campo">Fecha de nacimiento:</td><td colspan="3"><input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="<?=$tercero['fecha_nacimiento']?>" size="10" maxlength="10" class="fValidate['dateISO8601']"></td></tr>
 <tr>
    <td class="campo">Direcci&oacute;n de residencia habitual:</td>
    <td colspan="3"><?=form_input(array('name' => 'direccion',
							'id'=> 'direccion',
							'maxlength' => '200',
							'size'=> '60',
							'class'=>"fValidate['alphanumtilde']",
							'value' => $tercero['direccion']))?></td>
  </tr>
  <tr>
    <td class="campo">Teléfono:</td>
    <td colspan="3"><?=form_input(array('name' => 'telefono',
							'id'=> 'telefono',
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['phone']",
							'value' => $tercero['telefono']))?></td>
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
    </select></td></tr>
</table>

<table width="100%" class="tabla_interna">
<tr><td class="campo_centro">Cobertura en salud</td></tr>
</table>
<table width="100%" class="tabla_interna">
<tr>
<?php
	$i=1;
	foreach($cobertura as $d){
?>
<td><input name="cobertura" type="radio" value="<?=$d['id_cobertura']?>" /><?=$d['cobertura']?></td>
<?php
	if($i % 2 == 0)
		echo "</tr><tr>";
		
	$i++;
	}
?>
</tr>
</table>
</td></tr>
<tr><th colspan="2">Información de la posible inconsistencia</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><td class="campo_centro">Variable presuntamente incorrecta</td><td class="campo_centro" colspan="2">Datos según documento de identificación</td></tr>
<tr><td><input name="primer_apellido_caja" type="checkbox" value="SI" /> Primer apellido</td>
<td>Primer apellido:</td><td><?=form_input(array('name' => 'primer_apellido_doc',
						'id'=> 'primer_apellido_doc',
						'maxlength' => '60',
						'class'=> "fValidate['alphatilde']",
						'size'=> '40'))?></td></tr>
<tr><td><input name="segundo_apellido_caja" type="checkbox" value="SI" /> Segundo apellido</td>
<td>Segundo apellido:</td><td><?=form_input(array('name' => 'segundo_apellido_doc',
						'id'=> 'segundo_apellido_doc',
						'maxlength' => '60',
						'class'=> "fValidate['alphatilde']",
						'size'=> '40'))?></td></tr>
<tr><td><input name="primer_nombre_caja" type="checkbox" value="SI" /> Primer nombre</td>
<td>Primer nombre:</td><td><?=form_input(array('name' => 'primer_nombre_doc',
						'id'=> 'primer_nombre_doc',
						'maxlength' => '60',
						'class'=> "fValidate['alphatilde']",
						'size'=> '40'))?></td></tr>
<tr><td><input name="segundo_nombre_caja" type="checkbox" value="SI" /> Segundo nombre</td>
<td>Segundo nombre:</td><td><?=form_input(array('name' => 'segundo_nombre_doc',
						'id'=> 'segundo_nombre_doc',
						'maxlength' => '60',
						'class'=> "fValidate['alphatilde']",
						'size'=> '40'))?></td></tr>
<tr><td><input name="tipo_documento_caja" type="checkbox" value="SI" /> Tipo documento de identificación</td>
<td>Tipo documento de identificación:</td><td>
<select name="tipo_documento_doc" id="tipo_documento_doc">
<option value="0">-Seleccione uno-</option>
<?
foreach($tipo_documento as $d)
{
	echo '<option value="'.$d['id_tipo_documento'].'">'.$d['tipo_documento'].'</option>';	
}
?>
</select>
</td></tr>
<tr><td><input name="numero_documento_caja" type="checkbox" value="SI" /> Número documento</td>
<td>Número documento:</td><td><?=form_input(array('name' => 'numero_documento_doc',
						'id'=> 'numero_documento_doc',
						'maxlength' => '60',
						'class'=> "fValidate['alphanumtilde']",
						'size'=> '40'))?></td></tr>
<tr><td><input name="fecha_nacimiento_caja" type="checkbox" value="SI" /> Fecha nacimiento</td>
<td>Fecha nacimiento:</td><td><?=form_input(array('name' => 'fecha_nacimiento_doc',
						'id'=> 'fecha_nacimiento_doc',
						'maxlength' => '60',
						'class'=> "fValidate['alphatilde']",
						'size'=> '40'))?></td></tr>
<tr><td class="campo">Observaciones:</td><td colspan="2">
<?=form_textarea(array('name' => 'observaciones',
								'id'=> 'observaciones',
								'rows' => '5',
								'cols'=> '58'))?></td></tr>
</table>
</td></tr>
<tr><th colspan="2">Información de la posible inconsistencia</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><td class="campo">Nombre de quien reporta:</td><td><?=form_input(array('name' => 'nombre_reporta',
						'id'=> 'nombre_reporta',
						'maxlength' => '60',
						'class'=> "fValidate['alphanumtilde']",
						'size'=> '40'))?></td></tr>
<tr><td class="campo">Teléfono:</td><td>
<table cellpadding="0" cellspacing="0">
  <tr>
    <td><?=form_input(array('name' => 'indicativo_reporta',
						'id'=> 'indicativo_reporta',
						'maxlength' => '3',
						'class'=> "fValidate['integer']",
						'size'=> '2'))?></td>
    <td><?=form_input(array('name' => 'telefono_reporta',
						'id'=> 'telefono_reporta',
						'maxlength' => '11',
						'class'=> "fValidate['integer']",
						'size'=> '11'))?></td>
    <td><?=form_input(array('name' => 'ext_reporta',
						'id'=> 'ext_reporta',
						'maxlength' => '4',
						'class'=> "fValidate['integer']",
						'size'=> '3'))?></td>
  </tr>
  <tr>
    <td class="campo_centro">Indicativo</td>
    <td class="campo_centro">Número</td>
    <td class="campo_centro">Extensión</td>
  </tr>
</table>
</td></tr>
<tr><td class="campo">Cargo o actividad:</td><td><?=form_input(array('name' => 'cargo_reporta',
						'id'=> 'cargo_reporta',
						'maxlength' => '60',
						'class'=> "fValidate['alphanumtilde']",
						'size'=> '40'))?></td></tr>
<tr><td class="campo">Teléfono celular:</td><td><?=form_input(array('name' => 'celular_reporta',
						'id'=> 'celular_reporta',
						'maxlength' => '15',
						'class'=> "fValidate['integer']",
						'size'=> '15'))?></td></tr>
</table>
</td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'bv',
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
