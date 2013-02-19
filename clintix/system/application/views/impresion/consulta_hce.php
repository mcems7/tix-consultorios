<h4>Servicio de Consulta Externa - Historia Clínica</h4>
<table width="100%" >
<?php $this->load->view('impresion/datos_basicos_consulta');?>
<tr><td>
<tr><th colspan="2">Historia Clínica</th></tr>
<tr><td><table border="1" width="100" id="interna">


<?php
for ($i = 0; $i < $tamano; $i++) 
		{ ?>
	<tr><th><?=$obtenernombrecont[$i]['nombre'];?> </th></tr>

<?php
	foreach($resultado as $d)
	{
		if ($obtenernombrecont[$i]['id']==$d['idpadre'])
		{
	
?>
 
  <tr>

		
			    <td align="justify"  width="75%"><strong><?=$d['clinico'];?> :</strong> <?= $d['valor'];?></td>
		
	       
<?php
	}
	}
	}
?>

 </table>
 </td>
</tr>
<tr><th colspan="2">Diagnósticos</th></tr>
<tr><td>
    <table width="100%" border="1" cellspacing="2" cellpadding="2" id="interna">
    
    <?php
        foreach($diagnosticos as $item)
        {
            ?>
            
        <tr><td><strong> <?=$item['codigo']?></strong> <?= $item['diagnostico']?></td></tr>
            <?php
        }
    ?>
    </table>
</td></tr>
<tr><th colspan="2">Plan y Manejo</th></tr>
<tr><td>
    <table width="100%" border="1" cellspacing="2" cellpadding="2" id="interna">
    <tr><td colspan="2"><?=$plan_manejo?></td></tr>
    </table>
</td></tr>
 </table>
   