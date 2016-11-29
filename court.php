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
      //check if the numPlayers is less than 10 and make sure currentPlayer is not in game before
      //letting player join

      if (!in_array(getPlayerById($_SESSION['playerID']), getPlayers($game['ID']))) { ?>
          <input type="hidden" name="secret" value="<?php echo $game['ID']; ?>"/>
          <input type="submit" name="joingame" value="Join Game"/>
      <?php } ?>
      </form>
    <?php } ?>
    <form method="post" action="\">
      <input type="submit" name="addgame" value="Add New Game"/>
    </form>
  </div>
  <?php if(isset($_POST['addgame'])) {
    header('Location: addgame.php');
  }
  if(isset($_POST['joingame'])) {
    joinGame($_SESSION['playerID'], $_POST["secret"]);
    header('Location: court.php');
  }
  include 'footer.php';
