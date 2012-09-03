<script type="text/javascript">
var slidePaciente = null;
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
  
	slidePaciente = new Fx.Slide('div_paciente');
	slidePaciente.hide();
	

	$('v_ampliar').addEvent('click', function(e){
			e.stop();
			slidePaciente.toggle();
	});		
	
	$('v_ocultar').addEvent('click', function(e){
			e.stop();
			slidePaciente.toggle();
	});			 
});
////////////////////////////////////////////////////////////////////////////////
function resetDiv()
{
	$('con_evo').set('html','');
}
////////////////////////////////////////////////////////////////////////////////
function consultaEvo(id_evo)
{
	var var_url = '<?=site_url()?>/urg/observacion/consultaEvolucion/'+id_evo;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('con_evo').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Facturacion</h1>
<h2 class="subtitulo">Numero de factura <?=$factura_detalles[0]['factura_detalle']." ".$factura_detalles[0]['factura_numero']?></h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">
<tr><td width="40%" class="campo">Apellidos:</td>
<td width="60%"><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td></tr>
<tr><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td></tr>
<tr><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Entidad:</td><td><?php 
if(isset($entidad['razon_social']))
	echo $entidad['razon_social'];

?></td></tr>
</table>
</td></tr>
<tr><td colspan="2" class="linea_azul">
<span class="texto_barra">
<a href="#"  id="v_ampliar" title="Ampliar la informaci&oacute;n del paciente">
Ampliar la informaci&oacute;n del paciente
<img src="<?=base_url()?>resources/img/triangulo.png"/></a></span>
</td></tr>
<tr><td colspan="2">
<div id="div_paciente">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">
<tr><td class="campo" width="40%">Pa&iacute;s:</td><td width="60%"><?=$tercero['PAI_NOMBRE']?></td></tr>
<tr><td class="campo">Departamento:</td><td><?=$tercero['depa']?></td></tr>
<tr><td class="campo">Municipio:</td><td><?=$tercero['nombre']?></td></tr>
<tr><td class="campo">Barrio / Vereda:</td><td><?=$tercero['vereda']?></td></tr>
<tr><td class="campo">Zona:</td><td><?=$tercero['zona']?></td></tr>
<tr><td class="campo">Direcci&oacute;n:</td><td><?=$tercero['direccion']?></td></tr>
<tr><td class="campo">Teléfono:</td><td><?=$tercero['telefono']?></td></tr>
<tr><td class="campo">Celular:</td><td><?=$tercero['celular']?></td></tr>
<tr><td class="campo">Fax:</td><td><?=$tercero['fax']?></td></tr>
<tr><td class="campo">Correo electrónico:</td><td><?=$tercero['email']?></td></tr>
<tr><td class="campo">Observaciones:</td><td><?=$tercero['observaciones']?></td></tr>
<tr><td class="campo">Tipo usuario:</td><td>
<?
	foreach($tipo_usuario as $d)
	{
		if($paciente['id_cobertura'] == $d['id_cobertura'])
		{
			echo $d['cobertura'];
		}
	}
?>
</td></tr>
<tr><td class="campo">Tipo de afiliado:</td><td><?=$paciente['tipo_afiliado']?></td></tr>
<tr><td class="campo">Nivel o categoria:</td><td>
 <?=$paciente['nivel_categoria']?></td></tr>
<tr><td class="campo">Desplazado:</td><td> <?=$paciente['desplazado']?></td></tr>
<tr><td class="campo">Observaciones:</td><td><?=$paciente['observaciones']?></td></tr>
</table>
<p class="linea_azul">
<span class="texto_barra">
<a href="#"  id="v_ocultar" title="Ocultar la informaci&oacute;n del paciente">
Ocultar la informaci&oacute;n del paciente
<img src="<?=base_url()?>resources/img/triangulo.png"/></a></span>
</p>
</div>
</td></tr>

 

  
 <tr>
  <th colspan="2">Procedimientos y ayudas diagnósticas</th></tr>
<tr>
<tr>
  <td colspan="2">
  <div id="div_lista_procedimientos">

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
   
    <td class="campo_centro">Procedimiento</td>
    <td class="campo_centro">Cantidad</td>
     <td class="campo_centro">Valor</td>
      <td class="campo_centro">Total</td>
    
</tr>


  
  
  
<?php
$facturatotal =0;
$facturaunidad =0;

if ($facProcedimiento !=0)
{	
	$total=0;
foreach($facProcedimiento as $d)
	{
				$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		//$valorventa = $this->factura_model->obtenerValor($d['cups']);
		
		
		?>
    <tr>

<td><?=$d['procedimiento'];?></td>
<td><?=$d['cantidad'];?></td>
<td><?=$d['valor_unidad'];?></td>
<td><?=$d['valor_total'];?></td>

</tr>
<?php
$facturaunidad =$facturaunidad+$d['valor_unidad'];
$facturatotal =$facturatotal+$d['valor_total'];
}
	}
	
	
if ($facProcedimientoUvr !=0)

{	
	$total=0;
foreach($facProcedimientoUvr as $d)
	{
				$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		//$valorventa = $this->factura_model->obtenerValor($d['cups']);
		
	
		?>
    <tr>

<td><?=$d['procedimiento'];?></td>
<td><?=$d['cantidad'];?></td>
<td><?=$d['valor_unidad'];?></td>
<td><?=$d['valor_total'];?></td>

</tr>
<?php
$facturaunidad =$facturaunidad+$d['valor_unidad'];
$facturatotal =$facturatotal+$d['valor_total'];
}
	}	


	
if ($facCupsLaboratorios !=0)
{	
	$total=0;
foreach($facCupsLaboratorios as $d)
	{
				$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
	//	$valorventa = $this->factura_model->obtenerValor($d['cups']);
		
		
		?>
    <tr>

<td><?=$d['procedimiento'];?></td>
<td><?=$d['cantidad'];?></td>
<td><?=$d['valor_unidad'];?></td>
<td><?=$d['valor_total'];?></td>

</tr>
<?php
$facturaunidad =$facturaunidad+$d['valor_unidad'];
$facturatotal =$facturatotal+$d['valor_total'];
}
	}

if ($facCupsImagenes != 0 )
{
foreach($facCupsImagenes as $d)
	{
				$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
					//$valorventa = $this->factura_model->obtenerValor($d['cups']);
		
		
		
		?>
    <tr>

	<td><?=$d['procedimiento'];?></td>
<td><?=$d['cantidad'];?></td>
<td><?=$d['valor_unidad'];?></td>
<td><?=$d['valor_total'];?></td>

</tr>

<?php
$facturaunidad =$facturaunidad+$d['valor_unidad'];
$facturatotal =$facturatotal+$d['valor_total'];
}
	}

?>
</table> 
  </div>
  </td></tr>
  
  <tr><th colspan="2">Total</th></tr>
  <tr>
  <td class="campo_centro">Valor</td>
      <td class="campo_centro">Total</td>
  </tr>
  <tr>
  <td class="campo_centro"><?=$facturaunidad;?></td>
<td class="campo_centro"><?=$facturatotal;?></td>
  </tr>
<tr><th colspan="2">Responsable</th></tr>

<tr>
<td class="campo">Persona que realiza la factura:</td>
<td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo">Código:</td>
<td><?=$medico['tarjeta_profesional']?></td></tr>

<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data),nbs();
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresion/consultaremision/'.$atencion['id_atencion'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</center>
</div>
<br />
</td></tr></table>