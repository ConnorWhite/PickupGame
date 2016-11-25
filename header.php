<?php
  include 'head.php';
?>
  <header id="header">
    <div class="wrap">
      <h1 id="title"><?php echo $title; ?></h1>
      <div id="menu">
        <ul>
          <li>
            <a href="/PickupGame/map.php" id="map-link">Map</a>
          </li>
          <li>
            <a href="/PickupGame/mygames.php" id="mygames-link">My Games</a>
          </li>
          <li>
            <a href="/PickupGame/" id="logout-link">Logout</a>
          </li>
        </ul>
      </div>
      <img src="/PickupGame/img/hamburger.svg" id="hamburger" />
    </div>
    <script type="text/javascript" src="/PickupGame/js/menu.js"></script>
  </header>
