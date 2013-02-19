<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function cargar_municipios()
{
    	var var_url = '<?=site_url()?>/citas/solicitar_cita/municipios/'+$('nombre_departamento_hidden').value;
	var ajax1 = new Request(
	{
		url: var_url,
                async: false,
		onSuccess: function(html){
                    $('nombre_municipio').set('html',html);
                },
		onComplete: function(){
			},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
window.addEvent("domready", function(){
 cargar_municipios(-1);			
filtrar(); 
});
function filtrar()
{
    id_departamento=$('nombre_departamento_hidden').value==""?-1:$('nombre_departamento_hidden').value;
    id_municipio= $('nombre_municipio_hidden').value==""?-1:$('nombre_municipio_hidden').value;  
    var var_url = '<?=site_url()?>/citas/autorizar_cita/lista_autorizacion/'+$('id_especialidad').value+'/'+id_departamento+'/'+id_municipio+'/'+$('tipo_atencion').value+'/'+$('prioritaria').value+'/'+$('id_entidad_remitente').value+'/'+$('id_entidad').value;
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                    //alert(html);
                    $('lista').set('html',html);
                           },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                }
		
	});
	ajax1.send();
    return false;
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$attributes = array('id'=>'formulario',
	            'name'=>'formulario',
		    'method'=>'post',
                    'onSubmit'=>'return filtrar()');
echo form_open('/citas/autorizar_cita/cambiar_estado_cita_pedida',$attributes);
?>
<h1 class="tituloppal">Consulta Externa - Citas</h1>
<h2 class="subtitulo">Aprobación Citas</h2>
  <table width="100%" class="tabla_form">
<tr><th colspan="2">Citas por Aprobar</th></tr>
<tr><td>
  <table>
   <tr>
<td class='campo_izquierda' id="td_departamento">Departamento Residencia:</td>
<td>
<?=form_dropdown('nombre_departamento_hidden',$departamento, '','id="nombre_departamento_hidden" onchange="cargar_municipios()"')?>

</td></tr>
<tr>
<td class='campo_izquierda' >Municipio Residencia:</td>
<td id="nombre_municipio">

</td></tr>
                <tr>
                    <td class='campo_izquierda'>Causa de Externa:</td>
                    <td><select name="tipo_atencion" id="tipo_atencion">
                      <option value="-1">Todos</option>
                      <option value="01">Accidente Trabajo</option>
                      <option value="02">Accidente Tránsito</option>
                      <option value="03">Accidente Rábico</option>
                      <option value="04">Accidente Ofídico</option>
                      <option value="05">Otro Accidente</option>
                      <option value="06">Evento Catastrófico</option>
                      <option value="07">Lesión por Agresión</option>
                      <option value="08">Lesión Autoinfligida</option>
                      <option value="09">Sospecha Maltrato Físico</option>
                      <option value="10">Sospecha Abuso Sexual</option>
                      <option value="11">Sospecha Violencia Sexual</option>
                      <option value="12">Sospecha Maltr. Emocional</option>
                      <option value="13">Enfermedad General</option>
                      <option value="14">enfermedad Profesional</option>
                      <option value="15">Otra</option>
                    </select>
                    </td></tr>
                <tr>
                    <td class='campo_izquierda'>Prioritaria</td>
                        <td>
                            <select id="prioritaria" name="prioritaria">
                             <option value="ambas">Ambas</option>
                             <option value="prioritaria">Prioritaria</option>
                             <option value="no_prioritaria">No Prioritaria</option>
                            </select>
                        </td></tr>
                <tr>   <td class='campo_izquierda'>Institución Encargada del Pago</td>
                        <td>
                           <select name="id_entidad" id="id_entidad"  style="font-size:9px">
                           <option value="-1">Todas</option>
                           <?php
                            foreach($entidades_remision as $d)
                            {
                                echo '<option value="'.$d['id_entidad'].'">'.$d['nombre'].'</option>';
                            }
                            ?>
                        </select>
                        </td>
                </tr>
                     <tr>   <td class='campo_izquierda'>Institución Remite</td>
                        <td>
                           <select name="id_entidad_remitente" id="id_entidad_remitente"  style="font-size:9px">
                           <option value="-1">Todas</option>
                           <?php
                            foreach($entidades_remision as $d)
                            {
                                echo '<option value="'.$d['codigo_entidad'].'">'.$d['nombre'].'</option>';
                            }
                            ?>
                        </select>
                        </td>
                </tr>
                <tr>
<td class='campo_izquierda' id="td_departamento">Especialidad:</td>
<td>
<?=form_dropdown('id_especialidad',$especialidades, '-1','id="id_especialidad"')?>

</td></tr>
            </table>
        
    </td></tr>
<tr><td><?=form_submit('boton', 'Consultar')?></td></tr>
<tr><td colspan="2" id="lista">     
    
    </td>
    </tr>
  </table>
<?=form_close();?>