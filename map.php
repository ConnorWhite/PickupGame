<?php
  session_start();

  $title = "Map | Pickup Game";
  include 'header.php';
  include 'DatabaseFacade.php';



  #for the _SESSION_ID
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $function = $_POST['function'];
      switch($function) {

  		case('setCourtSession'):
      $CourtID = $_POST['CourtID'];
      $_SESSION['CourtID']  = $CourtID;
      echo $_SESSION['CourtID'];
      break;
    }
  }

?>

<link rel="stylesheet" href="jquery_form/jquery-ui.css">
<script src="jquery_form/external/jquery/jquery.js"></script>
<script src="jquery_form/jquery-ui.js"></script>



<div id="addCourtDialog" title="New Court Form">
    <p>Input court name</p>
    <input id="addCourtName" class="myInput" type="text" />
</div>

<div id="courtInfoDialog" title="DynamicCourtTitle">
  <div id="dynamicCourtInfoTextCourtInfo"></div>
  <div id="dynamicCourtInfoTextCourtGameInfo"></div>
</div>


<div id="map">
  <!-- Display all courts -->
  <!-- Create plus button for adding a new court -->
  <!-- All done in map.js -->
</div>



<?php
  include('footer.php');
?>
  <script src="/PickupGame/js/map.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwnIsjQZQW9yw5-Bw5ZRejW4_smZbdwPQ&sensor=true&callback=initMap" async defer></script>
