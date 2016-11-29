// get the user name from sessionID instead (works)


id = get('id');
if(!id){
	id = 'chat';
}
var name = null;
  $.ajax({
    type: "GET",
    url: "process.php",
    data: {
          dataType: 'json',
         'function': 'getPlayerByID',
         'id': id
      },
      dataType: "json",
      success: function(data){
          console.log("get player name success!");
          console.log(data);
		  if(data){ name = data["Name"]; }
    },
    async: false
});

// default name is 'Guest'
if (!name || name === ' ' || name === 'null') {
   name = "Guest";	
}

// ask user for name with popup prompt    
name = prompt("Enter your chat name:", name);

// strip tags
name = name.replace(/(<([^>]+)>)/ig,"");

// display name on page
$("#name-area").html("You are: <span>" + name + "</span>");

// kick off chat
var chat =  new Chat();
$(function() {

	 chat.getState(); 
	 
	 // watch textarea for key presses
	 $("#sendie").keydown(function(event) {  
	 
		 var key = event.which;  
   
		 //all keys including return.  
		 if (key >= 33) {
		   
			 var maxLength = $(this).attr("maxlength");  
			 var length = this.value.length;  
			 
			 // don't allow new content if length is maxed out
			 if (length >= maxLength) {  
				 event.preventDefault();  
			 }  
	 }});
	 // watch textarea for release of key press
	 $('#sendie').keyup(function(e) {	
						 
		  if (e.keyCode == 13) { 
		  
			var text = $(this).val();
			var maxLength = $(this).attr("maxlength");  
			var length = text.length; 
			 
			// send 
			if (length <= maxLength + 1) { 
			 
				chat.send(text, name);	
				$(this).val("");
				
			} else {
			
				$(this).val(text.substring(0, maxLength));
				
			}	
			
			
		  }
	 });
	
});

