<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['ReportesAdmin'] = array(

	/* e-commerce */

	array(
		'nombre' => 'Cotizaciones por empresa',
		'clase' => 'Reporte_cotizaciones_por_empresa',
		'tipo' => 'E-commerce'
	),
	
	array(
		'nombre' => 'Comparaci&oacute;n mensual de cotizaciones por empresa',
		'clase' => 'Reporte_cotizaciones_empresa_comparacion',
		'tipo' => 'E-commerce'
	),
	
	array(
		'nombre' => 'Productos que ingresaron a la plataforma por categoría',
		'clase' => 'Reporte_productos_categoria_ingresaron',
		'tipo' => 'E-commerce'
	),
	
	array(
		'nombre' => 'Usuarios nuevos que cotizaron productos',
		'clase' => 'Reporte_usuarios_nuevos_cotizaron',
		'tipo' => 'E-commerce'
	),
	
	array(
		'nombre' => 'Productos removidos por empresa',
		'clase' => 'Reporte_productos_empresa_removidos',
		'tipo' => 'E-commerce'
	),
		
	array(
		'nombre' => 'Productos que cambiaron de precio por empresa',
		'clase' => 'Reporte_productos_empresa_cambio_precio',
		'tipo' => 'E-commerce'
	),
		
	array(
		'nombre' => 'Negocios cerrados por departamento',
		'clase' => 'Reporte_negocios_departamento_cerrados',
		'tipo' => 'E-commerce'
	),
		
	array(
		'nombre' => 'Productos que han sido calificados mas veces',
		'clase' => 'Reporte_productos_mas_calificados',
		'tipo' => 'E-commerce'
	),
	
	array(
		'nombre' => 'Productos que han sido cotizados mas veces',
		'clase' => 'Reporte_productos_mas_cotizados',
		'tipo' => 'E-commerce'
	),
	
	array(
		'nombre' => 'Cantidad de modificaciones hechas en los productos',
		'clase' => 'Reporte_modificaciones_productos',
		'tipo' => 'E-commerce'
	),
	
	/* plan de negocio */
	
	array(
		'nombre' => 'Empresas que iniciaron un plan de negocios',
		'clase' => 'Reporte_empresas_iniciaron_pn',
		'tipo' => 'Plan de negocio'
	),
	
	array(
		'nombre' => 'Empresas por nivel',
		'clase' => 'Reporte_empresas_nivel',
		'tipo' => 'Plan de negocio'
	),
	
	array(
		'nombre' => 'Empresas con planes de negocio en revisión',
		'clase' => 'Reporte_empresas_revision_pn',
		'tipo' => 'Plan de negocio'
	),
	
	/* novedades */
	
	array(
		'nombre' => 'Noticias por tipo',
		'clase' => 'Reporte_noticias_publicadas',
		'tipo' => 'Novedades'
	),
	
	array(
		'nombre' => 'Visitas por noticia',
		'clase' => 'Reporte_noticias_visitas',
		'tipo' => 'Novedades'
	),
	
	/* trámites */
	
	array(
		'nombre' => 'Consultas de trámites por corporación',
		'clase' => 'Reporte_consultas_tramites_corporacion',
		'tipo' => 'Trámites'
	),
	
	/* Bases de datos */
	
	array(
		'nombre' => 'Consultas de base de datos por categoría',
		'clase' => 'Reporte_categorias_basedatos',
		'tipo' => 'Bases de datos'
	),
); 

?>