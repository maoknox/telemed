
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDT9BgFSTCCAxMtteEZAavsw3NPfgxdjRc&callback"></script>
    <script>

	var map;
function initialize() {
  var mapOptions = {
    center: new google.maps.LatLng('4.692083', '-74.076233'),
    zoom: 18,
    //mapTypeId: google.maps.MapTypeId.SATELLITE,
    heading: 90,
    tilt: 45
  };
  
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
var infowindow = new google.maps.InfoWindow();
 var marker = new google.maps.Marker({
      position: new google.maps.LatLng('4.692083', '-74.076233'),
      map: map,
	  title: 'Última posición'
    });
google.maps.event.addListener(map, 'click', function(event) {
   $("#ObjectUbication_ubication_lat").val(event.latLng.lat());
   $("#ObjectUbication_ubication_long").val(event.latLng.lng());
   console.log( 'Lat: ' + event.latLng.lat() + ' and Longitude is: ' + event.latLng.lng() );
});
    google.maps.event.addListener(marker, 'click', function() {
    infowindow.setContent("Última posición");
    infowindow.open(map, marker);
  });
    //markers.push(marker);
}

function rotate90() {
  var heading = map.getHeading() || 0;
  map.setHeading(heading + 90);
}

function autoRotate() {
  // Determine if we are showing aerial imagery
  if (map.getTilt() != 0) {
    window.setInterval(rotate90, 3000);
  }
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>
<!--<input type="button" value="Auto Rotate" onclick="autoRotate();">-->
<div id="map-canvas" style="height: 600px; margin: 0px; padding: 0px; border:1px solid #006"></div>
 
