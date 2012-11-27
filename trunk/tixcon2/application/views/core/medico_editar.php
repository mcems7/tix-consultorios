<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function obtenerDepartamento()
{
	var var_url = '<?=site_url()?>/core/administrar_medico/obtenerDepartamento';
	
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onSuccess: function(html){$('div_lista_departamentos').set('html', html);},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
		
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
function obtenerMunicipio()
{
	var var_url = '<?=site_url()?>/core/administrar_medico/obtenerMunicipio';
	
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
function noAplicaMunicipio()
{
	var var_url = '<?=site_url()?>/core/administrar_medico/noAplicaMunicipio';
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
function validarFormulario()
{
	var tipo_documento = $('id_tipo_documento').value;
	var pais = $('pais').value;
	var departamento = $('departamento').value;
	var municipio = $('municipio').value;
	
	if(tipo_documento == 0){
		alert("Debe seleccionar un tipo de documento de la lista!!");
		return false;}
	
	if(pais == 0){
		alert("Debe seleccionar un País de la lista!!");
		return false;}
	
	if(departamento == 0){
		alert("Debe seleccionar un departamento de la lista!!");
		return false;}
		
	if(municipio == 0){
		alert("Debe seleccionar un municipio de la lista!!");
		return false;}
	
	for(i=0; i <document.formulario.zona.length; i++){
    if(document.formulario.zona[i].checked){
      var val = document.formulario.zona[i].value;}
    }
	if(!(val == 'Urbana' || val == 'Rural')){
		alert("Debe seleccionar una zona, Urbana o Rural!!");
	}
	
	var esp = $('id_especialidad').value;
	
	if(esp == 0){
		alert("Debe seleccionar un tipo de especialidad medica de la lista!!");
		return false;}
	
	for(i=0; i <document.formulario.estado.length; i++){
    if(document.formulario.estado[i].checked){
      var val = document.formulario.estado[i].value;}
    }
	if(!(val == 'Activo' || val == 'Inactivo')){
		alert("Debe seleccionar el estado del profesional de la salud!!");
	}
	
	var tipo = $('id_tipo_medico').value;
	if(tipo == 0){
		alert("Debe seleccionar un tipo de médico la lista!!");
		return false;}
	
	return true;
}
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	
 var exValidatorA = new fValidator("formulario");
 
 $$('input.DatePicker').each( function(el){
		new DatePicker(el);
	});			 
});
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
	echo form_open('/core/administrar_medico/editarMedico_',$attributes);
	echo form_hidden('id_tercero',$medico['id_tercero']);
	echo form_hidden('id_medico',$medico['id_medico']);
?>
<h1 class="tituloppal">Administración del sistema</h1>
<h2 class="subtitulo">Editar un nuevo integrante del personal médico</h2>
<center>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Datos generales</th></tr>
  <tr>
    <td width="40%" class="campo">Primer apellido:</td>
    <td width="60%">
<?=form_input(array('name' => 'primer_apellido',
					'id'=> 'primer_apellido',
					'class'=>"fValidate['alphanumtilde']",
					'value' => $tercero['primer_apellido'],
					'maxlength'   => '20',
					'size'=> '20'))?></td>
  </tr>
  <tr>
    <td class="campo">Segundo apellido:</td>
    <td>
<?=form_input(array('name' => 'segundo_apellido',
					'id'=> 'segundo_apellido',
					'value' => $tercero['segundo_apellido'],
					'maxlength'   => '20','size'=> '20',
					'class'=>"fValidate['alphanumtilde']"))?>	
	</td>
  </tr>
  <tr>
    <td class="campo">Primer nombre:</td>
    <td>
<?=form_input(array('name' => 'primer_nombre',
					'id'=> 'primer_nombre',
					'value' => $tercero['primer_nombre'],
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']"))?></td>
  </tr>
  <tr>
    <td class="campo">Segundo nombre:</td>
    <td>
<?=form_input(array('name' => 'segundo_nombre',
					'id'=> 'segundo_nombre',
					'value' => $tercero['segundo_nombre'],
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']"))?>
    </td>
  </tr>
   <tr>
    <td class="campo">Fecha de nacimiento:</td>
    <td><input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="<?=$tercero['fecha_nacimiento']?>" size="10" maxlength="10" class="fValidate['dateISO8601']">
    &nbsp;(aaaa-mm-dd)
	</td>
  </tr>
  <tr>
    <td class="campo">
	Tipo documento:
        </td>
   
    <td><select name="id_tipo_documento" id="id_tipo_documento">
      <option value="0">-Seleccione uno-</option>
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
							'value' => $tercero['numero_documento'],
							'maxlength'   => '20',
							'size'=> '20',
							'class'=>"fValidate['nit']"))?></td>
  </tr>
  <tr>
    <td class="campo">País:</td>
    <td><select name="pais" id="pais" onchange="obtenerDepartamento()"> 
    <option value="0">-Seleccione uno-</option>
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
    <select name="departamento" id="departamento">
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
							'value' => $tercero['vereda'],
							'maxlength' => '200',
							'size'=> '40',
							'class'=>"fValidate['alphanumtilde']"))?></td>
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
							'value' => $tercero['direccion'],
							'maxlength' => '200',
							'size'=> '40',
							'class'=>"fValidate['required']"))?></td>
  </tr>
  <tr>
    <td class="campo">Teléfono:</td>
    <td><?=form_input(array('name' => 'telefono',
							'id'=> 'telefono',
							'value' => $tercero['telefono'],
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['phone']"))?></td>
  </tr>
   <tr>
    <td class="campo">Celular:</td>
    <td><?=form_input(array('name' => 'celular',
							'id'=> 'celular',
							'value' => $tercero['celular'],
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['phone']"))?></td>
  </tr>
   <tr>
    <td class="campo">Fax:</td>
    <td><?=form_input(array('name' => 'fax',
							'id'=> 'fax',
							'value' => $tercero['fax'],
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['phone']"))?></td>
  </tr>
  <tr>
    <td class="campo">Correo electrónico:</td>
    <td><?=form_input(array('name' => 'email',
							'id'=> 'email',
							'value' => $tercero['email'],
							'maxlength' => '60',
							'size'=> '40',
							'class'=>"fValidate['email']"))?></td>
  </tr>
 <tr>
    <td class="campo">Especialidad:</td>
    <td><select name="id_especialidad" id="id_especialidad">
      <option value="0">-Seleccione uno-</option>
    <?
		foreach($especialidades as $d)
		{
			if($medico['id_especialidad'] == $d['id_especialidad'])
			{	
				echo '<option value="'.$d['id_especialidad'].'" selected="selected">'.$d['descripcion'].'</option>';
			}else{
				echo '<option value="'.$d['id_especialidad'].'">'.$d['descripcion'].'</option>';	
			}
		}
	?>
    </select></td>
  </tr>
   <tr>
    <td class="campo">Tarjeta profesional:</td>
    <td><?=form_input(array('name' => 'tarjeta_profesional',
							'id'=> 'tarjeta_profesional',
							'value' => $medico['tarjeta_profesional'],
							'maxlength' => '15',
							'size'=> '15',
							'class'=>"fValidate['aplhanum']"))?></td></tr>
  
  <tr>
    <td class="campo">Estado:</td>
    <?php
		$res1 = '';
		$res2 = '';
		if($medico['estado'] == 'Activo'){
			$res1 = 'checked="checked"';
		}else if($medico['estado'] == 'Inactivo'){
			$res2 = 'checked="checked"';
		}
	?>
    <td>Activo&nbsp;<input name="estado" id="estado" type="radio" value="Activo" <?=$res1?> />
    Inactivo&nbsp;<input name="estado" id="estado" type="radio" value="Inactivo" <?=$res2?>/></td>
  </tr>
 
 <tr>
    <td class="campo">Fecha de inicio:</td>
    <td><input name="fecha_inicio" type="text" id="fecha_inicio" value="<?=$medico['fecha_inicio']?>" size="10" maxlength="10" class="calendario" readonly><img src="<?=base_url(); ?>resources/img/calendario_boton.png" id="fecha" title="Seleccionar fecha inicio" style="cursor:pointer" onclick="displayCalendar(document.formulario.fecha_inicio,'yyyy-mm-dd',this)" /></td>
  </tr>
 
  <td class="campo">Fecha de fin:</td>
    <td><input name="fecha_fin" type="text" id="fecha_fin" value="<?=$medico['fecha_fin']?>" size="10" maxlength="10" class="calendario" readonly><img src="<?=base_url(); ?>resources/img/calendario_boton.png" id="fecha" title="Seleccionar fecha fin" style="cursor:pointer" onclick="displayCalendar(document.formulario.fecha_fin,'yyyy-mm-dd',this)" /></td>
  </tr>
    <tr>
    <td class="campo">Tipo de profesional:</td>
    <td><select name="id_tipo_medico" id="id_tipo_medico">
      <option value="0" selected="selected">-Seleccione uno-</option>
   <?
	foreach($tipo_medico as $d)	
	{
		if($medico['id_tipo_medico'] == $d['id_tipo_medico'])
		{		
			echo '<option value="'.$d['id_tipo_medico'].'" selected="selected">'.$d['descripcion'].'</option>';
		}else{
			echo '<option value="'.$d['id_tipo_medico'].'">'.$d['descripcion'].'</option>';
		}
	}
?>
    </select></td>
  </tr>
  <tr>
    <td class="campo">Observaciones:</td>
    <td><?=form_textarea(array('name' => 'observaciones',
								'id'=> 'observaciones',
								'rows' => '3',
								'cols'=> '30',
								'value' => $medico['observaciones']))?></td>
  </tr>
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
