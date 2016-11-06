<?php
  include 'DatabaseFacade.php';
  session_start();
  $_SESSION['CourtID'] = 1;
  $court = getCourtByID($_SESSION["CourtID"]);
  $title =  "Games for " . $court['Name'];
  
  var_dump(getGamesByCourtID($_SESSION['CourtID']));
  
  include 'header.php';
//comment

for ($x = 0; $x <= 6; $x++) {
    echo "<div class= \"game\">
	<h3>Game " . $x ."</h3><p>This is a paragraph.</p>
	</div>";
	}
	
  include 'footer.php';
?>
