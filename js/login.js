function CaesarCipher(str, num) {
    // you can comment this line
    str = str.toLowerCase();
    var result = '';
    var charcode = 0;
    for (var i = 0; i < str.length; i++) {
        charcode = (str[i].charCodeAt()) + num;
        result += String.fromCharCode(charcode);
    }
    return result;
}
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
            console.log(xmlhttp.response);
            //check if the email is already in our database
            if (xmlhttp.response.indexOf("Incorrect") === -1 && xmlhttp.response.indexOf("Required") === -1) {
                console.log("You're good to go");
                var win = window.location.replace('map.php');
            }
        }
    }

    xmlhttp.open("POST", "index.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var parameters = "name="+ profile.getEmail() + "&pass=" + CaesarCipher(profile.getName() + "acaba1avadf"
        + "a;kjboiquernbiamzkjsdfiuq;kjxvoiqqlkwjerlboiuasdkflkbjzxiocvuqkqwelrkjvzoixcbqjlkjaasiqewriu103*(8134***&#$)!#@$&"
        + "a;kjboiquernbiamzkjsdfi;kjljkjxvoiqqlkwjerlboiuasdkflkbjzxiocvuqkqwelrkjvzoixcbqjlkjaasiqewriu103*(8134***&#$)!#@$&"
        + "a;kjboiquernbiamzkjsdfiuq;kjxvoiqqlkwjerlboiuasdkflkbjzxiocvuqkqwelrkjvzoixcbqjlkjaasiqewriu103*(8134***&#$)!#@$&"
        + "a;kjboiquernbiamzkjsdfiuq;kjxvoiqqlkwjerlboiuasdkflkbjzxiocvuqkqwelrkjvzoixcbqjlkjaasiqewriu103*(8134***&#$)!#@$&"
        + "a;kjboiquernbiamzkjsdfiuq;kjxvoiqqlkwjerlboiuasdkflkbjzxiocvuqkqwelrkjvzoixcbqjlkjaasiqewriu103*(8134***&#$)!#@$&", 10);
    xmlhttp.send(parameters);

};

