<?php
  include 'DatabaseManager.php';

  function getPlayer($name){
    return getRow("Player", "Name", $name);
  }
  function addPlayer($name, $pass){
    addRow("Player", array("Name", "Password"), array($name, $pass));
  }
