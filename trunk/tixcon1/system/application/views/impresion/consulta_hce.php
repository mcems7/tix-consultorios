<h4>Servicio de Consulta Externa - Historia Clínica</h4>
<table width="100%">
<?php $this->load->view('impresion/datos_basicos_consulta');?>
<tr><td>
<tr><th colspan="2">Historia Clínica</th></tr>
<tr><td><table border="1" width="100" rules=none>
<?=$hce_impresa?>
 </table>
 </td>
</tr>
<tr><th colspan="2">Diagnósticos</th></tr>
<tr><td>
    <table width="100%" border="1" cellspacing="2" cellpadding="2">
    <tr><td class="negrita">Código</td><td class="negrita">Diagnóstico</td></tr>
    <?php
        foreach($diagnosticos as $item)
        {
            ?>
        <tr><td><?=$item['codigo']?></td><td><?=$item['diagnostico']?></td></tr>
            <?php
        }
    ?>
    </table>
</td></tr>
<tr><th colspan="2">Plan y Manejo</th></tr>
<tr><td>
    <table width="100%" border="1" cellspacing="2" cellpadding="2">
    <tr><td colspan="2"><?=$plan_manejo?></td></tr>
    </table>
</td></tr>
 </table>
   