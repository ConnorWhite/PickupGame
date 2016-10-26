var map;
// In the following example, markers appear when the user clicks on the map.
// Each marker is labeled with a single alphabetical character.
var labels = '+';
var labelIndex = 0;
var addCourtMarker; // a marker for holding the add Court marker
var courtDisplayMarkers; // an array of markers for holding all court view markers to be displayed

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
    placeMarker(event.latLng, true, addCourtMarker);
  });
}

// Function for handling a add court REQUEST
// Input: marker | variable for holding the...
// ...court data that is to be added to the database
function addCourt(marker) {
//  marker.location;
  if(confirm("Adding New Court"))
  {
    // call php function databaseFacade-> add court data
    // display new court pin on map
  }

}

// Function that stores all courts
// currently in the database, as markers
// in the courtDisplayMarkers array
function initCourtDisplayMarkers()
{
  
}

// Function that is added as a listener
// If a marker is double clicked
// This function will take the user to that court.php's page
// Based on the input marker
function takeUserToTheRequestedCourtPage(marker)
{

}

// Function for placing a court marker
// for displaying all the courts a user can
function placeCourtMarker(marker)
{

}
// Function for placing a marker
// The marker is either for a potential court to be added as requested by the user
// Or, the marker is for having a court's
// The two use cases is determined by the courtAddFlag
function placeMarker(location, courtAddFlag, marker) {
  if ( marker ) {
    marker.setPosition(location);
    marker.visible = true;
  } else if(courtAddFlag == true){
    marker = new google.maps.Marker({
      position: location,
      label: "+",
      map: map
    });
  } else { // else if( courtAddFlag == false)
    // In my design plan, this should never happen
    // all markers for viewing a court should be created already
    // in intMap()
  }

  if( courtAddFlag == true ) // we know this marker is for a potential court to be added
    marker.addListener('click', function(){addCourt(addCourtMarker);});
  else { // we know that this marker is for a court already in the data base
    // used for displaying that court's location on the google map
    // click on that marker brings up the court's info text
    // double clicking on that marker brings the user to that specific court's .php page
    marker.addListener('click', function(marker) {
      viewCourtInfo(marker);
    });
    marker.addListener('dblclick', function(marker) {
      takeUserToTheRequestedCourtPage(marker);
    });
  }
}
