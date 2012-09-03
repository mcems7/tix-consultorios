<?php 
 class Nodo
{
	public $id_nodo=null;
	public $id_padre=null;
	public $nombre_nodo=null;
	public $tipo=null;
	public $hijos_nodo=array();
	
	function __construct()
	{
	}
	public function get_json_format()
	{
		$cadena='{"property":{ ';
		$cadena.='"name":"'.$this->nombre_nodo.'", ';
		$cadena.='"id":"'.$this->id_nodo.'" ';
		if($this->tipo=="contenedor"){			
			$cadena.=',"openIconUrl": "../../../resources/Source/assets/images/book_icon.gif",
						"closeIconUrl": "../../../resources/Source/assets/images/book_icon.gif"';
			}
		if($this->tipo=="clinico"){	
		$cadena.=',"openIconUrl": "../../../resources/Source/assets/images/file.gif",
						"closeIconUrl": "../../../resources/Source/assets/images/file.gif"';	
			}
		$cadena.='}';
		if(count($this->hijos_nodo)!=0)
		{
			$contador=1;
			$cadena.=', "children": [ ';
			foreach($this->hijos_nodo as $item)
			{
				$cadena.=$item->get_json_format();
				if($contador!=count($this->hijos_nodo))
					{
						$contador++;
						$cadena.=', ';
					}
			}
			$cadena.='] ';
		}
		$cadena.='}';
		return $cadena;
	}
	public static function llenarTreeView($datos)
	{
		$arreglo_json='[ ';
		$ya_hay_nodo=false;
		foreach($datos as $item)
		{
			if($item['idpadre']=='' || !isset($item['idpadre']) )
			{
				$nuevo_nodo=new Nodo();
				$nuevo_nodo->id_nodo=$item['id'];
				$nuevo_nodo->nombre_nodo=$item['abreviatura'];
				Nodo::llenarNodo($datos,$nuevo_nodo);
				if($ya_hay_nodo)
					$arreglo_json.=',';
				else
					$ya_hay_nodo=true;
				$arreglo_json.=$nuevo_nodo->get_json_format();
			}
		}
		$arreglo_json.=']; ';
		return $arreglo_json;
	}
 static function llenarNodo($datos, &$nodo)
	{
		foreach($datos as $item)
		{
			if($item['idpadre']==$nodo->id_nodo)
			{
				$nuevo_nodo=new Nodo();
				$nuevo_nodo->id_nodo=$item['id'];
				$nuevo_nodo->nombre_nodo=$item['abreviatura'];
				$nuevo_nodo->tipo=$item['tipo'];
				Nodo::llenarNodo($datos,$nuevo_nodo);
				$nodo->hijos_nodo[$nuevo_nodo->nombre_nodo]=$nuevo_nodo;
			}
		}
	}
}


?>