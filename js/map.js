var map;
// In the following example, markers appear when the user clicks on the map.
// Each marker is labeled with a single alphabetical character.
var labels = '+';
var labelIndex = 0;
var addCourtMarker; // a marker for holding the add Court marker
var courtDisplayMarkers = []; // an array of markers for holding all court view markers to be displayed
var debug_counter = 0;
var userCenter = {lat: 30.2849, lng: -97.7341};

function initMap() {
  mapDiv = document.getElementById('map');
  map = new google.maps.Map(mapDiv, {
    center: {lat: 30.2849, lng: -97.7341},
    zoom: 16
  });
  // find the users location if possible with HTML5 geolocation.
  var ua = navigator.userAgent.toLowerCase(), isAndroid = ua.indexOf("android") > -1, geoTimeout = '15000';
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      //infoWindow.setPosition(pos);
      //infoWindow.setContent('You are here');
      var icon = {
        url: '/PickupGame/img/placeholder.png',
        scaledSize: new google.maps.Size(32, 32),
      };
      addGeoMarker(pos, map, icon);
      // Initialize and Display the markers for all courts in database
      //Create map
      userCenter['lat'] = pos['lat'];
      userCenter['long'] = pos['lng'];
      initCourtDisplayMarkers(courtDisplayMarkers);
      map.setCenter(pos);

    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else { // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
  console.log("usercenter" + userCenter);
  //Set map height to fit between header and footer
  var headerHeight = document.getElementById("header").clientHeight;
  var footerHeight = document.getElementById("footer").clientHeight;
  document.getElementById('map').style.height = (window.innerHeight - headerHeight - footerHeight) + 'px';
  //Set header position to fixed
  document.getElementById("header").style.position = "fixed";
  // Ability to place marker for a new court's location
  google.maps.event.addListener(map, 'click', function(event) {
    addCourtMarker = placeMarker(event.latLng, true, addCourtMarker);
  });
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
}

function addGeoMarker(pos,map, icon) {
  var marker = new google.maps.Marker({
    position: pos,
    icon: icon,
    map: map
  });
}

// Function for handling a add court REQUEST
// Input: marker | variable for holding the...
// ...court data that is to be added to the database
// returns true if user decided to add a court
// returns false otherwise
function addCourt(marker) {
  if(courtAlreadyAdded(marker)){
    alert("Can't add court here. Court Already Exists!");
    return;
  }

  if(confirm("Are you sure you want to add a new court here?")){
    // display new court pin on map
    //var courtName = prompt("Please enter this new court's name", "Court Name");
    var courtNameInput = "<p>Court Name: <input type='text' name='courtName' value='Court Name'></p>";
    var courtSubmit = "<input class='submitCourt' type='submit' value='Submit'>";
    var url = "addcourt.php?lat=" + addCourtMarker.position.lat() + "&lon=" + addCourtMarker.position.lng();
    infowindow = new google.maps.InfoWindow({
      content: "<form action=" + url + " method='post'>" + courtNameInput + courtSubmit + "</form>"
    });
    infowindow.open(map, marker);
  }
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

    if(Math.abs(addedLong-addingLong) <= 0.00015 &&
      Math.abs(addedLat-addingLat) <= 0.00015)
      return true;

    /*
    if(Math.abs(addedLat-addingLat) <= 0.00015)
      return true;
    */
  }
  return false;
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
  }
}

// Function that stores all courts
// currently in the database, as markers
// in the courtDisplayMarkers array
// and then adds a listener to each of them
// and places them on the map
// returns the arrayOfMarkers made
// called in initMap() and
// called whenever a new court is added
function initCourtDisplayMarkers(arrayOfMarkers)
{
  // range in which to find the courts
  // in the database
  var range = [1,1];
  $.ajax({
    type: "GET",
    url: "process.php",
    data: {
          dataType: 'json',
         'function': 'getCourt',
         'id': 'map',
         'lat' : userCenter['lat'],
         'long': userCenter['long'],
         'rangeLat' : range[0],
         'rangeLong': range[1]
    },
    dataType: "json",
    success: function(data){
      // Store the court data
      console.log("Courts in Database: ");
      console.log(data);
      // Loop through each court,
      // and store all data from court, e.g.
      // name, id, ...
      for(var i = 0; i < data.length; i++){
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
// Or, the marker is for an existing court to be
// shown on the map
// The two use cases is determined by the courtAddFlag
// Returns the marker
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

      // add listeners to the add court marker
      // click on it to add a court
      marker.addListener('click', function(){addCourt(marker);});
    }
  }  // end if(courtAddFlag)
  else { // or else, handle displaying a court to display
    if(marker == null)
    {
      var icon = {
        url: '/PickupGame/img/pin.png',
        scaledSize: new google.maps.Size(32, 32),
      };
      var marker = new google.maps.Marker({
        position: location,
        icon: icon,
        map: map
      });
    }
    marker.setPosition(location);
    marker.visible = true;
    marker = addViewCourtMarkerListeners(marker,courtData);
  }
  return marker;
}

// function that takes in a court's marker,
// and its data pertaining to the court
// and adds a listener to the court's marker
// which listens for a click for that marker
// when clicked, the listener will set up
// a jquery UI dialog
// for the court, that will float above the map
// which contains info pertaining to the court
// and it retrieves the info of the court
// from the database everytime the
// marker is clicked, to insure the court's
// info is up to date
function addViewCourtMarkerListeners(marker,courtData)
{
  marker.addListener('click', function(){
    var courtInfo = getCourtInfo(courtData);

    // Will clean this up later
    // Didn't realize you could +
    // strings in js till a bit later
    console.log("<h1>Court Information</h1>");
    console.log(courtInfo);
    var courtTitle = "<h1>"
    .concat(courtData['Name']
    .concat("'s Info:").concat("</h1>"
    +       "<p>There are ".concat(
      courtInfo[courtInfo.length -1].toString())
      .concat(" player(s).</p>")
    ));

    courtTitle = "<h2 class=courtTitle>" + courtData['Name'] + "</h2>"+"<p class=numGames>Games: " + (courtInfo.length-1).toString() + "</p>";

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
      + " Total Player(s) for " + courtInfo[i]["GameData"]["Name"] + ":</p><br>");
    }
    var gamesInfo = "<h2>Games:<h2>".concat(games_titles);
    var infoText = courtTitle; //+ gamesInfo;
      infowindow = new google.maps.InfoWindow({
        content: " "
    });
    infowindow.setContent(infoText + '<a class="courtButt" href=/PickupGame/court.php?courtID=' + courtData['ID'] + '>View Court</a>')
    infowindow.open(map, this);
  });
  return marker;
}

