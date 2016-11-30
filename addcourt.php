<?php
  session_start();
  include 'DatabaseFacade.php';

  $courtName = $_POST['courtName'];
  $lat = $_POST['lat'];
  $lon = $_POST['lon'];
  $courtID = addCourt($courtName, $lat, $lon);
  header('Location: court.php?courtID='.$courtID);
