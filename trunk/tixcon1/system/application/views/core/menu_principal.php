
<script language="javascript">
function desplegar_menu(capa) 
{
	var contenedor = $(capa);
	var estilo = contenedor.getProperty('style');
	
	if(estilo == 'display: none;'){
		contenedor.setStyle('display', 'block');
	}else if(estilo == 'display: block;'){
		contenedor.setStyle('display', 'none');
	}
}
</script>
<?php
	$CI = &get_instance();  
	$CI -> load -> model('core/permiso');
	$CI -> load -> model('core/permisoentidad');
	$CI -> load -> model('core/modulo');
	$CI -> load -> helper('url');	
	$permisos = $CI -> permiso -> obtenerTodos();

	$modulos_pt = array();
	// Obtener el nombre (real) del módulo 'general',
	// disponible para todos los usuarios
	$modulos_pt['general'] = $CI -> modulo -> obtener('general');
	foreach($permisos as $permiso)
	{
		// Establecer los valores del módulo, controlador y acción
		
		$modulo      = $permiso['modulo'];
		$controlador = ($permiso['controlador'] == "*") ? "main" : $permiso['controlador'];
		$accion      = ($permiso['accion'] == "*") ? "index" : $permiso['accion'];
		
		// Establecer la ruta y el texto del enlace en el menú

		$url    = $modulo . "/" . $controlador . "/" . $accion;
		$titulo = $permiso['descripcion'];
		
		// Si no es acceso directo no se debe presentar en el menú
		
		if($permiso['acceso_directo'] == 'n')
			continue;
		
		// Verificar si el usuario en sesión tiene acceso al recurso
		
		$chkperm = $CI -> permisoentidad -> validarPermisodeUsuarioSegunSeccion($CI -> session -> userdata('id_usuario'), 
																				  $modulo, 
																				  $controlador, 
																				  $accion);
		if($chkperm === true)
		{
			// En caso de tenerse permiso almacenarlo en las opciones del usuario
			
			$opciones[] = array('modulo'      => $modulo,
								 'controlador' => $controlador,
								 'accion'      => $accion,
								 'url'         => $url,
								 'titulo'      => $titulo);

			// Almacenar la información del nombre (real) del módulo actual

			if(!isset($modulos_pt[$modulo]))
				$modulos_pt[$modulo] = $CI -> modulo -> obtener($modulo);
		}


	}
		
		// Agregar opciones de menú generales
		
		$opciones[] = array('modulo'      => 'general',  // core ?
		                             'controlador' => 'perfil',
		                             'accion'      => 'index',
		                             'url'         => '/core/perfil/index',
		                             'titulo'      => 'Cambio contrase&ntilde;a');

		$opciones[] = array('modulo'      => 'general',
		                             'controlador' => 'main',
		                             'accion'      => 'logout',
		                             'url'         => '/core/login/salir',
		                             'titulo'      => 'Terminar sesi&oacute;n');
		
				$ultimo_modulo = null;
			
				for($i=0; $i<count($opciones); $i++)
				{
					$opcion = $opciones[$i];

					$modulo      = $opcion['modulo'];
					$controlador = $opcion['controlador'];
					$accion      = $opcion['accion'];
					$url         = $opcion['url'];
					$titulo      = $opcion['titulo'];
					
					if($ultimo_modulo != $modulo)
					{
						if($ultimo_modulo != null)
						{
							echo "</ul></div></div></div></div></div>";
						}
						
						$ultimo_modulo = $modulo;
						
						$nombre_modulo = $modulo;
						
						if (isset($modulos_pt[$modulo]))
						{
							$nombre_modulo = $modulos_pt[$modulo]['nombre'];
						}
?>
						<div class="art-sidebar1">
	<div class="art-Block">
        <div class="art-Block-tl"></div>
        <div class="art-Block-tr"></div>
        <div class="art-Block-bl"></div>
        <div class="art-Block-br"></div>
        <div class="art-Block-tc"></div>
        <div class="art-Block-bc"></div>
    
        <div class="art-Block-cl"></div>
        <div class="art-Block-cr"></div>
        <div class="art-Block-cc"></div>
            
            <div class="art-Block-body">
    
                <div class="art-BlockHeader">
                    <div class="l"></div>
                    <div class="r"></div>
                    <div class="art-header-tag-icon">
                        <div class="t">
<?php
$mod = $this->uri->segment(1);
/*
if($mod == $modulo){
	$clase = 'style="display:block"';
}else{
	$clase = 'style="display:none"';	
}
<a href='javascript:void()' onClick="desplegar_menu('<?=$modulo?>')" class='vmenu'><?=$nombre_modulo?></a>
<div class="art-BlockContent" id="<?=$modulo?>" <?=$clase?>>*/?>
 <?=$nombre_modulo?></div>
                    </div>
                </div>
                <div class="art-BlockContent">
                <div class="art-BlockContent-body">
						<ul class="menu">
<?php
					}

					echo '<li class="item58">'.anchor($url, $titulo).'</a></li>';
           
				}

?>
</ul></div></div></div></div></div>

