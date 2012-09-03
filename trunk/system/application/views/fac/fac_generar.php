<script type="text/javascript">
var valores=[];
var uvrcirujano=[];
var slidePaciente = null;

//////////////////////////////////////////////////////////////////////////////////

function resetDiv()
{
	//$('con_evo').innerHTML = "";	
	$('con_evo').set('html','');
}
////////////////////////////////////////////////////////////////////////////////


function ValorUvrCirujano(id,uvr,id_concepto,check,cantidad)
{
	var var_url = '<?=site_url()?>/fac/factura/ValorUvrCirujano/'+id_concepto;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){
			},
		onSuccess: function(html){
		var valor_cirujano = parseInt(html) * parseInt(uvr);
			if (check.checked==true){ 
			
				var suma = parseInt(valor_cirujano) + parseInt($(''+id+'').innerHTML);
			$(''+id+'').set('html',suma)
			   var total = (parseInt(valor_cirujano)*parseInt(cantidad)) + parseInt($('t'+id+'').innerHTML);
			$('t'+id+'').set('html',total)
			
			
				}else{
					
			var suma = -parseInt(valor_cirujano) + parseInt($(''+id+'').innerHTML);
			$(''+id+'').set('html',suma)
			var total = -(parseInt(valor_cirujano)*parseInt(cantidad)) + parseInt($('t'+id+'').innerHTML);
			$('t'+id+'').set('html',total)
			
					}
			
			
			valores[id]=html;
			var uvrcirujano=[]; 
			uvrcirujano[id]=valor_cirujano;
			

		 
		 
		},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}

////////////////////////////////////////////////////////////////////////////////

function ValorUvrAnesteciologo(id,uvr,id_concepto,check,cantidad)
{
	var var_url = '<?=site_url()?>/fac/factura/ValorUvrAnesteciologo/'+id_concepto;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){
			},
		onSuccess: function(html){
		var valor_anesteciologo = parseInt(html) * parseInt(uvr);
		if (check.checked==true){ 
				
				var suma = parseInt(valor_anesteciologo) + parseInt($(''+id+'').innerHTML);
			$(''+id+'').set('html',suma);
				var total = (parseInt(valor_anesteciologo)*parseInt(cantidad)) + parseInt($('t'+id+'').innerHTML);
			$('t'+id+'').set('html',total);
				}else{
					
			var suma = -parseInt(valor_anesteciologo) + parseInt($(''+id+'').innerHTML);
			$(''+id+'').set('html',suma)
				var total = -(parseInt(valor_anesteciologo)*parseInt(cantidad)) + parseInt($('t'+id+'').innerHTML);
			$('t'+id+'').set('html',total)
					}
			valores[id]=valor_anesteciologo;
			
		},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////

function ValorUvrAyudante(id,uvr,id_concepto,check,cantidad)
{
	var var_url = '<?=site_url()?>/fac/factura/ValorUvrAnesteciologo/'+id_concepto;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){
			},
		onSuccess: function(html){
			
			var valor_ayudante = parseInt(html) * parseInt(uvr);
			if (check.checked==true){ 
				
				var suma = parseInt(valor_ayudante) + parseInt($(''+id+'').innerHTML);
			$(''+id+'').set('html',suma)
			var total = (parseInt(valor_ayudante)*parseInt(cantidad)) + parseInt($('t'+id+'').innerHTML);
			$('t'+id+'').set('html',total)
				}else{
					
			var suma = -parseInt(valor_ayudante) + parseInt($(''+id+'').innerHTML);
			$(''+id+'').set('html',suma)
			var total = -(parseInt(valor_ayudante)*parseInt(cantidad)) + parseInt($('t'+id+'').innerHTML);
			$('t'+id+'').set('html',total)
					}
			valores[id]=valor_ayudante;
			
		},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////

