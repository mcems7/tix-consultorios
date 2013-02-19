<script type="text/javascript">

window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
});
var total_diagnosticos=0
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
  document.location = "<?=site_url()?>";
}
////////////////////////////////////////////////////////////////////////////////
function borrarForm()
{	
	$('dx_hidden').value = '';
	$('dx').value = '';
	simple();
}
////////////////////////////////////////////////////////////////////////////////
function eliminarDx(id_tabla)
{	
	if(confirm('¿Desea eliminar el diagnostico seleccionado?'))
		{
                    $(id_tabla).dispose();	
                    --total_diagnosticos;
                }
            ;
}
////////////////////////////////////////////////////////////////////////////////
function avanzado()
{
	var var_url = '<?=site_url()?>/util/diagnosticos/dxAvanzados';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_dx').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function simple()
{
	var var_url = '<?=site_url()?>/util/diagnosticos/dxSimple';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_dx').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function interconsulta()
{
	var tipo = $('id_tipo_evolucion').value;
	if(tipo == 3){
		slideEsp.slideIn();
	}else{
		slideEsp.slideOut();
	}
}

////////////////////////////////////////////////////////////////////////////////
function agregar_dX()
{
	if(!validarDx())
	{
		return false;
	}
	$('contador').value=total_diagnosticos;
	var var_url = '<?=site_url()?>/atencion/atenciones/agregar_dx';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $('div_lista_dx').get('html');
		$('div_lista_dx').set('html',html2, html);
		$('div_precarga').style.display = "none";
                ++total_diagnosticos;},
		onComplete: function(){
			borrarForm();	
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function validarDx()
{
	if($('dx_hidden').value < 1){
		alert("Debe realizar la búsqueda de un diagnostico");
		return false;
	}
	return true;
}
function validarFormulario()
{	
 if(total_diagnosticos==0)
      {
          alert("Debe Seleccionar un Diagnóstico");
          return false;
      }
  if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
  {
      return true
  }else{
      return false;
  } 
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$attributes = array('id'       => 'formulario',
                    'name'     => 'formulario',
                    'method'   => 'post',
                    'onsubmit' => 'return validarFormulario()');
echo form_open_multipart('atencion/atenciones/registrar_hce',$attributes);

?> 

<h1 class="tituloppal">Atención del Paciente</h1>
<h2 class="subtitulo">Registro de Atención</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr><td colspan="2">       
<table width="100%" class="tabla_interna">
    
       <tr> <td class="campo_izquierda">Fecha de nacimiento</td><td><?=$info_cita['fecha_nacimiento']?></td> </<tr>
       <td class="campo_izquierda">Edad</td><td><?=$info_cita['edad']?></td>
       <tr> 
        <td class="campo_izquierda">Documento</td><td><?=$info_cita['numero_documento']?></td>
        <td class="campo_izquierda">Nombre</td><td><?=$info_cita['primer_nombre']?> <?=$info_cita['segundo_nombre']?> <?=$info_cita['primer_apellido']?> <?=$info_cita['segundo_apellido']?></td> 
       </<tr>
       <tr> 
        <td class="campo_izquierda">Departamento</td><td><?=$info_cita['departamento']?></td>
        <td class="campo_izquierda">Ciudad</td><td><?=$info_cita['municipio']?> </td> 
       </<tr>
       <tr> 
        <td class="campo_izquierda">Dirección</td><td><?=$info_cita['direccion']?></td>
        <td class="campo_izquierda">Teléfono</td><td><?=$info_cita['telefono']?> </td> 
       </<tr>
       <tr> 
        <td class="campo_izquierda">Celular</td><td><?=$info_cita['celular']?></td>
        <td class="campo_izquierda">Email</td><td><?=$info_cita['email']?> </td> 
       </<tr>
</table
    ></td></tr>

<tr>
  <th colspan="2">Historia Clínica    </th></tr>
<tr>
  <td colspan="2">
<?php 

  foreach($id_clinicos as $d)
  {
          echo $this->load->view('atencion/aten_ordInsertRegistro',$d);
  }
?>  
  </td></tr> 
  <tr><th colspan="2">Impresi&oacute;n diagnóstica</th></tr>
<tr><td colspan="2">
<div id="div_lista_dx">
  
</div>
</td></tr>
<tr><td colspan="2" id="div_dx">
<?php
	echo $this->load->view('urg/urg_dxSimple');
?>
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'agregar_dX()',
				'value' => 'Agregar diagnóstico',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
<tr><th colspan="2">Plan y Manejo</th></tr>
<tr><td colspan="2">   

<table width="100%" > 
     <tr>
         <td> Plan y Manejo </br>
            <?php echo form_textarea(array('name' => 'plan_manejo',
                                            'id'=> 'plan_manejo',
                                            'autocomplete'=>'off',
	 'class'=>"fValidate['required']",'rows' => '10','cols'=> '80'));
             ?>
         </td>
     </tr>
</table>
    </td>
</tr>
<tr> 
    <td>
        <table>
            <tr><th colspan="2">Adjuntar Soporte </th></tr>
            <tr>
                 <td  class="campo">Archivo a ser adjuntado:</td>
    <td><input name="userfile" type="file" id="userfile"/>
    <br />    
    Solo se permiten archivos  con extensiones xls, xlsx, doc, docx, pdf, jpg, bmp y gif</td>
            </tr>
        </table>
    </td>
  </tr> 
  
                               
</table>
<center>
    
<?
$hidden = array('id_cita'=>$info_cita['id']);
echo form_hidden($hidden);
$data = array(  'name' => 'bv',
        'onclick' => 'regresar()',
        'value' => 'Volver',
        'type' =>'button');
echo form_input($data);
?>
    <input type='hidden' name='contador' id='contador'></input>
<?=form_submit('boton', 'Guardar')?>
<?=form_close();?>
</center>
</div>
<br />
</td></tr></table>
