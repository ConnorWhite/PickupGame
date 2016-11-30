<?php
  session_start();
  include 'DatabaseFacade.php';

  $gameID = $_GET['gameID'];
  joinGame($_SESSION['playerID'], $gameID);
  header('Location: game.php?gameID='.$gameID);
