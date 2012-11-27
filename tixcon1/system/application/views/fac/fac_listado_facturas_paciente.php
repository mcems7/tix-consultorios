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

<center>
<table width="95%" class="tabla_form">
<tr><td>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">

</table>
</td></tr>

</table>
</td></tr>

 

  
 <tr>
  <th colspan="2">Facturas generadas</th></tr>
<tr>
<tr>
  <td colspan="2">

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
   
    <td class="campo_centro">Contrato</td>
     <td class="campo_centro">Fecha</td>
      <td class="campo_centro">Factura No</td>
    
</tr>


  
  
  
<?php


if ($factura !=0)
{	
	//print_r($factura);
foreach($factura as $item)
	{
	
	$d['det_contrato'] = $this->factura_model->obtenerDatosContrato($item[0]['id_contrato']);
		
	
		
		?>
    <tr>

<td><?=$d['det_contrato'][0]['nombre_contrato'];?></td>
<td><?=$item[0]['fecha']?></td>
<td><strong><?=anchor('/fac/consultar_facturas/consultarFactura/'.$item[0]['id_atencion'].'/'.$item[0]['id_contrato'],$item[0]['factura_detalle']." ".$item[0]['factura_numero']);?></strong></td>


</tr>
<?php

}
	}
?>
	

</table> 
  </div>
  </td></tr>
  
 


<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data),nbs();


?>
</center>
</div>
<br />
</td></tr></table>