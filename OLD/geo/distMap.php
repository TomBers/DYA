<html>
<head>
  <link rel="stylesheet" href="http://libs.cartocdn.com/cartodb.js/v3/themes/css/cartodb.css" />
  <link rel="stylesheet" type="text/css" href="newStyle.css" media="screen">
  <!--[if lte IE 8]>
    <link rel="stylesheet" href="http://libs.cartocdn.com/cartodb.js/v3/themes/css/cartodb.ie.css" />
  <![endif]-->  
	<script src="http://libs.cartocdn.com/cartodb.js/v3/cartodb.js"></script>
	<style>
    html, body {width:100%; height:100%; padding: 0; margin: 0;}
    #map { width: 100%; height:80%; background: black;}
    #menu { position: absolute; top: 5px; right: 10px; width: 400px; height:60px; background: transparent; z-index:10;}
    #menu a { 
      margin: 15px 10px 0 0;
      float: right;
      vertical-align: baseline;
      width: 30px;
      padding: 10px;
      text-align: center;
      font: bold 15px "Helvetica",Arial;
      line-height: normal;
      color: #555;
      border-radius: 4px;
      border: 1px solid #777777;
      background: #ffffff;
      text-decoration: none;
      cursor: pointer;
    }
    #menu a.selected,
    #menu a:hover { 
      color: #000;
    }            
	</style>

	<script>
    var map;
	
    function init() {
      // initiate leaflet map	

      map = new L.Map('map', { 
        center: [20,-20],
        zoom: 3
      });

      L.tileLayer('https://dnv9my2eseobd.cloudfront.net/v3/cartodb.map-4xtxp73f/{z}/{x}/{y}.png', {
        attribution: 'MapBox'
      }).addTo(map);

      var layerUrl = 'http://tomb.cartodb.com/api/v2/viz/477babde-95bf-11e3-9313-0e49973114de/viz.json';

      var sublayers = [];

      cartodb.createLayer(map, layerUrl)
        .addTo(map)
        .on('done', function(layer) {
          // change the query for the first layer
          var subLayerOptions = {
            sql: "SELECT * FROM dya LIMIT 2000",
            cartocss: "#dya{marker-fill: #F84F40; marker-width: 8; marker-line-color: white; marker-line-width: 2; marker-clip: false; marker-allow-overlap: true;}"
          }

          var sublayer = layer.getSubLayer(0);

          sublayer.set(subLayerOptions);

          sublayers.push(sublayer);
          detectUserLocation();
        }).on('error', function() {
          //log the error
        });

      // credit: http://html5doctor.com/finding-your-position-with-geolocation/
      function detectUserLocation() {
        if(navigator.geolocation) {
          var timeoutVal = 10 * 1000 * 1000;

          navigator.geolocation.watchPosition(
            mapToPosition, 
            alertError,
            { enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0 }
          );
        } else {
          alert("Geolocation is not supported by this browser");
        }
        
        function alertError(error) {
          var errors = { 
            1: 'Permission denied',
            2: 'Position unavailable',
            3: 'Request timeout'
          };

          alert("Error: " + errors[error.code]);
        }
      }

      function mapToPosition(position){
        lon = position.coords.longitude;
        lat = position.coords.latitude;
        updateQuery();
        map.setView(new L.LatLng(lat,lon), 15);
        new L.CircleMarker([lat,lon],{radius: 4}).addTo(map);
      }

      var lon,
          lat,
          total = 10;

     	function updateQuery() {
		  sublayers[0].set({
		    sql: "SELECT * FROM dya LIMIT 2000",
		    cartocss: "#dya{marker-fill: #F84F40; marker-width: 18; marker-line-color: white; marker-line-width: 2; marker-clip: false; marker-allow-overlap: true;} "
		  });
		}

    } 
    
	</script>
</head>
<?php include($_SERVER['DOCUMENT_ROOT']."/topBar.php"); ?>
<body onload="init()">
  <div id='map'></div>
  <div id='menu'>
     
  </div>
<?php include($_SERVER['DOCUMENT_ROOT']."/pages/footer.html"); ?>
</body>
</html>