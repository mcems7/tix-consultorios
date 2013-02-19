<?php $this -> load -> view('impresion/inicio'); ?>

<h4>Servicio de hospitalización - Balance de Liquidos</h4>
<h5>Datos del paciente</h5>
<table id="interna">
  <tr>
    <td class="negrita">Apellidos:</td>
    <td class="centrado"><?=$tercero['primer_apellido'].' '.$tercero['segundo_apellido']?></td>
    <td class="negrita">Nombres:</td>
    <td class="centrado"><?=$tercero['primer_nombre'].' '.$tercero['segundo_nombre']?></td>
  </tr>
  <tr>
    <td class="negrita">Documento de identidad:</td>
    <td class="centrado"><?=$tercero['tipo_documento'].' '.$tercero['numero_documento']?></td>
    <td class="negrita">G&eacute;nero:</td>
    <td class="centrado"><?=$paciente['genero']?></td>
  </tr>
  <tr>
    <td class="negrita">Fecha de nacimiento:</td>
    <td class="centrado"><?=$tercero['fecha_nacimiento']?></td>
    <td class="negrita">Edad:</td>
    <td class="centrado"><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td>
  </tr>
   <tr>
    <td class="negrita">Fecha :</td>
    <td class="centrado" colspan="3"><?=$evo[0]['fecha_nota']?></td>
    </tr>
</table>


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

