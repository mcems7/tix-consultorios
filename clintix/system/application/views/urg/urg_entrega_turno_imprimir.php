<?php $this -> load -> view('impresion/inicio'); ?>
<h4>Servicio de Urgencias - Entrega de turno</h4>
<table id="interna">
  <tr>
    <td class="negrita">Médico entrega:</td>
    <td class="centrado"><?=$entrega['medico_entrega']?></td>
    <td class="negrita">Médico recibe:</td>
    <td class="centrado"><?=$entrega['medico_recibe']?></td>
  </tr>
  <tr>
    <td class="negrita">Fecha y hora:</td>
    <td class="centrado"><?=$entrega['fecha_hora_entrega']?></td>
    <td class="negrita">Servicio:</td>
    <td class="centrado"><?=$entrega['nombre_servicio']?></td>
  </tr>
</table>
<?php
foreach($entrega_detalle as $dato){
?>
<table id='interna'>
<tr>
<td colspan="2" class="texto" style="border-top:solid; border-top-width:3px; border-bottom:solid; border-bottom-width:4px;"><strong>&nbsp;Cama:</strong><?=nbs().$dato['numero_cama'].nbs()?>
<strong>Nombre:</strong><?=nbs().$dato['paciente']?>
<?=nbs().$dato['numero_documento'].nbs()?><strong>Especialidad:</strong><?=nbs().$dato['espe'].nbs()."<strong>EH:</strong>".nbs().$this->urgencias_model->obtenerTiempoEstancia($dato['id_atencion'],$entrega['fecha_hora_entrega'])?>H</td>
</tr>
<tr>
<?php
$consulta = $this->urgencias_model->obtenerConsulta($dato['id_atencion']);
$dx_con = $this->urgencias_model->obtenerDxConsulta($consulta['id_consulta']);
$dx_evo = $this->urgencias_model->obtenerDxEvoluciones($dato['id_atencion']);
?>
<td colspan="2">
<strong>Diagnosticos:</strong>
<?php
if(count($dx_con) > 0)
{
	foreach($dx_con as $dat)
	{

		echo $dat['diagnostico'],nbs(),'|' ,nbs();

	}
}
?>
<?php
if(count($dx_evo) > 0)
{
	foreach($dx_evo as $dat)
	{

		echo $dat['diagnostico'],nbs(),'|' ,nbs();

	}
}
?>
</td>
</tr>
<tr>
<td width="50%" class='texto'><strong>Pendiente:</strong><?=nbs().$dato['pendiente']?></td>
<td width="50%" class='texto'><strong>Observaciones:</strong><?=nbs().$dato['observaciones']?></td>
</table>
<?php
//echo br();
}
echo br(3);
?>
<center>
<table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40%" style="text-align:center; font-size:12; font-weight:bold; border-top-width:1px; border-top-style:solid; border-top-color:#000">Firma médico entrega&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="40%" style="text-align:center; font-size:12; font-weight:bold; border-top-width:1px; border-top-style:solid; border-top-color:#000">Firma médico recibe&nbsp;</td>
  </tr>
</table>
</center>
<?php 
echo br();
$this -> load -> view('impresion/fin'); ?>