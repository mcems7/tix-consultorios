<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title>YAG&Eacute; - Sistema de gesti&oacute;n hospitalaria</title>
   <link rel="stylesheet" type="text/css" href="<?=base_url().'resources/styles/impresion2.css'?>">
   
<!--<body onLoad="window.print()">-->
    <style>
      * {
          color:#7F7F7F;
          font-family:Arial,sans-serif;
          font-size:10px;
          font-weight: bold;
		  
      }    
      #config{
          overflow: auto;
         
      }
      .config{
          float: left;
		  margin:auto;
		 
          border:none;
         
      }
      .config .title{
          font-weight: bold;
          text-align: center;
      }
      .config .barcode2D,
      #miscCanvas{
        display: none;
      }
      #submit{
          clear: both;
      }
      #barcodeTarget,
      #canvasTarget{
		  margin:auto;
       
      }        
    </style>
    
    <script type="text/javascript"  src="<?=base_url()?>resources/jquery-1.3.2.min.js"></script>
    <script type="text/javascript"  src="<?=base_url()?>resources/jquery-barcode-2.0.2.min.js"></script>
    <script type="text/javascript">
    
      function generateBarcode(){
        var value = $("#barcodeValue").val();
        var btype = $("input[name=btype]").val();
        var renderer = $("input[name=renderer]").val();
        
		var quietZone = false;
        if ($("#quietzone").is(':checked') || $("#quietzone").attr('checked')){
          quietZone = true;
        }
		
        var settings = {
          output:renderer,
          bgColor: $("#bgColor").val(),
          color: $("#color").val(),
          barWidth: $("#barWidth").val(),
          barHeight: $("#barHeight").val(),
          moduleSize: $("#moduleSize").val(),
          posX: $("#posX").val(),
          posY: $("#posY").val(),
          addQuietZone: $("#quietZoneSize").val()
        };
        if ($("#rectangular").is(':checked') || $("#rectangular").attr('checked')){
          value = {code:value, rect: true};
        }
        if (renderer == 'canvas'){
          clearCanvas();
          $("#barcodeTarget").hide();
          $("#canvasTarget").show().barcode(value, btype, settings);
        } else {
          $("#canvasTarget").hide();
          $("#barcodeTarget").html("").show().barcode(value, btype, settings);
        }
      }
          
      function showConfig1D(){
        $('.config .barcode1D').show();
        $('.config .barcode2D').hide();
      }
      
      function showConfig2D(){
        $('.config .barcode1D').hide();
        $('.config .barcode2D').show();
      }
      
      function clearCanvas(){
        var canvas = $('#canvasTarget').get(0);
        var ctx = canvas.getContext('2d');
        ctx.lineWidth = 1;
        ctx.lineCap = 'butt';
        ctx.fillStyle = '#FFFFFF';
        ctx.strokeStyle  = '#000000';
        ctx.clearRect (0, 0, canvas.width, canvas.height);
        ctx.strokeRect (0, 0, canvas.width, canvas.height);
      }
      
      $(function(){
        $('input[name=btype]').click(function(){
          if ($(this).attr('id') == 'datamatrix') showConfig2D(); else showConfig1D();
        });
        $('input[name=renderer]').click(function(){
          if ($(this).attr('id') == 'canvas') $('#miscCanvas').show(); else $('#miscCanvas').hide();
        });
        generateBarcode();
      });
  
    </script>
  </head>
 <body onLoad="window.print()">
  <table id="principal" align="center">
    <div id="generator">
      <input type="hidden" id="barcodeValue" value="<?= $etiqueta?>">
      <div id="config">
        <div class="config">
          
          <input type="hidden" name="btype" id="code128" value="code128" >
             
            
        <div class="config">
         
          <input type="hidden" id="bgColor" value="#FFFFFF" size="7">
          <input type="hidden" id="color" value="#000000" size="7">
          <div class="barcode1D">
          <input type="hidden" id="barWidth" value="2" size="3">
           <input type="hidden" id="barHeight" value="30" size="3">
          </div>
          <div class="barcode2D">
            <input type="hidden" id="moduleSize" value="5" size="3">
            <input type="hidden" id="quietZoneSize" value="1" size="3">
            <input type="checkbox" name="rectangular" id="rectangular"><label for="rectangular"></label><br />
          </div>
          <div id="miscCanvas">
         <input type="hidden" id="posX" value="10" size="3">
          <input type="hidden" id="posY" value="20" size="3">
          </div>
        </div>
            
       
         
          <input type="hidden" id="bmp" name="renderer" value="bmp" ><label for="bmp"></label>
     
      </div>
        
   
        
    </div>
    <?= $documento?> <?= $nombre?>
    <div id="barcodeTarget" class="barcodeTarget"></div>
    <canvas id="canvasTarget" width="150" height="70"></canvas> 
    <?='Orden:'. $etiqueta?> 
    </table>
     </body>
</html>