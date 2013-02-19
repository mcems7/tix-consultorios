
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">



<tr>
<td colspan="2">Entidad</td>
<td colspan="2">Sexo</td>
<td colspan="2">Cantidad</td>
</tr>

<?php foreach ($resultado as $item)
			{
		  
			?>
       
<tr>

<td colspan="2"><?=$item['Entidad'] ?></td>
<td colspan="2"><?=$item['Sexo'] ?></td>
<td colspan="2"><?=$item['Cantidad'] ?></td>
</tr>

<?php 
			}
			
			//print_r($resultado);
			?>


</table>
</table>