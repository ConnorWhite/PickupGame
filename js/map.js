

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
          courtData["Name"] = $('#addCourtName').val();
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
  initCourtDisplayMarkers(courtDisplayMarkers);

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
  if(courtAlreadyAdded(marker))
  {
    alert("Can't add court here. Court Already Exists!");
    return;
  }

  if(confirm("Are you sure you want to add a new court here?"))
  {
    // display new court pin on map
    //var courtName = prompt("Please enter this new court's name", "Court Name");
    var submit_flag = $("#addCourtDialog").dialog("open");

  } else
      alert("Add Court Canceled");

  return;
}

// Returns true if court already added
// False else TODO
function courtAlreadyAdded(marker) {
  for(var i = 0; i < courtDisplayMarkers.length; i++)
  {
    var addedLong = Math.abs(courtDisplayMarkers[i]["CourtData"]["Longitude"]);
    var addedLat = Math.abs(courtDisplayMarkers[i]["CourtData"]["Latitude"]);

    var addingLat = Math.abs(marker.position.lat());
    var addingLong = Math.abs(marker.position.lng());

    if(Math.abs(addedLong-addingLong) <= 0.0003)
      return true;

    if(Math.abs(addedLat-addingLat) <= 0.0003)
      return true;


  }
  return false;
}
// When user accepts the alert to add a court
// A dialog box pops out
// We add the court if the user presses submit
// We don't if else
function addCourtLevelDialog(value, courtData){
/*
      if(courtAlreadyAdded(courtData))
      {
        $( "#addCourtDialog" ).close();
        alert("Court Already Exists!");
      }*/

      if(value)
      {
        // call php function databaseFacade-> add court data, with the location data and court name

        // Initialize and Display the markers for all courts in database
        // Since there is now a new court in the database
        console.log("new Court Data: ");
        console.log(courtData);

        $.ajax({
          type: "POST",
          url: "process.php",
          data: {
                dataType: 'json',
               'function': 'addCourt',
               'id': 'map',
               'name': courtData['Name'],
               'lat' : courtData['Latitude'],
               'long': courtData['Longitude'],

            },
            success: function(data){
                console.log("database add Success");
                console.log(data);
                courtDisplayMarkers = [];
                addCourtMarker.visible = false;
                initCourtDisplayMarkers(courtDisplayMarkers);
            }
      });
/*
      var location = new google.maps.LatLng(
        courtData['Latitude'], courtData['Longitude']);

      var  marker = new google.maps.Marker({
          position: location,
          label: ".",
          map: map
        });

      addCourtMarker.visible = false;

      // Add the court the the array that contains all the courts
      var courtDataAndMarker = [];
      courtDataAndMarker["CourtData"] = courtData;
      courtDataAndMarker["Marker"] = addViewCourtMarkerListeners(marker,courtData);
      courtDisplayMarkers.push(courtDataAndMarker) */
      } // end if(value)
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
          null,
          court);
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
function takeUserToTheRequestedCourtPage(courtData)
{
  $.ajax({
    type: "POST",
    url: "map.php",
    data: {
          dataType: 'json',
         'function': 'setCourtSession',
         'CourtID' : courtData['ID']
      },
      success: function(data){
        console.log("court session: " +data);
        window.location = "court.php"; //TODO
    },
});
}

// Function for placing a marker
// The marker is either for a potential court to be added as requested by the user
// Or, the marker is for having a court's
// The two use cases is determined by the courtAddFlag
// Returns the marker, for use for adding a court
function placeMarker(location, courtAddFlag, marker,courtData) {

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
    marker = addViewCourtMarkerListeners(marker,courtData);
  }

  return marker;
}
// TODO: I will add more comments for the new functions- ziping
function addViewCourtMarkerListeners(marker,courtData)
{
  marker.addListener('click', function(){
    $( "#courtInfoDialog" ).dialog({

      dialogClass : "jquery_form",
      title : "Court | ".concat(courtData['Name']),
      autoOpen: false,
      width: 400,
      buttons: [
        {
          text: "Go to Court",
          click: function() {
            takeUserToTheRequestedCourtPage(courtData);
          }
        } ]
    }).css("font-size", "12px");;

    // Will clean this up later
    // Didn't realize you could +
    // strings in js till a bit later
    var courtInfo = getCourtInfo(courtData);
    console.log("<h1>Court Information</h1>");
    console.log(courtInfo);
    $("#dynamicCourtInfoTextCourtInfo").html("<h1>"
    .concat(courtData['Name']
    .concat("'s Info:").concat("</h1>"
    +       "<p>There are ".concat(
          courtInfo[courtInfo.length -1].toString())
          .concat(" player(s).</p>")
        )));

    /*
    $("#dynamicCourtInfoTextCourtPlayerInfo").html(
      "<p>There are ".concat(
      courtInfo[courtInfo.length -1].toString())
      .concat(" player(s).</p>")
    ); */
    var games_titles = "";
    // I added more information than necessary,
    // for sake of proof of concept with regards
    // to using ajax in implementing
    // process.php
    for(var i = 0; i < courtInfo.length - 1; i++)
    {

      games_titles = games_titles.concat("<h3>");
      games_titles = games_titles.concat(courtInfo[i]["GameData"]["Name"].concat("</h3>"));
      games_titles = games_titles.concat("<p>There are " + courtInfo[i]["PlayerData"].length.toString()
    + " Total Player(s) for " + courtInfo[i]["GameData"]["Name"] + ":<br>");
      for(var j = 0; j < courtInfo[i]["PlayerData"].length; j++)
      {
      games_titles = games_titles.concat(courtInfo[i]["PlayerData"][j]["Name"].concat("<br>"));
      }
    }
    $("#dynamicCourtInfoTextCourtGameInfo").html("<h2>Games:<h2>"
      .concat(games_titles));

    $("#courtInfoDialog").dialog("open");
  });
  marker.addListener('dblclick', function(){takeUserToTheRequestedCourtPage(courtData);});
  return marker;
}

function getCourtInfo(courtData) {
  var returnData =[];
  var data_games;

data_games = getCourtGames(courtData);
var player_count = 0;
for(var i = 0; i < data_games.length; i++)
{
  var gpdata = [];

gpdata['PlayerData'] = getPlayersData(data_games[i]);
player_count += gpdata['PlayerData'].length;
gpdata['GameData'] = data_games[i];
returnData.push(gpdata);
}
returnData.push(player_count);
return returnData;
}

function getCourtGames(courtData){
  var data_games;
  $.ajax({
    type: "GET",
    url: "process.php",
    data: {
          dataType: 'json',
         'function': 'getCourtGames',
         'id': 'map',
         'courtID' : courtData["ID"],
      },
      dataType: "json",
      success: function(data){
          console.log("getGames success!");
          console.log(data);
          data_games = data;
          console.log(data_games);
      },
      async: false
});
  return data_games;
}

function getPlayersData(gameData)
{
  var playerData;
  $.ajax({
    type: "GET",
    url: "process.php",
    data: {
          dataType: 'json',
         'function': 'getPlayersByGameID',
         'id': 'map',
         'gameID' : gameData["ID"]
      },
      dataType: "json",
      success: function(data){
          console.log("getPlayers success!");
          console.log(data);
      playerData = data;
    },
    async: false
});

return playerData;
}
