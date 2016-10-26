var map;
// In the following example, markers appear when the user clicks on the map.
// Each marker is labeled with a single alphabetical character.
var labels = '+';
var labelIndex = 0;
var marker;

function initMap() {
  //Create map
  mapDiv = document.getElementById('map');
  map = new google.maps.Map(mapDiv, {
    center: {lat: 30.2849, lng: -97.7341},
    zoom: 16
  });//TODO: center on user's location
  //Set map height to fit between header and footer
  var headerHeight = document.getElementById("header").clientHeight;
  var footerHeight = document.getElementById("footer").clientHeight;
  document.getElementById('map').style.height = (window.innerHeight - headerHeight - footerHeight) + 'px';
  //Set header position to fixed
  document.getElementById("header").style.position = "fixed";
  //TODO: remove 'Map' from menu

  // Ability to place marker for a new court's location
  google.maps.event.addListener(map, 'click', function(event) {
    placeMarker(event.latLng);
  });
}


function addCourt(marker) {
//  marker.location;

  if(confirm("Adding New Court"))
  {
    // call php function databaseFacade-> add court data
  }

}
function placeMarker(location) {
  if ( marker ) {
    marker.setPosition(location);
    marker.visible = true;
  } else {
    marker = new google.maps.Marker({
      position: location,
      label: "+",
      map: map
    });
    marker.addListener('click', function(){addCourt(marker);});
  }
}
