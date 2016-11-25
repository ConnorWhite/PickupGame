//This file opens and closes the menu

function closeMenu() {
	document.getElementById("menu").style.display = 'none';
	//document.getElementById("html").style.overflowY = 'scroll';
	document.getElementById("hamburger").removeEventListener("mouseup", closeMenu);
	document.getElementById("hamburger").removeEventListener("touchend", closeMenu);
	document.getElementById("hamburger").addEventListener("mouseup", openMenu, false);
	document.getElementById('title').onclick = function(){};//name
}

function openMenu() {
	document.getElementById("menu").style.display = 'unset';
	//document.getElementById("html").style.overflowY = 'hidden';
	document.getElementById("hamburger").removeEventListener("mouseup", openMenu);
	document.getElementById("hamburger").removeEventListener("touchend", openMenu);
	document.getElementById("hamburger").addEventListener("mouseup", closeMenu, false);
	document.getElementById('title').onclick = function(){ closeMenu(); };//name
}

function removeRedundantLinks(){
  var path = window.location.pathname;
  var page = path.substring(path.lastIndexOf('/') + 1);
  if(page == "map.php"){
    var child = document.getElementById("map-link");
    child.parentNode.removeChild(child);
  } else if(page  == "mygames.php"){
    var child = document.getElementById("mygames-link");
    child.parentNode.removeChild(child);
  }
}

closeMenu();
removeRedundantLinks();