function ValorUvrSala(id,uvr,id_concepto,check,cantidad)
{
	var var_url = '<?=site_url()?>/fac/factura/ValorUvrSala/'+uvr;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){
			},
		onSuccess: function(html){
			if (check.checked==true){ 
				
				var suma = parseInt(html) + parseInt($(''+id+'').innerHTML);
			$(''+id+'').set('html',suma)
			var total = (parseInt(html)*parseInt(cantidad)) + parseInt($('t'+id+'').innerHTML);
			$('t'+id+'').set('html',total)
			
				}else{
					
			var suma = -parseInt(html) + parseInt($(''+id+'').innerHTML);
			$(''+id+'').set('html',suma)
			var total = -(parseInt(html)*parseInt(cantidad)) + parseInt($('t'+id+'').innerHTML);
			$('t'+id+'').set('html',total)
		
					}
			valores[id]=html;
			
		},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////

function ValorUvrMateriales(id,uvr,id_concepto,check,cantidad)
{
	var var_url = '<?=site_url()?>/fac/factura/ValorUvrMateriales/'+uvr;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){
			},
		onSuccess: function(html){
			if (check.checked==true){ 
				
				var suma = parseInt(html) + parseInt($(''+id+'').innerHTML);
			$(''+id+'').set('html',suma)
			var total = (parseInt(html)*parseInt(cantidad)) + parseInt($('t'+id+'').innerHTML);
			$('t'+id+'').set('html',total)
				}else{
					
			var suma = -parseInt(html) + parseInt($(''+id+'').innerHTML);
			$(''+id+'').set('html',suma)
			var total = -(parseInt(html)*parseInt(cantidad)) + parseInt($('t'+id+'').innerHTML);
			$('t'+id+'').set('html',total)
			
					}
			valores[id]=html;
			
			
			if (html == 0)
			{
				alert('Los materiales para este procedimiento se deben asignar manualmente');
			}
		},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////


function regresar()
{
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 
 	 var exValidatorA = new fValidator("formulario");
	
	var valores=[];
	 
});

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	
	
	if(confirm("Esta seguro de guardar la información??")){
		return true;
		}else{
		return false;
		}
}
////////////////////////////////////////////////////////////////////////////////



</script>


<h1 class="tituloppal">Facturación </h1>
<h2 class="subtitulo">Generar factura</h2>
<center>
<?php
$lista['contratos']=$this->factura_model->ListadoContratos();

$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/fac/factura/factura_',$attributes);
$fecha_egreso = date('Y-m-d H:i:s');
echo form_hidden('fecha',$fecha_egreso);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('plantilla',$plantilla);
echo form_hidden('id_contrato',$contrato);
?>
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
<tr><td class="campo">Género:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Entidad:</td><td><?php 
if(isset($entidad['razon_social']))
	echo $entidad['razon_social'];

?></td></tr>
</table>
</td></tr>
<tr><td colspan="2" class="linea_azul">
<span class="texto_barra">

</td></tr>

<tr><th colspan="2">Atenci&oacute;n del paciente</th></tr>
<tr><td class="campo">Fecha y hora de ingreso:</td><td><?=$atencion['fecha_ingreso']?></td></tr>
<tr><td class="campo">Servicio de ingreso:</td><td><?=$atencion['nombre_servicio']?></td></tr>
<tr><td class="campo">Fecha y hora de egreso:</td><td><?=$fecha_egreso?></td></tr>
<tr><td class="campo">Servicio de egreso:</td><td>
<?php
$servicio = $this->urgencias_model->obtenerInfoServicio($atencion['id_servicio']);
echo $servicio['nombre_servicio'];
?></td></tr>
<tr>
  <th colspan="2">Medicamentos</th></tr>
<tr>
<tr>
  <td colspan="2">
  <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
<td class="campo_centro">Cobrar</td>
<td class="campo_centro">Medicamento</td>

<td class="campo_centro">Dosis</td>
<td class="campo_centro">Unidad</td>

<td class="campo_centro">Vía</td>
</tr>

  
  
<?php

if ($ordenMedi != 0)
{
	foreach($ordenMedi as $d)
	{
		$d['via'] = $this->urgencias_model->obtenerValorVarMedi($d['id_via']);
		
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia']);
		
		$d['unidad'] = $this->urgencias_model->obtenerValorVarMedi($d['id_unidad']);
		
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc']);
		
?>
<tr>
<td>
	<input name="medicamento[]" id="medicamento[]" type="checkbox" value="<?=$d['id']?>" />
	</td>
<td><?=$d['medicamento']?></td>

<td align="center"><?=$d['dosis']?></td>
<td align="center"><?=$d['unidad']?></td>

<td align="center"><?=$d['via']?></td>
</tr>
	
		
		
<?php		
	}
}
?>  
  </table>

