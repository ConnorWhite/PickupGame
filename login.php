<?php include 'head.php'
?>
<html lang="en">
  <div id="login">
    <h1>Pickup Game</h1>
    <head>
      <meta name="google-signin-scope" content="profile email">
      <meta name="google-signin-client_id" content="1027363779831-uegm0phf52h2g6ijaqds1t1h788h7rpf.apps.googleusercontent.com">
      <script src="https://apis.google.com/js/platform.js" async defer></script>
      <body>
        <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
        <script>
function onSignIn(googleUser) {
    // Useful data for your client-side scripts:
    var profile = googleUser.getBasicProfile();
    console.log("ID: " + profile.getId()); // Don't send this directly to your server!
    console.log('Full Name: ' + profile.getName());
    console.log('Given Name: ' + profile.getGivenName());
    console.log('Family Name: ' + profile.getFamilyName());
    console.log("Image URL: " + profile.getImageUrl());
    console.log("Email: " + profile.getEmail());

    // The ID token you need to pass to your backend:
    var id_token = googleUser.getAuthResponse().id_token;
    console.log("ID Token: " + id_token);

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            var win = window.open('map.php');
        }
    }

    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var parameters = "name="+ profile.getName() + "&pass=" + googleUser.getAuthResponse().id_token;
    xmlhttp.send(parameters);

};
        </script>
      <a href="#" onclick="signOut();">Sign out</a>
      <script>
function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
    });
}
      </script>
    </body>
    </head>
  </div>
</html>