// func getCourtInfo(courtData):
// Retrieves all the player
// and game data of a specific
// court specificed by the input
// and returns it as a multi dimensional array
// thus each element in the returned
// array represents the complete
// game info of that court
// so returnData[0] represents a game
// the element in returnData[0]
// then has two more arrays
// returnData[0]["PlayerData"]
// returnData[0]["GameData"]
// PlayerData array has
// all the players in that game
// and GameData has all
// the information for the game
// returnData[0]["PlayerData"][0]
// would represent one players info
// returnData[0]["GameData"]
// would represent one games info
// you can then use them with
// "ID", "Name", ...
// in the same way
// the data base has it done

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

// function used by getCourtInfo
// that actually requests the
// data from the database
function getCourtGames(courtData){
  var data_games;
  $.ajax({
    type: "GET",
    url: "/PickupGame/process.php",
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

// function used by getCourtInfo
// that actually requests the
// data from the database
function getPlayersData(gameData)
{
  var playerData;
  $.ajax({
    type: "GET",
    url: "/PickupGame/process.php",
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

/* QUnit Tests */

function mapSetup(){

  data = [];
  data[0] = { ID: 1,  Name: 'Gregory Gym', Longitude: -97.7365,  Latitude: 30.2842 };
  data[1] = { ID: 2,  Name: 'Clark Field', Longitude: -97.7355,  Latitude: 30.2814 };
  data[2] = { ID: 3,  Name:  'UT Rec Sports Center',Longitude:  -97.7328,  Latitude: 30.2823 };
  data[3] = { ID: 6,  Name: 'Adams-Hemphill Park',Longitude:  -97.7389,  Latitude: 30.2945 };
  data[4] = { ID: 12, Name: 'Toyota Center',Longitude:  -95.3621,  Latitude: 29.7506};
  data[5] = { ID: 13, Name: 'HEB',Longitude: -97.72, Latitude: 30.2999};

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
  return data;
}

QUnit.test("Map Init Marker Logic Test", function(assert) {
  mapSetup();
  assert.ok(courtDisplayMarkers.length == 6, "Passed!");
});

QUnit.test( "Add Existing Court Test", function( assert ) {
  mapSetup();
  var location = new google.maps.LatLng(30.283775,  -97.736574);

  var  marker = new google.maps.Marker({
    position: location,
    label: ".",
    map: map
  });
  assert.ok(courtAlreadyAdded(marker) == true, "Passed!");
});

QUnit.test( "Courts Range Test", function( assert ) {
  var data = mapSetup();
  var range = [1,1];
  var success = true;
  for(var i = 0; i < data.length; i++)
  {
    var addedLong = Math.abs(data[i]["Longitude"]);
    var addedLat = Math.abs(data[i]["Latitude"]);

    var addingLat = Math.abs(userCenter["lat"]);
    var addingLong = Math.abs(userCenter["lng"]);

    console.log(Math.abs(addedLat - addingLat));

    console.log(Math.abs(addedLong - addingLong));

    if(data[i]["Name"] === "Toyota Center" &&
       ( Math.abs(addedLat - addingLat) < range[0] &&
        Math.abs(addedLong - addingLong) < range[1]))
      success = false;

  }

  assert.ok( success, "Passed!" );
});

QUnit.test("Court Info Test", function(assert) {
  var data = mapSetup();

  var games = getCourtGames(data[0]);

  console.log(games);

  assert.ok(games.length == 1, "Passed!");

  var players = getPlayersData(games[0]);

  assert.ok(players.length = 3, "Passed!");

});
