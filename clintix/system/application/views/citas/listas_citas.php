<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />

<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function traer_listas()
{
    if($('fecha_agenda').value==''||$('fecha_agenda_inicial').value=='')
        {
            alert('Debe seleccionar las fechas')
            return false;
        }
    var var_url = '<?=site_url()?>/citas/listas_citas/filtrar'
    var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
                data:  $('formulario').toQueryString(),
                async: false,
		onSuccess: function(html){ 
                    //('lista_especialidades').set('html', html)
                        $('lista_citas').set('html',html);   
                        },
		evalScripts: true,
		onFailure: function(){alert('Error consultando');}
		
	});
	ajax1.send();
     return false;

}
////////////////////////////////////////////////////////////////////////////////
</script>
<div id="formularioagenda">
    <h1 class="tituloppal">Consulta Externa - Citas</h1>
    <h2 class="subtitulo">Listado Citas</h2> 
    <table width="100%" class="tabla_form">
        <tr><th colspan="2">Filtrar </th></tr>
        <tr><td colspan="2">
            <?php
                $attributes = array('id'=> 'formulario',
                                    'name'=> 'formulario',
                                    'method' => 'post',
                                    'onsubmit'=> 'return traer_listas()');
                echo form_open('',$attributes);
            ?>
            <table width="60%" class="tabla_interna">
                <tr>
                    <td class="campo_izquierda">Fecha Inicial:</td>
                    <td><input name="fecha_agenda_inicial" type="text" id="fecha_agenda_inicial" value="" size="10" maxlength="10" READONLY="readonly" class="fValidate['dateISO8601']">
                        <img src='<?=base_url()?>resources/img/calendario_boton.png' id='fecha_agenda_botton_inicial' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
                            <script type='text/javascript'>
                                Calendar.setup({
                                inputField     :    'fecha_agenda_inicial',     		// id of the input field
                                ifFormat       :    '%Y-%m-%d',
                                daFormat       :    '%Y-%m-%d',          // format of the input field
                                displayArea	   :	'fecha_agenda_inicial',
                                showsTime      :	true,
                                timeFormat     :    '12',
                                button         :    'fecha_agenda_botton_inicial',       // trigger for the calendar (button ID)
                                align          :    'Br',                   // alignment (defaults to 'Bl')
                                singleClick    :    true
                            });
                            </script>
                    </td></tr><tr>
                      <td class="campo_izquierda">Fecha Final:</td>
                      <td><input name="fecha_agenda" type="text" id="fecha_agenda" value="" size="10" maxlength="10" READONLY="readonly"class="fValidate['dateISO8601']">
                      <img src='<?=base_url()?>/resources/img/calendario_boton.png' id='fecha_agenda_botton' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
                    <script type='text/javascript'>
                    Calendar.setup({
                        inputField     :    'fecha_agenda',     		// id of the input field
                        ifFormat       :    '%Y-%m-%d',
                        daFormat       :    '%Y-%m-%d',          // format of the input field
                        displayArea	   :	'fecha_agenda',
                        showsTime      :	true,
                        timeFormat     :    '12',
                        button         :    'fecha_agenda_botton',       // trigger for the calendar (button ID)
                        align          :    'Br',                   // alignment (defaults to 'Bl')
                        singleClick    :    true
                    });
                    </script></td>
</tr>
<tr>
    <td class="campo_izquierda">Especialidad:</td>
    <td><?=form_dropdown('id_especialidad', $especialidades,'','id="id_especialidad"');?></td>
</tr>
<tr>
    <td class="campo_izquierda">Entidad Encargada del Pago:</td>
    <td><?=form_dropdown('id_entidad_pago', $entidades_pago,'','id="id_entidad_pago"');?></td>
</tr>
<tr>
    <td class="campo_izquierda">Entidad Remite:</td>
    <td><?=form_dropdown('id_entidad', $entidades,'','id="id_entidad"');?></td>
</tr>
    <tr>
    <td class="campo_izquierda">Estado</td>
    <?php
    $estado=array("-1"=>"Todos",
                  "solicitada"=>"Solicitadas",
                  "rechazada"=>"Rechazadas",
                  "autorizada"=>"En Espera",
                  "asignada"=>"Asignada",
                  "atendida"=>"Atendidas");
    ?>
    <td><?=form_dropdown('id_estado', $estado,'-1','id="id_estado"');?></td>
</tr>
</tr>
</table>
        </td></tr>
        <tr><td class="campo_izquierda"><center><?=form_submit('boton', 'Consultar')?></center></td></tr>
    </table>
</div>
<?=form_close();?>
<div id="lista_citas" ></div>

