/** Chat Engine
 * date: 10/21/16
 */

var instanse = false;
var state;
var mes;
var file;

function Chat () {
    this.update = updateChat;
    this.send = sendChat;
	this.getState = getStateOfChat;
}

//gets the state of the chat
function getStateOfChat(){
	id = get('gameID');
	if(!instanse){
		 instanse = true;
		 $.ajax({
			   type: "POST",
			   url: "process.php",
			   data: {  
			   			'function': 'getChatState',
						'id': id
						},
			   dataType: "json",
			
			   success: function(data){
				   state = data.state;
				   instanse = false;
			   },
		});
	} return instanse;	 
}

//Updates the chat
function updateChat(){
	id = get('gameID');
	if(!instanse){
		 instanse = true;
	     $.ajax({
			   type: "POST",
			   url: "process.php",
			   data: {  
			   			'function': 'updateChat',
						'state': state,
						'id': id
						},
			   dataType: "json",
			   success: function(data){
				   if(data.text){
						for (var i = 0; i < data.text.length; i++) {
                            $('#chat-area').append($("<p>"+ data.text[i] +"</p>"));
                        }								  
				   }
				   document.getElementById('chat-area').scrollTop = 
				   		document.getElementById('chat-area').scrollHeight;
				   instanse = false;
				   state = data.state;
			   },
			});
	 }
	 else {
		 setTimeout(updateChat, 1500);
	 } return instanse;
}

//send the message
function sendChat(message, nickname){       
    updateChat();
	id = get('gameID');
     $.ajax({
		   type: "POST",
		   url: "process.php",
		   data: {  
		   			'function': 'sendChat',
					'message': message,
					'nickname': nickname,
					'id': id
				 },
		   dataType: "json",
		   success: function(data){
			   updateChat();
		   },
		});
}

function get(name){
	if(name=(new RegExp(
		'[?&]'+encodeURIComponent(name)+'=([^&]*)'))
		.exec(location.search))
    	return decodeURIComponent(name[1]);
	else{
		return 'chat';
	}
}
