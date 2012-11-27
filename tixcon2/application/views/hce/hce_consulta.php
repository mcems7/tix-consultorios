<script type="text/javascript">
function regresar()
{
	document.location = "<?=$urlRegresar; ?>";
}
</script>
<center><h1 class="tituloppal">Servicio de Consulta Externa</h1></center>
<h2 class="subtitulo">Historia Clínica Paciente</h2>
<table width="95%" class="tabla_form">
<?php $this->load->view('atencion/aten_datos_basicos_atencion');?>
<tr><th colspan="2">Historia Clínica</th></tr>
<tr><td>
    <table width="100%" border="0" class="tabla_form">
  <?=$hce_impresa?>
    </table>
</td></tr>
<tr><th colspan="2">Diagnósticos</th></tr>
<tr><td>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr><td class="campo_centro">Código</td><td class="campo_centro">Diagnóstico</td></tr>
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
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr><td colspan="2"><?=$plan_manejo?></td></tr>
    </table>
</td></tr>
</table>
<div class="linea_azul"></div>
</br></br>
<center>
<?
$data = array('name'=>'bv',
            'onclick'=>'history.back()',
            'value'=>'Volver',
            'type'=>'button');
echo form_input($data),nbs();
$data = array('name'=>'imp',
                'onclick' => "Abrir_ventana('".site_url('impresion/impresiones_consulta/imprimir_hce/'.$info_cita['id'])."')",
                'value' => 'Imprimir',
                'type' =>'button');
echo form_input($data);
?>
</center>