<tr>
  <th colspan="2">Insumos y dispositivos médicos</th></tr>
<tr>
<tr>
  <td colspan="2">
  <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
    <td class="campo_centro">Cobrar</td>
 <td class="campo_centro">Insumo</td>
<td class="campo_centro">Cantidad</td>
    
</tr>
<?php

	if($ordenInsumos!=0)
	{	
		
			foreach($ordenInsumos as $d)
			{
				?>
			<tr>
<td>
	<input name="insumo[]" id="insumo[]" type="checkbox" value="<?=$d['id_insumo']?>" />
	</td>
<td><?=$d['insumo']?></td>

<td align="center"><?=$d['cantidad']?></td>
</tr>
			<?php 
			
			}
	}
?>  
</table>
  </td></tr> 



<tr>
  <th colspan="2">Procedimientos y ayudas diagnósticas</th></tr>
<tr>
<tr>
  <td colspan="2">
  <div id="div_lista_procedimientos">

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
    <td class="campo_centro">Cobrar</td>
     <td class="campo_centro">Otro pagador</td>
    <td class="campo_centro">Procedimiento</td>
    <td class="campo_centro">Cantidad</td>
     <td class="campo_centro">Valor</td>
      <td class="campo_centro">Total</td>
    
</tr>


  
  
  
<?php
if ($ordenCups != 0)
{
	
		
		foreach($ordenCups as $d)
		{
			$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
			
			$valorventa = $this->factura_model->obtenerValor($d['cups'],$plantilla);
			if($valorventa==0){
							
			$valoruvr = $this->factura_model->obtenerUvr($d['cups']);	
				}
		   	$uvr = $this->factura_model->obtenerUvr($d['cups']);
	
			
			$total= $valorventa * $d['cantidadCups'];
			
		if ($uvr == 0){
?>

		<tr>
	<td rowspan="2">
	<input name="ordenCups[]" id="ordenCups[]" type="checkbox" value="<?=$d['id']?>" />
	</td>
    <td><select name="PagadorProcedimiento[<?=$d['id']?>]" id="PagadorProcedimiento[<?=$d['id']?>]" >
    <option value="0">-Seleccionar-</option>
<?php

foreach($lista['contratos'] as $dato)
{
		echo '<option value="'.$dato['codigo_contrato'].'" >'.$dato['nombre_contrato'].'</option>';
}
?>      
    </select></td>
	<td><?=$d['procedimiento'];?></td>
<td rowspan="2"><?=$d['cantidadCups'];?></td>
<td><?=$valorventa;?></td>

<td><?=$total;?></td>
	</tr>
    <tr>
  </tr>
	<?php
		}else{
	?>		
		<tr>
	<td rowspan="2">
	<input name="ordenProcedimientoUvr[]" id="ordenProcedimientoUvr[]" type="checkbox" value="<?=$d['id']?>" />
	</td>
    <td rowspan="2"><select name="PagadorProcedimientoUvr[<?=$d['id']?>]" id="PagadorProcedimientoUvr[<?=$d['id']?>]">
    <option value="0">-Seleccionar</option>
<?php


foreach($lista['contratos'] as $dato)
{
		echo '<option value="'.$dato['codigo_contrato'].'">'.$dato['nombre_contrato'].'</option>';
}
?>  
    
    </select></td>
	<td><?=$d['procedimiento'];?></td>
<td rowspan="2"><?=$d['cantidadCups'];?></td>
<td id='<?=$d['id']?>' rowspan="2"><?=$valorventa;?></td>

<td id='t<?=$d['id']?>' rowspan="2"><?=$total;?></td>
	</tr>
    <tr>
    <td>Cx<input name="ValorUvrCirujano[]" id="checkcir<?=$d['id']?>" onclick="ValorUvrCirujano(<?=$d['id']?>,<?=$uvr?>,1,checkcir<?=$d['id']?>,<?=$d['cantidadCups']?>)" type="checkbox" value="<?=$d['id']?>" /> 
    Anest <input name="ValorUvrAnesteciologo[]" onclick="ValorUvrAnesteciologo(<?=$d['id']?>,<?=$uvr?>,2,checkanest<?=$d['id']?>,<?=$d['cantidadCups']?>)"id="checkanest<?=$d['id']?>" type="checkbox" value="<?=$d['id']?>" />
     Ayu <input name="ValorUvrAyudante[]" id="checkayu<?=$d['id']?>" onclick="ValorUvrAyudante(<?=$d['id']?>,<?=$uvr?>,3,checkayu<?=$d['id']?>,<?=$d['cantidadCups']?>)" type="checkbox" value="<?=$d['id']?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Sala <input name="ValorUvrSala[]" id="checksala<?=$d['id']?>" onclick="ValorUvrSala(<?=$d['id']?>,<?=$uvr?>,3,checksala<?=$d['id']?>,<?=$d['cantidadCups']?>)" type="checkbox" value="<?=$d['id']?>" />
        
              Materiales <input name="ValorUvrMateriales[]" id="checkmateriales<?=$d['id']?>" onclick="ValorUvrMateriales(<?=$d['id']?>,<?=$uvr?>,3,checkmateriales<?=$d['id']?>,<?=$d['cantidadCups']?>)" type="checkbox" value="<?=$d['id']?>" />
     </td>
  </tr>	
			
	<?php		
			}
		}
}
	
