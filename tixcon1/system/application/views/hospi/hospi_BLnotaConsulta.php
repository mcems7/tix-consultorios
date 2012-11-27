<?php
	$ca1 = 'width="20%"';
	$ca2 = 'width="80%"';
	$eliminado7_12=0;
	$eliminado13_18=0;
	$eliminado19_6=0;
	$administrado7_12=0;
	$administrado13_18=0;
	$administrado19_6=0;
	$balance7_12=0;
	$eliminado13_18=0;
	
	$administrado13_18=0;
	$administrado19_6=0;
	$eliminado19_6=0;
	
	$balance24=0;
	$eliminado24=0;
		
	$administrado24=0;
	
	
	// se trae el total de los liquidos administrados de 7 a 12
		
		if ($BL_Adm7_12!=0)
		{
			foreach ($BL_Adm7_12 as $item)
			{
			    $administrado7_12 = $item['liv']+$item['sng']+$item['via_oral'];
			}
			
		}
		
		//// se trae el total de los liquidos administrados de 13 a 18
		if ($BL_Adm13_18!=0)
		{
			foreach ($BL_Adm13_18 as $item)
			{
			    $administrado13_18 = $item['liv']+$item['sng']+$item['via_oral'];
			}
			
		}
		//// se trae el total de los liquidos administrados de 19 a 6
		
		if ($BL_Adm19_6!=0)
				{
			foreach ($BL_Adm19_6 as $item)
			{
			    $administrado19_6 = $item['liv']+$item['sng']+$item['via_oral'];
			}
			
		}
		
		// DATOS ELIMINADOS//
			// se trae el total de los liquidos eliminados de 7 a 12
		if ($BL_Eli7_12 !=0)
		{
			foreach ($BL_Eli7_12 as $item)
			{
			    $eliminado7_12 =-$item['drend'] -$item['drene'] -$item['storaxe'] -$item['storaxd']-$item['vomito']-$item['orina']-$item['otros']-$item['deposicion']-$item['sng'];
			   
			}
			
		}
		//// se trae el total de los liquidos eliminados de 13 a 18
		if ($BL_Eli13_18 !=0)
		{
			foreach ($BL_Eli13_18 as $item)
			{
			   $eliminado13_18 =-$item['drend'] -$item['drene'] -$item['storaxe'] -$item['storaxd']-$item['vomito']-$item['orina']-$item['otros']-$item['deposicion']-$item['sng'];
			  
			}
			
		}
		//// se trae el total de los liquidos eliminados de 19 a 6
		if ($BL_Eli19_6 !=0)
		{
			foreach ($BL_Eli19_6 as $item)
			{
			    $eliminado19_6 =-$item['drend'] -$item['drene'] -$item['storaxe'] -$item['storaxd']-$item['vomito']-$item['orina']-$item['otros']-$item['deposicion']-$item['sng'];
			    
			}
			
		}
		
		//// se trae el total de los liquidos eliminados del dia horas
		if ($BL_Eli24 !=0)
		{
			foreach ($BL_Eli24 as $item)
			{
			    $eliminado24 =-$item['drend'] -$item['drene'] -$item['storaxe'] -$item['storaxd']-$item['vomito']-$item['orina']-$item['otros']-$item['deposicion']-$item['sng'];
			    
			}
			
		}
		
	//// se trae el total de los liquidos eliminados del dia horas
		if ($BL_Adm24!=0)
				{
			foreach ($BL_Adm24 as $item)
			{
			    $administrado24 = $item['liv']+$item['sng']+$item['via_oral'];
			}
			
		}

//creamos el balance para el horario 7 - 12
$alerta7_12='background-color:';
$alerta13_18='background-color:';
$alerta19_6='background-color:';
$alerta24='background-color:';


$balance7_12=$administrado7_12+$eliminado7_12;
$balance13_18=$administrado13_18+$eliminado13_18;
$balance19_6=$administrado19_6+$eliminado19_6;
$balance24=$administrado24+$eliminado24;
if ($balance7_12 >0)
{
		$alerta7_12='background-color:#FF0000';	
}
if ($balance13_18 >0)
{
		$alerta13_18='background-color:#FF0000';	
}

if ($balance19_6 >0)
{
        $alerta19_6='background-color:#FF0000';	
}
if ($balance24 > 0)
{
		$alerta24='background-color:#FF0000';	
}
	
