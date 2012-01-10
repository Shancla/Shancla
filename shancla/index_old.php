<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Shancla</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/jquery.fancybox.css?v=2.0.3" media="screen" />
  <link rel="stylesheet" href="css/chosen.css" media="screen" />
  <!-- end CSS-->

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body onLoad="initialize()" onUnload="GUnload()">
	<header>
        <nav class="user">
            <ul>
            	<li><a href="#" class="logo"><img src="images/logo.png" alt="Shancla" title="Shancla" /></a></li>
                <li class="miubicacion"><a href="#miubicacion" class="inline">Mi ubicacion</a></li>
                <li class="etiquetas"><a href="#">Etiquetas</a>
                	<ul class="ultimos_tags">
                        <li>
                            <a href="#" class="tag">
                                <span class="tag_name">videojuegos</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="tag">
                                <span class="tag_name">xbox</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="tag">
                                <span class="tag_name">mando</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="tag">
                                <span class="tag_name">coche</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="tag">
                                <span class="tag_name">focus</span>
                            </a>
                        </li>
                    </ul><!-- tags -->
                </li>
				<li class="contactar_admin"><a href="#contactar_administrador" class="inline">Contactar con el administrador</a></li>
                <li><a href="#" onClick="initialize();">Limpiar</a></li>
            </ul>
        </nav><!-- user -->
    </header>
    <div class="inline" id="miubicacion">
    	<h1 class="yanone centrado">Selecciona tu ubicación</h1>
		<hr/>
        <div id="mapdos" class="peque"></div>
    </div><!-- inline #miubicacion -->
	<div class="inline" id="contactar_administrador">
		<div class="form_contacto">
			<h1 class="yanone centrado">Contactar con el administrador</h1>
			<hr/>
			<form name="contacto_admin" class="contacto_admin" method="POST" action="">
				<dl>
				<dt><label for="nombre">Nombre*</label></dt>
				<dd><input type="text" name="nombre" class="nombre" /><br/></dd>
				<dt><label for="mail">E-mail*</label></dt>
				<dd><input type="text" name="mail" class="mail" /><br/></dd>
				<dt><label for="mensaje">Mensaje*</label></dt>
				<dd><textarea name="mensaje" class="mensaje"></textarea><br/></dd>
				<input type="submit" name="enviar" value="Enviar" class="boton comprobar_contacto_admin" />
				</dl>
                <div class="ultimo hid">
                 <img src="images/ajax-loader.gif" class="ajaxgif hid" />
                 <div class="msg"></div>
             </div><!-- ultimo -->
			</form>
             <p>&nbsp;</p>
		</div><!-- form_contacto -->
	</div><!-- inline contactar_administrador -->
    
    <div id="map">
    </div><!-- map -->
    <aside class="anuncio">
        <a class="ocultar" href="#" onClick="ocultar();"></a>
    	<div class="contactar">
        	<a href="#contactar" class="boton inline">Contactar</a>
        </div><!-- contactar -->
		<div class="inline" id="contactar">
			<div class="form_contacto">
				<h1 class="yanone centrado">Contactar con el anunciante</h1>
				<hr/>
				<form name="contacto_anunciante" class="contacto_anunciante" method="POST" action="">
					<dl>
					<dt><label for="nombre">Nombre*</label></dt>
					<dd><input type="text" name="nombre" class="nombre" /><br/></dd>
					<dt><label for="mail">E-mail*</label></dt>
					<dd><input type="text" name="mail" class="mail" /><br/></dd>
					<dt><label for="telefono">Telefono</label></dt>
					<dd><input type="text" name="telefono" /><br/></dd>
					<dt><label for="mensaje">Mensaje*</label></dt>
					<dd><textarea name="mensaje" class="mensaje"></textarea><br/></dd>
						<input type="hidden" name="id_contacto" class="id_contacto" value="" /><!-- Este input recibe el valor del id del anuncio cuando se pulsa un marcador  -->
					<input type="submit" name="enviar" value="Enviar" class="boton comprobarcontacto" />
					</dl>
                    <div class="ultimo hid">
                        <img src="images/ajax-loader.gif" class="ajaxgif hid" />
                        <div class="msg"></div>
                    </div><!-- ultimo -->
				</form>
				<div class="contacta_telefono">
					<p>Tambien puedes llamar al</p>
					<h3 class="telefono_contacto">627133022</h3><!-- Este n�mero cambia por javascript cuando se pulsa sobre un marcador en el fichero script.js -->
					<p>Contacto: <span class="naranja">Pepillo</span></p>
				</div><!-- contacta_telefono -->
			</div><!-- form_contacto -->
		</div><!-- inline -->

				<div class="contenido">
                	<!-- carga asincrona -->
                </div><!-- contenido -->
        
    </aside><!-- anuncio -->
    <div id="buscador">
        <form method="POST" action="" name="buscador" class="buscador">
            <input type="text" class="buscar" name="busqueda" />
            <input type="submit" name="buscar" class="boton busqueda" value="Buscar" />
        </form>
    </div><!-- buscador -->

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>
  
  <!-- Fancybox -->
  <script type="text/javascript" src="js/libs/jquery.fancybox.pack.js"></script>
  
  <!-- Chosen - Form Selects -->
  <script type="text/javascript" src="js/libs/chosen.jquery.js"></script>
  
  <script type="text/javascript" src="js/funciones.js"></script>
  
  <!-- Google Maps API Key -->
  <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAASk0qNA9jI-Hb8EEvD8SdeBQoQIAGad4gFjhsBhvrckjDTQlNWBQzaNGoqdVYqWM5Hcmu1TuZS7hLLQ" type="text/javascript"></script>
  <!-- Key antigua - ABQIAAAASk0qNA9jI-Hb8EEvD8SdeBT2yXp_ZAY8_ufC3CFXhHIE1NvwkxRCqI_EkQTAoVT1jexsvcsVZv_8DA -->

  <?php
	include("js/marcadores.php");
  ?>
  
  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="js/plugins.js"></script>
  <script defer src="js/script.js"></script>
  <!-- end scripts-->

  <!-- Change UA-XXXXX-X to be your site's ID -->
  <script>
    window._gaq = [['_setAccount','UAXXXXXXXX1'],['_trackPageview'],['_trackPageLoadTime']];
    Modernizr.load({
      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
    });
  </script>

<script>
function ocultar() {
	$('.anuncio').hide('fast');
	$('.contacto_anunciante .ultimo').hide();
}
</script>
  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
