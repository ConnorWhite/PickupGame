<?php
  include 'DatabaseManager.php';
  
  function getPlayerById($playerID){
    return getRow("Player", "ID", $playerID);
  }

  function getPlayerByName($name){
   return getRow("Player", "Name", $name);
  }
  function addPlayer($name, $pass){
    addRow("Player", array("Name", "Password"), array($name, $pass));
  }
  //Return all Courts within $range of ($lat, $lon)
  function getCourts($longitude, $latitude, $ranges){
    $cols = ["Longitude", "Latitude"];
    $vals = [$longitude, $latitude];
    return getRowsByRange("Court", $cols, $vals, $ranges);
  }
