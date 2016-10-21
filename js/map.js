var map;
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
}
