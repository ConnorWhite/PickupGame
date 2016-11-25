<?php
  include 'DatabaseFacade.php';

  //Test addPlayer and getPlayer
  addPlayer("TestPlayer", "password");
  $player = getPlayerByName("TestPlayer");
  echo $player;

  //Test getPlayerById
  $playerID = $player["ID"];
  $player = getPlayerById($playerID);
  echo $player;

  //Test addCourt and getCourtsInRange
  addCourt("TestCourt", 0, 0);
  $courts = getCourtsInRange(0, 0, 5);
  echo $courts;

  //Test getCourtByID
  $courtID = $courts[0]["ID"];
  $court = getCourtByID($courtID);
  echo $court;

  //Test addGame and getGamesByCourtID
  addGame("TestGame", "NOW()", $courtID);
  $games = getGamesByCourtID($courtID);
  echo $games;

  //Test getGameByID
  $gameID = $games[0]["ID"];
  $game = getGameByID($gameID);
  echo $game;
