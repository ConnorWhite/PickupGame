<?php
  include 'DatabaseManager.php';

  function getPlayer($name){
    return getRow("Player", "Name", $name);
  }
  function addPlayer($name, $pass){
    addRow("Player", array("Name", "Password"), array($name, $pass));
  }
  //TODO: Return all Courts within $range of ($lat, $lon)
  function getCourts($latitude, $longitude, $range){
    
  }
