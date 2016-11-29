<?php
  include 'DatabaseFacade.php';
  session_start();
  //$_SESSION['playerID'] = 2; // set in login.php
  $court = null;
  if(isset($_GET["courtID"]))
  {
    $court = getCourtByID($_GET["courtID"]); // http set in mygames.php
  }
  else
  {
    $court = getCourtByID($_SESSION["CourtID"]); // session set in map.js
  }

  $title =  $court['Name'];

  $games = getGamesByCourtID($court['ID']);

  //var_dump($games);
  include 'header.php'; ?>
  <div class="wrap">

  <?php
    foreach ($games as $game) {
      include 'gameButton.php';
    }?>

    <form id="addgame" method="post" action="">
      <input type="submit" name="addgame" value="Add New Game"/>
    </form>
  </div>
  <?php if(isset($_POST['addgame'])) {
    header('Location: addgame.php');
  }
  include 'footer.php';
