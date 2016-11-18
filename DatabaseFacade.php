<?php
  include 'DatabaseManager.php';

  define("COURT_TABLE", "Court");
  define("GAME_TABLE", "Game");
  define("MESSAGE_TABLE", "Message");
  define("PLAYER_TABLE", "Player");
  define("PLAYER_GAME_TABLE", "PlayerGame");

  //Input: player name, password
  //Output: player ID
  function addPlayer($name, $pass){
    return addRow(PLAYER_TABLE, array("Name", "Password"), array($name, $pass));
  }

  // Input: gameID
  // Output: array of players associated with GameID
  function getPlayers($gameID)
  {

    $playerGameMap = getRows(PLAYER_GAME_TABLE, "GameID", $gameID);

    $players = array();
    foreach ($playerGameMap as $playerGame){

      $player = getPlayerByID($playerGame["PlayerID"]);
      array_push($players, $player);
    }
    return $players;
  }

  //Input: player name
  //Ouput: player
  function getPlayerByName($name){
    return getRow(PLAYER_TABLE, "Name", $name);
  }

  //Input: player ID
  //Ouput: player
  function getPlayerById($id){
    return getRow(PLAYER_TABLE, "ID", $id);
  }

  //Input: game
  //Output: gameID
  function addGame($name, $date, $courtID) {
    return addRow(GAME_TABLE, array("Name", "Date", "CourtID"), array($name, $date, $courtID));
  }

  //Input: game ID
  //Ouput: game
  function getGameByID($id){
    return getRow(GAME_TABLE, "ID", $id);
  }

  //Input: player ID
  //Output: list of games player has joined
  function getGamesByPlayerID($playerID){
    $playerGameMap = getRows(PLAYER_GAME_TABLE, "PlayerID", $playerID);
    $games = array();
    foreach ($playerGameMap as $playerGame){
      $game = getGameByID($playerGame["GameID"]);
      array_push($games, $game);
    }
    return $games;
  }

  // Input: playerId, gameId
  // Output: sql query
  function joinGame($playerID, $gameId){
    return addRow(PLAYER_GAME_TABLE, array("PlayerID", "GameID"), array($playerID, $gameId));
  }

  // Input: Name, Lat, Long, Helpful note: Google maps convention: (lat,long)
  // Output: courtID Test
  function addCourt($name, $lat, $long){
    return addRow(COURT_TABLE, array("Name", "Longitude", "Latitude"), array($name, $long, $lat));
  }

  //Input: courtID
  //Ouput: list of games scheduled for that court
  function getGamesByCourtID($courtID){
    $games = getRows(GAME_TABLE, "CourtID", $courtID);
    return $games;
  }

  //Input: court ID
  //Output: court
  function getCourtByID($id){
    return getRow(COURT_TABLE, "ID", $id);
  }

  //Input: longitude, latitude, [lat range, lon range]
  //Output: list of all Courts within range of ($lat, $lon)
  function getCourtsInRange($latitude, $longitude, $ranges){
    $cols = array("Longitude", "Latitude");
    $vals = array($longitude, $latitude);
    return getRowsByRange(COURT_TABLE, $cols, $vals, $ranges);
  }

  //TODO
  function deleteGame($gameId){
    //Delete game from game table
    //Delete game from playergame linking table
    //Delete messages from chat
  }
