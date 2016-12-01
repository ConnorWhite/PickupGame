<?php
  session_start();
  include 'DatabaseFacade.php';

  $courtName = $_POST['courtName'];
  $lat = $_GET['lat'];
  $lon = $_GET['lon'];
  $courtID = addCourt($courtName, $lat, $lon);
  header('Location: court.php?courtID='.$courtID);
