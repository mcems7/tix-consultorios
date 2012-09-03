<?php $this->load->library('lib_edad');?>
<h1 class="tituloppal">Servicio de Consulta Externa </h1>
<h2 class="subtitulo">Listado Pacientes para Atender </h2>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Pacientes Agendados</th></tr>
<tr><td colspan="2">   

<table class="tabla_interna" width="100%" > 
     <tr>
         <td class="campo_centro">Hora</td>
         <td class="campo_centro">Tiempo de espera</td>
         <td class="campo_centro">Nombre</td>
         <td class="campo_centro">Género</td>
         <td class="campo_centro">Edad</td>
         <td class="campo_centro">Depto.</td>
         <td class="campo_centro">Municipio</td>
         <td class="campo_centro">Acción</td>
     </tr>
<?php
    foreach($lista_pacientes as $item)
    {
       ?> 
    <tr>
     <td>
        <?=arreglo_a_hora($item['orden_intervalo'],$parametros_agenda).':'.(strlen($item['minutos'])==1?'0':'').$item['minutos']?>
    </td>
    <td>
        <!--<?=$this->lib_edad->edad($item['fecha_solicitud'])?>--> 0 días
    </td>
    <td>
        <?=$item['primer_nombre']?>  <?=$item['segundo_nombre']?> <?=$item['primer_apellido']?> <?=$item['segundo_apellido']?>  
    </td>
    <td>
        <?=$item['genero']?>
    </td>
    <td>
        <?=$this->lib_edad->edad($item['fecha_nacimiento'])?>
    </td>
     <td>
        <?=$item['departamento']?>
    </td>
     <td>
        <?=$item['municipio']?>
    </td>
     <td class="opcion">
         <a href="<?=site_url('atencion/atenciones/index/'.$item['id_especialidad'].'/'.$item['id'])?>">Atender</a> 
    </td>
    </tr>
        <?php
    }
?>
</table>
</tr>
</table>