?>
<br />
<?php 
if($balance7_12!=0)
{

?>
<fieldset>
<legend>Horario 7 - 12</legend>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">

<tr>
 <td>
<div style="float:left; width:180px; margin:0" >
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th colspan="3" style="font-size:12px">Líquidos Administrados</th></tr>
<tr><td height="74"  class="campo">Vía Oral</td><td  class="campo">S.N.G.</td><td class="campo">LIV</td></tr>
<tr><td  class="campo"><?=$BL_Adm7_12[0]['via_oral']?></td><td class="campo"><?=$BL_Adm7_12[0]['sng']?></td><td class="campo"><?=$BL_Adm7_12[0]['liv']?></td></tr>
</table>



</div>
</td>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th align="center" colspan="9"  style="font-size:12px">Líquidos Eliminados</th></tr>
<tr><td height="74" class="campo">Orina</td><td class="campo">Deposición</td><td class="campo">Vómito</td><td class="campo">S.N.G.</td><td class="campo">Dren (E)</td><td class="campo">Dren (D)</td><td class="campo">Sello a tórax (E)</td><td class="campo">Sello a tórax (D)</td><td class="campo">Otros</td></tr>

<tr><td class="campo"><?=$BL_Eli7_12[0]['orina']?></td><td class="campo"><?=$BL_Eli7_12[0]['deposicion']?></td><td class="campo"><?=$BL_Eli7_12[0]['vomito']?></td><td class="campo"><?=$BL_Eli7_12[0]['sng']?></td><td class="campo"><?=$BL_Eli7_12[0]['drene']?></td><td class="campo"><?=$BL_Eli7_12[0]['drend']?></td><td class="campo"><?=$BL_Eli7_12[0]['storaxe']?></td><td class="campo"><?=$BL_Eli7_12[0]['storaxd']?></td><td class="campo"><?=$BL_Eli7_12[0]['otros']?></td></tr>


</table>
</td>
</tr>
<tr>
 <td colspan="2" align="center">
<table width="50%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><th align="center" colspan="3"  style="font-size:12px">Balance Horas de 7 - 12</th></tr>
<tr><td class="campo">Administados</td><td class="campo">Eliminados</td><td class="campo">Balance</td></tr>
<tr><td class="campo"><?=$administrado7_12?></td><td class="campo"><?=$eliminado7_12?></td><td class="campo"><?=$balance7_12?></td></tr>

</table>
</td></tr>

</table>
</fieldset>

<?php 
} 
if($balance13_18!=0)
{

?>
<tr><td class="linea_azul" colspan="2"></td></tr>
<br />
<fieldset>
<legend>Horario 13 - 18</legend>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">

<tr>
 <td>
<div style="float:left;  width:180px; margin:0" >
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th colspan="3" style="font-size:12px">Líquidos Administrados</th></tr>
<tr><td height="74" width="130" class="campo">Vía Oral</td><td class="campo">S.N.G.</td><td class="campo">LIV</td></tr>
  
  <td class="campo"><?=$BL_Adm13_18[0]['via_oral']?></td><td class="campo"><?=$BL_Adm13_18[0]['sng']?></td><td class="campo"><?=$BL_Adm13_18[0]['liv']?></td></tr>
</table>



</div>
</td>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th align="center" colspan="9"  style="font-size:12px">Líquidos Eliminados</th></tr>
<tr><td height="74" class="campo">Orina</td><td class="campo">Deposición</td><td class="campo">Vómito</td><td class="campo">S.N.G.</td><td class="campo">Dren (E)</td><td class="campo">Dren (D)</td><td class="campo">Sello a tórax (E)</td><td class="campo">Sello a tórax (D)</td><td class="campo">Otros</td></tr>

<tr><td class="campo"><?=$BL_Eli13_18[0]['orina']?></td><td class="campo"><?=$BL_Eli13_18[0]['deposicion']?></td><td class="campo"><?=$BL_Eli13_18[0]['vomito']?></td><td class="campo"><?=$BL_Eli13_18[0]['sng']?></td><td class="campo"><?=$BL_Eli13_18[0]['drene']?></td><td class="campo"><?=$BL_Eli13_18[0]['drend']?></td><td class="campo"><?=$BL_Eli13_18[0]['storaxe']?></td><td class="campo"><?=$BL_Eli13_18[0]['storaxd']?></td><td class="campo"><?=$BL_Eli13_18[0]['otros']?></td></tr>


</table>
</td></tr>
<tr>
  <td colspan="2" align="center">
<table width="50%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
  <th align="center" colspan="3"  style="font-size:12px">Balance Horas de 13 - 18</th></tr>
<tr><td class="campo">Administados</td><td class="campo">Eliminados</td><td class="campo">Balance</td></tr>
<tr><td class="campo"><?=$administrado13_18?></td><td class="campo"><?=$eliminado13_18?></td><td class="campo" ><?=$balance13_18?></td></tr>

</table>
</td></tr>
</table>
</fieldset>
<?php 
}
 
