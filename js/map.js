

var map;
// In the following example, markers appear when the user clicks on the map.
// Each marker is labeled with a single alphabetical character.
var labels = '+';
var labelIndex = 0;
var addCourtMarker; // a marker for holding the add Court marker
var courtDisplayMarkers = []; // an array of markers for holding all court view markers to be displayed
var debug_counter = 0;
var userCenter = [];

function initMap() {
  //Create dialog box for adding a court
  $( "#addCourtDialog" ).dialog({

    dialogClass : "jquery_form",
  	autoOpen: false,
  	width: 400,
  	buttons: [
  		{
  			text: "Submit",
  			click: function() {
  				$( this ).dialog( "close" );
          var courtData = [];
          courtData["CourtName"] = $('#addCourtName').val();
          courtData["Latitude"] = addCourtMarker.position.lat();
          courtData["Longitude"] = addCourtMarker.position.lng();
          addCourtLevelDialog(true, courtData);
  			}
  		},
  		{
  			text: "Cancel",
  			click: function() {
  				$( this ).dialog( "close" );
          addCourtLevelDialog(false, null);
  			}
  		}
  	]
  });






  //Create map
  userCenter['lat'] = 30.2849;
  userCenter['long'] = -97.7341;
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
    var submit_flag = $("#addCourtDialog").dialog("open");

  } else
      alert("Add Court Canceled");

  return;
}

// When user accepts the alert to add a court
// A dialog box pops out
// We add the court if the user presses submit
// We don't if else
function addCourtLevelDialog(value, courtData){

      if(value)
      {
        // call php function databaseFacade-> add court data, with the location data and court name

        // Initialize and Display the markers for all courts in database
        // Since there is now a new court in the database
        placeCourtMarker(initCourtDisplayMarkers(courtDisplayMarkers));
        console.log("new Court Data: ");
        console.log(courtData);
      }
      else{
        alert("Add Court Canceled");
      }
}

// Function that stores all courts
// currently in the database, as markers
// in the courtDisplayMarkers array
// and then adds a listener to each of them
// returns the arrayOfMarkers made
function initCourtDisplayMarkers(arrayOfMarkers)
{
    var range = [1000,1000];
  $.ajax({
    type: "GET",
    url: "process.php",
    data: {
          dataType: 'json',
         'function': 'getCourt',
         'id': 'map',
         'lat' : userCenter['lat'],
         'long': userCenter['long'],
         'rangeLat' : 10,
         'rangeLong': 10
      },
    dataType: "json",
    success: function(data){
      // Store the court data
      console.log("Courts in Database: ");
      console.log(data);

      // Loop through each court,
      // and store all data from court, e.g.
      // name, id, ...

      for(var i = 0; i < data.length; i++)
      {
        var court = data[i];

        var marker = placeMarker( new google.maps.LatLng(court["Latitude"],court["Longitude"]),
          false,
          null);
          var courtDataAndMarker = [];
          courtDataAndMarker["CourtData"] = court;
          courtDataAndMarker["Marker"] = marker;
          console.log(courtDataAndMarker);
          courtDisplayMarkers.push(courtDataAndMarker);
      }
    },
});
}

// This Function that is added as a listener
// If a marker is double clicked
// This function will take the user to that court.php's page
// Based on the input marker
function takeUserToTheRequestedCourtPage(marker)
{

}

// Function for placing a court marker
// for displaying all the courts a user can
function placeCourtMarker(markers)
{
/*  foreach ($markers as $marker) {
     placeMarker()
  }*/
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
      marker = new google.maps.Marker({
        position: location,
        label: ".",
        map: map
      });
      // TODO: add listeners for dblclick and click

    }
    marker.setPosition(location);
    marker.visible = true;
  }

  return marker;
}
