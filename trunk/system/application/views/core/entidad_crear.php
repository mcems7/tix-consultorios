<?=$this -> load -> view("core/tabla_dinamica.js.php");?>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function obtEstructuraRegistro(tablaId)
{
	var registro = new Array();

	if(tablaId == "lista_correos")
	{
		registro[0] = { 'elemento': 'input',
				'type'    : 'checkbox',
				'id'      : 'marca',
				'name'    : 'marca' };

		registro[1] = { 'elemento'  : 'input',
						'type'      : 'text',
						'id'        : 'correo_entidad[]',
						'name'      : 'correo_entidad[]',
						'size'      : '50',
						'value'     : '',
						'maxlength'	: '60'	
						 };

		return registro;
	}

	return null;
}
////////////////////////////////////////////////////////////////////////////////
function obtPropiedadesCampo(tablaId)
{
	if (tablaId == "lista_correos") 
	{
		return {'class': 'campo_centro'};
	}

	return null;
}
////////////////////////////////////////////////////////////////////////////////
function obtPropiedadesFila(tablaId)
{
	if (tablaId == "lista_correos") 
	{
		return {} 
	}

	return null;
}
////////////////////////////////////////////////////////////////////////////////
function obtenerDepartamento()
{
	var var_url = '<?=site_url()?>/core/administrar_entidades/obtenerDepartamento';
	
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
	var var_url = '<?=site_url()?>/core/administrar_entidades/obtenerMunicipio';
	
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
	var var_url = '<?=site_url()?>/core/administrar_entidades/noAplicaMunicipio';
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
	
	for(i=0; i <document.formulario.estado.length; i++){
    if(document.formulario.estado[i].checked){
      var val = document.formulario.estado[i].value;}
    }
	if(!(val == 'Activa' || val == 'Inactiva')){
		alert("Debe seleccionar el estado de la entidad!!");
		return false;
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
	echo form_open('/core/administrar_entidades/crearEntidad_',$attributes);
?>
<h1 class="tituloppal">Administración del sistema</h1>
<h2 class="subtitulo">Crear una entidad administradora de planes de beneficio</h2>
<center>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Datos generales</th></tr>
    <tr>
      <td width="40%" class="campo">Razón social:</td>
      <td width="60%">
  <?=form_input(array('name' => 'razon_social',
					'id'=> 'razon_social',
					'maxlength'   => '200',
					'size'=> '40',
					'class'=>"fValidate['alphanumtilde']",
					'value' => ' '))?>
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
     <td class="campo">Direcci&oacute;n:</td>
     <td><?=form_input(array('name' => 'direccion',
							'id'=> 'direccion',
							'maxlength' => '200',
							'size'=> '40',
							'class'=>"fValidate['regired']"))?></td>
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
     <td class="campo">Código de la entidad:</td>
    <td><?=form_input(array('name' => 'codigo_eapb',
							'id'=> 'codigo_eapb',
							'maxlength' => '10',
							'size'=> '6',
							'class'=>"fValidate['aplhanum']"))?></td></tr>
  
   <tr>
    <td class="campo">Estado:</td>
    <td>Activa&nbsp;<input name="estado" id="estado" type="radio" value="Activa" />
    Inactiva&nbsp;<input name="estado" id="estado" type="radio" value="Inactiva" /></td>
  </tr>
  <tr>
    <td class="campo">Correos de notificación y autorización de servicios:</td>
    <td>
    <table id="lista_correos" width="100%" class="tabla_interna"> 
<tbody> 
	<tr> 
		<td class="campo_centro">Marca</td> 
		<td class="campo_centro">Correo electrónico</td> 
	</tr>
    <tr class=" TDRegistro"><td class="campo_centro TDCampo TDMarca" style="text-align: center;"><input type="checkbox" id="marca" name="marca"></td><td class="campo_centro TDCampo"><input type="text" id="correo_entidad[]" name="correo_entidad[]" size="50" maxlength="60"></td></tr>
</tbody> 
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => "TDAgregarRegistro('lista_correos')",
				'value' => 'Agregar',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?
$data = array(	'name' => 'bv',
				'onclick' => "TDRemoverRegistros('lista_correos')",
				'value' => 'Remover',
				'type' =>'button');
echo form_input($data);
?>
</center>
    </td>
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