<?php
  session_start();
  $title = "Pickup Game";
  include 'header.php';
?>

<div id="map">
  <!-- TODO: Display all courts -->
  <!-- TODO: Create plus button for adding a new court -->
</div>

<?php
  include('footer.php');
?>
  <script src="/PickupGame/js/map.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBwnIsjQZQW9yw5-Bw5ZRejW4_smZbdwPQ&callback=initMap" async defer></script>