<?php 
if($balance7_12!=0)
{

?>
<fieldset>
<legend>Horario 7 - 12</legend>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr>
<td>
<table id="interna" border="1" bordercolor="#000000" style="background-color:" width="100%" cellpadding="1" cellspacing="1">

<tr>
		<td colspan="3" align="center" style="font-weight:bold">Líquidos Administrados</td>
		<td colspan="9" align="center" style="font-weight:bold">Líquidos Eliminados</td>
		
	</tr>	 
<tr>
		<td class="campo">Vía Oral</td>
		<td class="campo">S.N.G.</td>
		<td class="campo">LIV</td>
		<td class="campo">Orina</td>
        <td class="campo">Deposición</td>
        <td class="campo">Vómito</td>
        <td class="campo">S.N.G</td>
        <td class="campo">Dren (E)</td>
        <td class="campo">Dren (D)</td>
        <td class="campo">Sello a tórax (E)</td>
        <td class="campo">Sello a tórax (D)</td>
        <td class="campo">Otros</td>
	</tr>
	<tr>
		<td class="campo" align="center"><?=$BL_Adm7_12[0]['via_oral']?></td>
        <td class="campo" align="center"><?=$BL_Adm7_12[0]['sng']?></td>
        <td class="campo" align="center"><?=$BL_Adm7_12[0]['liv']?></td>
		<td class="campo" align="center"><?=$BL_Eli7_12[0]['orina']?></td>
        <td class="campo" align="center"><?=$BL_Eli7_12[0]['deposicion']?></td>
        <td class="campo" align="center"><?=$BL_Eli7_12[0]['vomito']?></td>
        <td class="campo" align="center"><?=$BL_Eli7_12[0]['sng']?></td>
        <td class="campo" align="center"><?=$BL_Eli7_12[0]['drene']?></td>
        <td class="campo" align="center"><?=$BL_Eli7_12[0]['drend']?></td>
        <td class="campo" align="center"><?=$BL_Eli7_12[0]['storaxe']?></td>
        <td class="campo" align="center"><?=$BL_Eli7_12[0]['storaxd']?></td>
        <td class="campo" align="center"><?=$BL_Eli7_12[0]['otros']?></td>
	</tr>
</table>
</td>
</tr>

<tr>
  <td colspan="2" align="center">
<table width="50%" border="1" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
  <th align="center" colspan="3"  style="font-size:12px">Balance Horas de 13 - 18</th></tr>
<tr><td class="campo">Administados</td><td class="campo">Eliminados</td><td class="campo">Balance</td></tr>
<tr><td class="campo" align="center"><?=$administrado7_12?></td><td class="campo" align="center"><?=$eliminado7_12?></td><td class="campo" style="font-weight:bold; font-size:16px" align="center" ><?=$balance7_12?></td></tr>

</table>
</td></tr>
</table>
</fieldset>

<?php 
} 
if($balance13_18!=0)
{

?>
<br />
<fieldset>
<legend>Horario 13 - 18</legend>
<table  width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr>
<td>
<table id="interna" border="1" bordercolor="#000000" style= width="100%" cellpadding="1" cellspacing="1">

<tr>
		<td colspan="3" align="center" style="font-weight:bold">Líquidos Administrados</td>
		<td colspan="9" align="center" style="font-weight:bold">Líquidos Eliminados</td>
		
	</tr>	 
<tr>
		<td class="campo">Vía Oral</td>
		<td class="campo">S.N.G.</td>
		<td class="campo">LIV</td>
		<td class="campo">Orina</td>
        <td class="campo">Deposición</td>
        <td class="campo">Vómito</td>
        <td class="campo">S.N.G</td>
        <td class="campo">Dren (E)</td>
        <td class="campo">Dren (D)</td>
        <td class="campo">Sello a tórax (E)</td>
        <td class="campo">Sello a tórax (D)</td>
        <td class="campo">Otros</td>
	</tr>
	<tr>
		<td class="campo" align="center"><?=$BL_Adm13_18[0]['via_oral']?></td>
        <td class="campo" align="center"><?=$BL_Adm13_18[0]['sng']?></td>
        <td class="campo" align="center"><?=$BL_Adm13_18[0]['liv']?></td>
		<td class="campo" align="center"><?=$BL_Eli13_18[0]['orina']?></td>
        <td class="campo" align="center"><?=$BL_Eli13_18[0]['deposicion']?></td>
        <td class="campo" align="center"><?=$BL_Eli13_18[0]['vomito']?></td>
        <td class="campo" align="center"><?=$BL_Eli13_18[0]['sng']?></td>
        <td class="campo" align="center"><?=$BL_Eli13_18[0]['drene']?></td>
        <td class="campo" align="center"><?=$BL_Eli13_18[0]['drend']?></td>
        <td class="campo" align="center"><?=$BL_Eli13_18[0]['storaxe']?></td>
        <td class="campo" align="center"><?=$BL_Eli13_18[0]['storaxd']?></td>
        <td class="campo" align="center"><?=$BL_Eli13_18[0]['otros']?></td>
	</tr>
</table>
</td>
</tr>

<tr>
  <td colspan="2" align="center">
<table width="50%" border="1" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
  <th align="center" colspan="3"  style="font-size:12px; font-weight:bold">Balance Horas de 13 - 18</th></tr>
<tr><td class="campo">Administados</td><td class="campo">Eliminados</td><td class="campo">Balance</td></tr>
<tr><td class="campo" align="center"><?=$administrado13_18?></td><td class="campo" align="center"><?=$eliminado13_18?></td><td class="campo" style="font-weight:bold; font-size:16px" align="center"><?=$balance13_18?></td></tr>

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
<table id="interna" border="1" bordercolor="#000000" style="background-color:" width="100%" cellpadding="1" cellspacing="1">

<tr>
		<td colspan="3" align="center" style="font-weight:bold">Líquidos Administrados</td>
		<td colspan="9" align="center" style="font-weight:bold">Líquidos Eliminados</td>
		
	</tr>	 
<tr>
		<td class="campo">Vía Oral</td>
		<td class="campo">S.N.G.</td>
		<td class="campo">LIV</td>
		<td class="campo">Orina</td>
        <td class="campo">Deposición</td>
        <td class="campo">Vómito</td>
        <td class="campo">S.N.G</td>
        <td class="campo">Dren (E)</td>
        <td class="campo">Dren (D)</td>
        <td class="campo">Sello a tórax (E)</td>
        <td class="campo">Sello a tórax (D)</td>
        <td class="campo">Otros</td>
	</tr>
	<tr>
		<td class="campo" align="center"><?=$BL_Adm19_6[0]['via_oral']?></td>
        <td class="campo" align="center"><?=$BL_Adm19_6[0]['sng']?></td>
        <td class="campo" align="center"><?=$BL_Adm19_6[0]['liv']?></td>
		<td class="campo" align="center"><?=$BL_Eli19_6[0]['orina']?></td>
        <td class="campo" align="center"><?=$BL_Eli19_6[0]['deposicion']?></td>
        <td class="campo" align="center"><?=$BL_Eli19_6[0]['vomito']?></td>
        <td class="campo" align="center"><?=$BL_Eli19_6[0]['sng']?></td>
        <td class="campo" align="center"><?=$BL_Eli19_6[0]['drene']?></td>
        <td class="campo" align="center"><?=$BL_Eli19_6[0]['drend']?></td>
        <td class="campo" align="center"><?=$BL_Eli19_6[0]['storaxe']?></td>
        <td class="campo" align="center"><?=$BL_Eli19_6[0]['storaxd']?></td>
        <td class="campo" align="center"><?=$BL_Eli19_6[0]['otros']?></td>
	</tr>
    
</table>

</td>
</tr>

<tr>
  <td colspan="2" align="center">
<table width="50%" border="1" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
  <th align="center" colspan="3"  style="font-size:12px">Balance Horas de 19 - 6</th></tr>
<tr><td class="campo">Administados</td><td class="campo">Eliminados</td><td class="campo">Balance</td></tr>
<tr><td class="campo" align="center"><?=$administrado19_6?></td><td class="campo" align="center"><?=$eliminado19_6?></td><td class="campo" style="font-weight:bold; font-size:16px" align="center" ><?=$balance19_6?></td></tr>

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
 <td colspan="2" align="center">
<table width="50%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
  <th align="center" colspan="3"  style="font-size:18px; font-weight:bold">Balance 24 Horas</th></tr>
<tr><td class="campo">Administados</td><td class="campo">Eliminados</td><td class="campo">Balance</td></tr>
<tr><td class="campo"><?=$administrado24?></td><td class="campo"><?=$eliminado24?></td><td class="campo" style="font-weight:bold; font-size:18px"><?=$balance24?></td></tr>

</table>
</td></tr>
</table>
</fieldset>



<?php $this -> load -> view('impresion/fin'); ?>