<table id="interna">
  <tr>
    <td class="negrita">Fecha y hora:</td>
    <td class="centrado"><?=$fecha_evolucion?></td>
    <td class="negrita">M&eacute;dico:</td>
    <td class="centrado"><?=$primer_nombre.' '.$segundo_nombre.' '.$primer_apellido.' '.$segundo_apellido?></td>
  </tr>
  <tr>
    <td class="negrita">Especialidad:</td>
    <td class="centrado"><?=$esp?></td>
    <td class="negrita">Tipo evolución:</td>
    <td class="centrado"><?=$tipo_evolucion?></td>
  </tr>
<tr><td class="texto" colspan="4"><strong>Subjetivo:</strong>
<?=nbs().$subjetivo?></td></tr>
<tr><td class="texto" colspan="4"><strong>Objetivo:</strong>
<?=nbs().$objetivo?></td></tr>
<tr><td class="texto" colspan="4"><strong>Análisis:</strong>
<?=nbs().$analisis?></td></tr>
<tr><td class="texto" colspan="4"><strong>Conducta:</strong>
<?=nbs().$conducta?></td></tr>
</table>