if($balance19_6!=0)
{

?>


<br />
<fieldset>
<legend>Horario 19 - 6</legend>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">

<tr>
 <td>
<div style="float:left; width:180px; margin:0" >
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th colspan="3" style="font-size:12px">Líquidos Administrados</th></tr>
<tr><td height="74" width="130" class="campo">Vía Oral</td><td class="campo">S.N.G.</td><td class="campo">LIV</td></tr>
<tr>
 
  <td class="campo"><?=$BL_Adm19_6[0]['via_oral']?></td><td class="campo"><?=$BL_Adm19_6[0]['sng']?></td><td class="campo"><?=$BL_Adm19_6[0]['liv']?></td></tr>
</table>

</div>
</td>
 <td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th align="center" colspan="9"  style="font-size:12px">Líquidos Eliminados</th></tr>
<tr><td height="74" class="campo">Orina</td><td class="campo">Deposición</td><td class="campo">Vómito</td><td class="campo">S.N.G.</td><td class="campo">Dren (E)</td><td class="campo">Dren (D)</td><td class="campo">Sello a tórax (E)</td><td class="campo">Sello a tórax (D)</td><td class="campo">Otros</td></tr>

<tr><td class="campo"><?=$BL_Eli19_6[0]['orina']?></td><td class="campo"><?=$BL_Eli19_6[0]['deposicion']?></td><td class="campo"><?=$BL_Eli19_6[0]['vomito']?></td><td class="campo"><?=$BL_Eli19_6[0]['sng']?></td><td class="campo"><?=$BL_Eli19_6[0]['drene']?></td><td class="campo"><?=$BL_Eli19_6[0]['drend']?></td><td class="campo"><?=$BL_Eli19_6[0]['storaxe']?></td><td class="campo"><?=$BL_Eli19_6[0]['storaxd']?></td><td class="campo"><?=$BL_Eli19_6[0]['otros']?></td></tr>


</table>
 </td></tr>
 <tr>
 <td colspan="2" align="center">
<table width="50%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
  <th align="center" colspan="3"  style="font-size:12px">Balance Horas de 19 - 6</th></tr>
<tr><td class="campo">Administados</td><td class="campo">Eliminados</td><td class="campo">Balance</td></tr>
<tr><td class="campo"><?=$administrado19_6?></td><td class="campo"><?=$eliminado19_6?></td><td class="campo" ><?=$balance19_6?></td></tr>

</table>
</td></tr>
</table>
</fieldset>
<?php 
}

?>
<br />
<fieldset>
<legend>24 Horas </legend>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">

<tr>
 <td>&nbsp;</td>
 <td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">





</table>
 </td></tr>
 <tr>
 <td colspan="2" align="center">
<table width="50%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
  <th align="center" colspan="3"  style="font-size:12px">Balance 24 Horas</th></tr>
<tr><td class="campo">Administados</td><td class="campo">Eliminados</td><td class="campo">Balance</td></tr>
<tr><td class="campo"><?=$administrado24?></td><td class="campo"><?=$eliminado24?></td><td class="campo" style="<?=$alerta24?>"><?=$balance24?></td></tr>

</table>
</td></tr>
</table>
</fieldset>





<?php $data = array(	'name' => 'bv',
				'onclick' => 'resetDiv()',
				'value' => 'Cerrar',
				'type' =>'button');
echo form_input($data);

$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/hospi_impresion/consultaBalancelEnfermeria/'.$id_atencion.'/'.$fecha_nota)."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
