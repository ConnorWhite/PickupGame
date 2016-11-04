<?php
  include 'DatabaseFacade.php';
  session_start();
  $CourtID = $_SESSION["CourtID"];
  $court = getCourtByID($CourtID);
  $title = $court['Name'];
  include 'header.php';


  $stack = array("orange", "banana");
  array_push($stack, "apple", "raspberry");
  print_r($stack);

?>

<div style="color:#0000FF">
  <h3>This is a heading</h3>
  <p>This is a paragraph.</p>
</div>

<?php
  include 'footer.php';
?>