if ($ordenCupsLaboratorios !=0)
{	
	$total=0;
foreach($ordenCupsLaboratorios as $d)
	{
				$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		$valorventa = $this->factura_model->obtenerValor($d['cups'],$plantilla);
		
		$total= $valorventa * $d['cantidadCups'];
		?>
    <tr>
<td>
<input name="ordenCupsLaboratorios[]" id="ordenCupsLaboratorios[]" type="checkbox" value="<?=$d['id']?>" />
</td>
<td><select name="pagadorlaboratorio" id="pagadorlaboratorio">
    <option value="0">-Seleccionar-</option>
<?php


foreach($lista['contratos'] as $dato)
{
		echo '<option value="'.$dato['codigo_contrato'].'" >'.$dato['nombre_contrato'].'</option>';
}
?>      
    </select></td>
<td><?=$d['procedimiento'];?></td>
<td><?=$d['cantidadCups'];?></td>
<td><?=$valorventa;?></td>
<td><?=$total;?></td>

</tr>
<?php
}
	}

if ($ordenCupsImagenes != 0 )
{
foreach($ordenCupsImagenes as $d)
	{
				$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
					$valorventa = $this->factura_model->obtenerValor($d['cups'],$plantilla);
		
		$total= $valorventa * $d['cantidadCups'];
		
		?>
    <tr>
<td>
<input name="ordenCupsImagenes[]" id="ordenCupsImagenes[]" type="checkbox" value="<?=$d['id']?>" />
</td>
<td><select name="pagadorimagenes[<?=$d['id']?>]" id="pagadorimagenes[<?=$d['id']?>]">
    <option value="0">-Seleccionar-</option>
    
<?php


foreach($lista['contratos'] as $dato)
{
		echo '<option value="'.$dato['codigo_contrato'].'" >'.$dato['nombre_contrato'].'</option>';
}
?>      
    </select></td>
	<td><?=$d['procedimiento'];?></td>
<td><?=$d['cantidadCups'];?></td>
<td><?=$valorventa;?></td>
<td><?=$total;?></td>

</tr>
<?php
}
	}

?>
</table> 
  </div>
  </td></tr>
 

<tr><th colspan="2">Responsable</th></tr>

<tr>
<td class="campo">Persona que realiza la factura:</td>
<td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo">Código:</td>
<td><?=$medico['tarjeta_profesional']?></td></tr>
<tr>
  <td class="campo">Fecha y hora factura:</td>
<td><?=$fecha_egreso?></td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<br />
<?=form_close();?>
</td></tr></table>
