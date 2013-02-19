
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">



<tr>
<td class="campo_centro">Especialidad</td>
<td class="campo_centro" >Estado</td>
<td class="campo_centro">Total</td>


</tr>


<?php foreach ($informe as $item)
			{
		  
			?>
 <tr>      


<td><?=$item['descripcion']?></td>
<td><?=$item['estado'] ?></td>
<td><?=$item['total'] ?></td>

</tr>
<?php 
			}
			
			//print_r($resultado);
			?>


</table>
</table>