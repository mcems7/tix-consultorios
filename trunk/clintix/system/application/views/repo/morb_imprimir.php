<?php $this -> load -> view('impresion/inicio'); ?>
<h4>Servicio de Urgencias - Reporte morbilidad</h4>
<table id="interna">
  <tr>
    <td class="negrita">Servicio:</td>
    <td class="centrado">
	<?php
		if($servicio == 0){
			echo 'TODOS';
		}else if($servicio == 1){
			echo 'Adultos';
		}else if($servicio == 2){
			echo 'Pediatría';
		}else if($servicio == 3){
			echo 'Ginecobstetricia';
		}
	?></td>
    <td class="negrita">Rango de fechas:</td>
    <td class="centrado">
<?php
if($fecha_inicio == '' && $fecha_fin ==''){
echo "TODO";	
}else{
	echo $fecha_inicio,'<strong> A </strong>',$fecha_fin;
}
?>	
</td>
<td class="negrita centrado">Fecha reporte:</td><td class="texto"><?=date('Y-m-d H:i:s')?></td>
  </tr>
</table>
<?=br()?>
<table id='interna'>
<tr><td class="negrita centrado">CIE10</td><td class="negrita centrado">DIAGNOSTICO</td><td class="negrita centrado">TOTAL</td></tr>
<?php
foreach($lista as $d)
{
?>
<tr><td class="negrita centrado"><?=$d['CIE10']?></td>
<td class="texto"><?=$d['DIAGNOSTICO']?></td>
<td class="negrita centrado"><?=$d['TOTAL']?></td>
</tr>
<?php
}
?>
</table>
<?php 
echo br();
$this -> load -> view('impresion/fin'); 
?>