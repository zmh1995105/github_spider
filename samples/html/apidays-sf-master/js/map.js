function initialize() {
		
		var roadAtlasStyles = [
	  {
	    "featureType": "administrative",
	    "elementType": "labels",
	    "stylers": [
	      { "visibility": "off" }
	    ]
	  },{
	    "featureType": "road.highway",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#808080" },
	      { "lightness": 50 }
	    ]
	  },{
	    "featureType": "road.highway",
	    "elementType": "geometry.stroke",
	    "stylers": [
	      { "color": "#808080" },
	      { "lightness": 90 }
	    ]
	  },{
	    "featureType": "road.highway",
	    "elementType": "labels.text.fill",
	    "stylers": [
	      { "color": "#808080" }
	    ]
	  },{
	    "featureType": "landscape.man_made",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#c8c8c8" },
	      { "lightness": 70 }
	    ]
	  },{
	    "featureType": "road.arterial",
	    "elementType": "geometry.stroke",
	    "stylers": [
	      { "color": "#808080" },
	      { "lightness": 50 }
	    ]
	  },{
	    "featureType": "road.local",
	    "elementType": "geometry.stroke",
	    "stylers": [
	      { "color": "#808080" },
	      { "lightness": 50 }
	    ]
	  },{
	    "featureType": "poi.park",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#b4c885" },
	      { "saturation": 34 }
	    ]
	  },{
	    "featureType": "poi.business",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#808080" },
	      { "lightness": 59 }
	    ]
	  },{
	    "featureType": "poi.government",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#808080" },
	      { "lightness": 59 }
	    ]
	  },{
	    "featureType": "poi.medical",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#808080" },
	      { "lightness": 59 }
	    ]
	  },{
	    "featureType": "poi.place_of_worship",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#808080" },
	      { "lightness": 59 }
	    ]
	  },{
	    "featureType": "poi.school",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#808080" },
	      { "lightness": 59 }
	    ]
	  },{
	    "featureType": "poi.sports_complex",
	    "elementType": "geometry.fill",
	    "stylers": [
	      { "color": "#808080" },
	      { "lightness": 59 }
	    ]
	  },{
	    "featureType": "transit.station.bus"  }];
	
		var latlng = new google.maps.LatLng(37.773496,-122.415912);
        var mapOptions = {
          center: latlng,
          zoom: 15,
		  disableDefaultUI: true,
		  scrollwheel: false,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
		var infowindow = new google.maps.InfoWindow();
        var map = new google.maps.Map(document.getElementById("map"),
            mapOptions);
		map.setOptions({styles: roadAtlasStyles});
		var marker = new google.maps.Marker({
		      position: latlng,
		      map: map,
		      title: 'PARISOMA'
		  });
		var content = '<h1>PARISOMA</h1> <a target="_blank" href="https://www.google.com/maps/preview#!data=!1m4!1m3!1d3938!2d-122.4159808!3d37.7734864!4m36!3m16!1m0!1m5!1sPARISOMA%2C+169+11th+St%2C+San+Francisco%2C+CA+94103!2s0x8085809d840bc67d%3A0x861e1f0d4c6c83d2!3m2!3d37.773527!4d-122.415929!3m8!1m3!1d126044!2d-122.4376!3d37.7577!3m2!1i1152!2i959!4f13.1!5m16!2m15!1m14!1s0x8085809d840bc67d%3A0x861e1f0d4c6c83d2!2sPARISOMA%2C+11th+Street%2C+San+Francisco%2C+CA!3m8!1m3!1d126044!2d-122.4376!3d37.7577!3m2!1i1152!2i959!4f13.1!4m2!3d37.773527!4d-122.415929!7m1!3b1&fid=0">Visit us</a>';
		google.maps.event.addListener(marker, 'click', function () {
            infowindow.setContent(content);
            infowindow.open(map, marker);
        });
      }
google.maps.event.addDomListener(window, 'load', initialize);