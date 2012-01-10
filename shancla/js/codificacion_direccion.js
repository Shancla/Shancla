function hazlo() {
	alert("fgdfg");
	return false;
}
	 function searchLocations() {
		var geocoder;
		   geocoder = new GClientGeocoder();
		 var zoom = 15;
		
		 var address = document.getElementById('addressInput').value ;	

		 
		 geocoder.getLatLng(address, function(latlng) {
			if (!latlng) {
				
				 var latlng = new google.maps.LatLng(40.417101, -3.702542);
				 var map = new google.maps.Map2(document.getElementById('mapdos'));
				 var marker = new GMarker(latlng);	
				  map.addOverlay(marker);
				  map.setCenter(latlng, zoom);
				  map.setUIToDefault();
			} else {
			  setCookie('latitud_longitud', latlng, 5);
			  var map = new google.maps.Map2(document.getElementById('mapdos'));
			   var marker = new GMarker(latlng);	
			   map.addOverlay(marker);
			  map.setCenter(latlng, zoom);
			  map.setUIToDefault();
			
			}
		});
	  return false;
     }
	 
	function setCookie(c_name,value,exdays)
	{
		var exdate=new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
		document.cookie=c_name + "=" + c_value;
	}


