/* Author: 

*/
<!-- Google Maps API functions -->
	
    function initialize() {
	  document.buscador.busqueda.focus();/* focaliza el buscador al entrar en la web */
      if (GBrowserIsCompatible()) {
		var latlng = new google.maps.LatLng(39.939178, -1.534070);
		var zoom = 6;
		/*if (google.loader.ClientLocation) { //calcula la posicion a partir de la ip
		  zoom = 14;
		  latlng = new google.maps.LatLng(google.loader.ClientLocation.latitude, google.loader.ClientLocation.longitude);
		} */
		setCookie("latitud_longitud",latlng,5);
        var map = new GMap2(document.getElementById("map"));
        map.setCenter(latlng, zoom);
        map.setUIToDefault();
      }
	  /* mapa para la localizacion del usuario */
	  if (GBrowserIsCompatible()) {
        var mapdos = new GMap2(document.getElementById("mapdos"));
        mapdos.setCenter(new GLatLng(36.760816,-4.497109), 12);
        mapdos.setUIToDefault();
      }
	  
	  GDownloadUrl("generaxml.php", function(data) {
          var xml = GXml.parse(data);
          var markers = xml.documentElement.getElementsByTagName("marker");
          for (var i = 0; i < markers.length; i++) {
			var id = markers[i].getAttribute("id");
            var marcador = markers[i].getAttribute("marcador");
            var punto = new GLatLng(parseFloat(markers[i].getAttribute("lat")),
                                    parseFloat(markers[i].getAttribute("lng")));
            var marker = createMarker(punto, id, marcador);
            map.addOverlay(marker);
          }
        });
    }
	// inicio funcion que crea cookies
	function setCookie(c_name,value,exdays)
	{
		var exdate=new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
		document.cookie=c_name + "=" + c_value;
	}//fin
	function createMarker(punto, id, marcador) {
      var marker = new GMarker(punto, customIcons[marcador]);	  
      GEvent.addListener(marker, 'click', function() {
		  $('.anuncio').hide(0);
		  var datos = 'id='+ id;
		$.ajax({
				type: "POST",
				url: "mostrar.php",
				data: datos,
				success: function(data) {
					$('.cargando').removeClass('hid'); /* Muestro el gif de carga del anuncio */
					presentar_datos(data); /* Llamada a la función para presentar los datos */
    				$(".chzn-select").chosen(); /* Llamada a la función para dar estilo a los campos select (Si se hace antes o después no funciona) */
					$('.anuncio').show('fast'); /* Despliego el div que contiene el anuncio */
					$('.cargando').hide(); /* Oculto el gif de carga del anuncio */
				},
				error: function() {
					
				}
			});
			return false;
      });
      return marker;
    }
	
	function presentar_datos(data) {
		var datos = data.documentElement.getElementsByTagName("marker");
          for (var i = 0; i < datos.length; i++) {
			var id = datos[i].getAttribute("id");
			var titulo = datos[i].getAttribute("titulo");
			var descripcion = datos[i].getAttribute("descripcion");
			var tipo = datos[i].getAttribute("tipo");
			var imagenes = datos[i].getAttribute("imagenes");
			var video = datos[i].getAttribute("video");
			var etiquetas = datos[i].getAttribute("etiquetas");
			var precio = datos[i].getAttribute("precio");
            var marcador = datos[i].getAttribute("marcador");
			var fecha = datos[i].getAttribute("fecha");
			var expira = datos[i].getAttribute("expira");
			var email = datos[i].getAttribute("email");
			var telefono = datos[i].getAttribute("telefono");
			var clave = datos[i].getAttribute("clave");
			var visitas = datos[i].getAttribute("visitas");
			var direccion = datos[i].getAttribute("direccion")
		  }
		function showdate(mydate){
		var year = mydate.getYear()
		if (year < 1000)
		 year += 1900
		var day = mydate.getDay()
		var month = mydate.getMonth()
		var daym = mydate.getDate()
		if (daym < 10)
		 daym = "" + daym
		var montharray = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre")
		return daym + " de " + montharray[month] + " del " + year;
	   }
	  var html = "<div class='cargando'></div>";
	  var html = html + "<p class='fecha'>" + showdate(new Date(fecha)) + "</p>";
	  var html = html + "<h1 class='titulo yanone centrado'>" + titulo + "</h1>";
	  var html = html + "<div class='etiqueta'><p class='precio'>" + precio + " &euro;</p></div><!-- etiqueta -->";
	  var introduccion = descripcion.substr(0, 100); 
	  var html = html + "<div class='descripcion'><h1 class='yanone'>Descripción</h1><p><a href='#desc' class='descrp'>" + introduccion + "...[+]</a></p></div><!-- descripcion -->";
	  var html = html + '<div class="inline hid" id="desc"><h1 class="yanone">Descripción</h1><hr/><p>' + descripcion + '</p></div><!-- inline desc -->';
	  var html = html + '<hr/>';
	  var html = html + '<ul class="media">';
	  var listaimagenes = imagenes.split(/,\s*/);
	  for(var i in listaimagenes) {
		var html = html + '<li><a class="fancybox" rel="' + id + '" href="images/fotos/' + listaimagenes[i] + '"><img src="images/fotos/' + listaimagenes[i] + '" alt="' + listaimagenes[i] + '" /></a></li>';
	  }
	  if (video!="") {
	  var html = html + '<li><a class="various fancybox.iframe" href="' + video + '"><img src="images/play.png" alt="" /></a></li>';
	  }
	  var html = html + '</ul><!-- media -->';
	  var html = html + '<hr/>';
	  var html = html + '<h1 class="yanone">Etiquetas</h1>';
	  var html = html + '<ul class="tags">';
	  var listaetiquetas = etiquetas.split(/,\s*/);
	  for(var i in listaetiquetas) {
		var html = html + '<li><a href="#" class="tag"><span class="tag_name">' + listaetiquetas[i] + '</span></a></li>';
	  }
	  var html = html + '</ul><!-- tags -->';
	  var html = html + '<hr/>';
	  var html = html + '<a href="#denunciar" class="denunciar inline">Denunciar</a>';
	  var html = html + '<div class="inline" id="denunciar">';
	  var html = html + '<div class="form_contacto">';
	  var html = html + '<h1 class="yanone centrado">Denunciar</h1><hr/>';
	  var html = html + '<form method="POST" name="denuncia" class="denuncia" action="">';
		  var html = html + '<dl><dt><label for="nombre">Nombre*</label></dt>';
		  var html = html + '<dd><input type="text" name="nombre" class="nombre" /><br/></dd>';
		  var html = html + '<dt><label for="mail">E-mail*</label></dt>';
		  var html = html + '<dd><input type="text" name="mail" class="mail" /><br/></dd>';
		  var html = html + '<dt><label for="motivo">Motivo*</label></dt>';
		  var html = html + '<dd><select name="motivo" class="chzn-select motivo">';
			var html = html + '<option value="inapropiado">Contenido inapropiado</option>';
			var html = html + '<option value="copia">Copia de anuncio</option>';
			var html = html + '<option value="copyright">Infracción de copyright</option>';
			var html = html + '<option value="fraudulento">Anuncio fraudulento</option>';
		  var html = html + '</select></dd>';
		  var html = html + '<dt><label for="mensaje">Mensaje*</label></dt>';
		  var html = html + '<dd><textarea name="mensaje" class="mensaje"></textarea><br/></dd>';
		  var html = html + '<input type="hidden" name="id_denunciar" class="id_denunciar" value="'+id+'" />';
		  var html = html + '<input type="submit" name="enviar" value="Enviar" class="boton comprobar_denuncia" />';
	  var html = html + '</dl></form>';
	  var html = html + '</div><!-- form_contacto -->';
	  var html = html + '</div><!-- inline contactar_administrador -->';
	  $('.contenido').html(html);
	  document.contacto_anunciante.id_contacto.value=id;
	}
/*-- Tiny Scrollbar --*/
    $(document).ready(function(){
      $('#scrollbar1').tinyscrollbar();	
    });
/*-- Fancybox --*/ 
        $(document).ready(function() {
            $("a.fancybox").fancybox({
				closeClick	: false,
				prevEffect		: 'none',
				nextEffect		: 'none'
			});
        });
		$(document).ready(function() {
            $("a.inline").fancybox({
				closeClick	: false,
			});
        });
		$(document).ready(function() {
            $("a.descrp").fancybox({
				closeClick	: false,
				autoSize: false,
				width: 300,
				minHeight: 300
			});
        });
		$(document).ready(function() {
			$(".various").fancybox({
				maxWidth	: 800,
				maxHeight	: 600,
				fitToView	: false,
				width		: '70%',
				height		: '70%',
				autoSize	: false,
				closeClick	: false,
				openEffect	: 'none',
				closeEffect	: 'none'
			});
		});

