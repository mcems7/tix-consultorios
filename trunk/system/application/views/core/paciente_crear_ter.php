<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function obtenerDepartamento()
{
	var var_url = '<?=site_url()?>/core/administrar_ter/obtenerDepartamento';
	
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
	var var_url = '<?=site_url()?>/core/administrar_ter/obtenerMunicipio';
	
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
	var var_url = '<?=site_url()?>/core/administrar_ter/noAplicaMunicipio';
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
		return false;
	}
	
	for(i=0; i <document.formulario.genero.length; i++){
    if(document.formulario.genero[i].checked){
      var val = document.formulario.genero[i].value;}
    }
	if(!(val == 'Femenino' || val == 'Masculino' || val == 'Indefinido')){
		alert("Debe seleccionar el genero del paciente!!");
		return false;
	}
	
	var estado_civil = $('estado_civil').value;
	if(estado_civil == 0){
		alert("Debe seleccionar un estado civil!!");
		return false;}
		
	if($('id_cobertura').value == 0){
		alert("Debe seleccionar un tipo de usuario!!");
		return false;}
		
	if($('id_entidad').value == 0){
		alert("Debe seleccionar una Entidad administradora de planes de beneficio!!");
		return false;}
		
	if($('tipo_afiliado').value == 0){
		alert("Debe seleccionar el tipo de afiliado!!");
		return false;}
	
	for(i=0; i <document.formulario.desplazado.length; i++){
    if(document.formulario.desplazado[i].checked){
      var val = document.formulario.desplazado[i].value;}
    }
	if(!(val == 'SI' || val == 'NO')){
		alert("Debe indicar si el paciente es desplazado o no!!");
	}
	
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
});
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
	echo form_open('/core/administrar_paciente/crearPacienteTer_',$attributes);
?>
<h1 class="tituloppal">Administración del sistema</h1>
<h2 class="subtitulo">Crear un nuevo paciente</h2>
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
					'size'=> '20'))?></td>
  </tr>
  <tr>
    <td class="campo">Segundo apellido:</td>
    <td>
<?=form_input(array('name' => 'segundo_apellido',
					'id'=> 'segundo_apellido',
					'maxlength'   => '20','size'=> '20',
					'class'=>"fValidate['alphanumtilde']",
					'value' => ' '))?>	
	</td>
  </tr>
  <tr>
    <td class="campo">Primer nombre:</td>
    <td>
