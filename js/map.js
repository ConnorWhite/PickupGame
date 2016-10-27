

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

  // Initialize and Display the markers for all courts in database
  placeCourtMarker(initCourtDisplayMarkers(courtDisplayMarkers));

  // Ability to place marker for a new court's location
  google.maps.event.addListener(map, 'click', function(event) {
    addCourtMarker = placeMarker(event.latLng, true, addCourtMarker);
  });
console.log("hello3");
}


// Function for handling a add court REQUEST
// Input: marker | variable for holding the...
// ...court data that is to be added to the database
// returns true if user decided to add a court
// returns false otherwise
function addCourt(marker) {

  if(confirm("Are you sure you want to add a new court here?"))
  {
    // display new court pin on map
    //var courtName = prompt("Please enter this new court's name", "Court Name");
    $( "#dialog" ).dialog();

    marker.location;
    // call php function databaseFacade-> add court data, with the location data and court name

    // Initialize and Display the markers for all courts in database
    // Since there is now a new court in the database
    placeCourtMarker(initCourtDisplayMarkers(courtDisplayMarkers));
    return true;
  }

  return false;
}

// Function that stores all courts
// currently in the database, as markers
// in the courtDisplayMarkers array
function initCourtDisplayMarkers(arrayOfMarkers)
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
// Returns the marker, for use for adding a court
function placeMarker(location, courtAddFlag, marker) {

  if(courtAddFlag) // handle placing a add court marker
  {
    if ( marker ) {
      marker.setPosition(location);
      marker.visible = true;
    } else {
      console.log("hello\n");
      marker = new google.maps.Marker({
        position: location,
        label: "+",
        map: map
      });

      marker.addListener('click', function(){addCourt(marker);});
    }

  }  // end if(courtAddFlag)
  else { // or else, handle displaying a court to display
    if(marker == null)
    {
      throw new Error("Why you giving me a Null marker?");
    }
    marker.setPosition(location);
    marker.visible = true;
  }

  return marker;
}