<?=form_input(array('name' => 'primer_nombre',
					'id'=> 'primer_nombre',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']"))?></td>
  </tr>
  <tr>
    <td class="campo">Segundo nombre:</td>
    <td>
<?=form_input(array('name' => 'segundo_nombre',
					'id'=> 'segundo_nombre',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']",
					'value' => ' '))?>
    </td>
  </tr>
   <tr>
    <td class="campo">Fecha de nacimiento:</td>
    <td><input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="" size="10" maxlength="10" class="fValidate['dateISO8601']">
    &nbsp;(aaaa-mm-dd)
	</td>
  </tr>
  <tr>
    <td class="campo">
	Tipo documento:
        </td>
   
    <td><select name="id_tipo_documento" id="id_tipo_documento">
      <option value="0" selected="selected">-Seleccione uno-</option>
    <?
		foreach($tipo_documento as $d)
		{
				echo '<option value="'.$d['id_tipo_documento'].'">'.$d['tipo_documento'].'</option>';
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
							'class'=>"fValidate['nit']"))?></td>
  </tr>
  <tr>
    <td class="campo">País:</td>
    <td><select name="pais" id="pais" onchange="obtenerDepartamento()">
     <option value="0" selected="selected">-Seleccione uno-</option>
     <option value="52">Colombia</option>
 <?
		foreach($pais as $d)
		{	
			if($d['PAI_PK'] != 52)
			echo '<option value="'.$d['PAI_PK'].'">'.$d['PAI_NOMBRE'].'</option>';
		}
?>
    </select></td>
  </tr>
  <tr>
    <td class="campo">Departamento:</td>
    <td id="div_lista_departamentos">
    <select name="departamento" id="departamento">
    <option value="0" selected="selected">-Seleccione uno-</option>
    </select></td>
  </tr>
  <tr>
    <td class="campo">Municipio:</td>
    <td id="div_lista_municipios">
    <select name="municipio" id="municipio">
    <option value="0" selected="selected">-Seleccione uno-</option>
    </select></td>
  </tr>
  <tr>
    <td class="campo">Barrio / Vereda:</td>
    <td><?=form_input(array('name' => 'vereda',
							'id'=> 'vereda',
							'maxlength' => '200',
							'size'=> '40',
							'class'=>"fValidate['alphanumtilde']",
							'value' => ' '))?></td>
  </tr>
   <tr>
    <td class="campo">Zona:</td>
    <td>Urbana&nbsp;<input name="zona" id="zona" type="radio" value="Urbana" />
    Rural&nbsp;<input name="zona" id="zona" type="radio" value="Rural" /></td>
  </tr>
   <tr>
    <td class="campo">Direcci&oacute;n:</td>
    <td><?=form_input(array('name' => 'direccion',
							'id'=> 'direccion',
							'maxlength' => '200',
							'size'=> '40',
							'class'=>"fValidate['required']"))?></td>
  </tr>
  <tr>
    <td class="campo">Teléfono:</td>
    <td><?=form_input(array('name' => 'telefono',
							'id'=> 'telefono',
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['phone']"))?></td>
  </tr>
   <tr>
    <td class="campo">Celular:</td>
    <td><?=form_input(array('name' => 'celular',
							'id'=> 'celular',
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['phone']",
							'value' => ' '))?></td>
  </tr>
   <tr>
    <td class="campo">Fax:</td>
    <td><?=form_input(array('name' => 'fax',
							'id'=> 'fax',
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['phone']",
							'value' => ' '))?></td>
  </tr>
  <tr>
    <td class="campo">Correo electrónico:</td>
    <td><?=form_input(array('name' => 'email',
							'id'=> 'email',
							'maxlength' => '60',
							'size'=> '40',
							'class'=>"fValidate['email']",
							'value' => 'correo@dominio.com'))?></td>
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
  
<tr><td class="campo">Tipo usuario:</td>
<td><select name="id_cobertura" id="id_cobertura">
<option value="0">-Seleccione uno-</option>
<?
foreach($tipo_usuario as $d)
{
	echo '<option value="'.$d['id_cobertura'].'">'.$d['cobertura'].'</option>';
}
?>
</select></td></tr>
<tr><td class="campo">Entidad:</td>
<td><select name="id_entidad" id="id_entidad" style="font-size:9px">
<option value="0" selected="selected">-Seleccione uno-</option>
<?
foreach($entidad as $d)
{
	echo '<option value="'.$d['id_entidad'].'">'.$d['razon_social'].'</option>';
}
?>
</select></td></tr>
<tr><td class="campo">Tipo de afiliado:</td>
<td><select name="tipo_afiliado" id="tipo_afiliado">
    <option value="0">-Seleccione uno-</option>
    <option value="Cotizante">Cotizante</option>
    <option value="Beneficiario">Beneficiario</option>
    <option value="Adicional">Adicional</option>
</select></td></tr>
<tr><td class="campo">Nivel o categoria:</td>
<td>
<?=form_input(array('name' => 'nivel_categoria',
							'id'=> 'nivel_categoria',
							'maxlength' => '2',
							'size'=> '2',
							'class'=>"fValidate['integer']"))?>
</td></tr>
<tr><td class="campo">Desplazado:</td>
<td>Si&nbsp;<input name="desplazado" id="desplazado" type="radio" value="SI"/>
    No&nbsp;<input name="desplazado" id="desplazado" type="radio" value="NO"/></td>
</tr>  
  <tr>
    <td class="campo">Observaciones:</td>
    <td><?=form_textarea(array('name' => 'observaciones',
								'id'=> 'observaciones',
								'rows' => '3',
								'cols'=> '30'))?></td>
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