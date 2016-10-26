<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $function = $_POST['function'];
	$id = $_POST['id'];
    
    $log = array();
    
    switch($function) {
    
    	 case('getChatState'):
		 	 $chatlog = "chat/logs/$id.txt";
        	 if(file_exists($chatlog)){
               $lines = file($chatlog);
        	 }
             $log['state'] = count($lines); 
        	 break;	
    	
    	 case('updateChat'):
		 	$chatlog = "chat/logs/$id.txt";
        	$state = $_POST['state'];
        	if(file_exists("$chatlog")){
        	   $lines = file("$chatlog");
        	 }
        	 $count =  count($lines);
        	 if($state == $count){
        		 $log['state'] = $state;
        		 $log['text'] = false;
        		 
        		 }
        		 else{
        			 $text= array();
        			 $log['state'] = $state + count($lines) - $state;
        			 foreach ($lines as $line_num => $line)
                       {
        				   if($line_num >= $state){
                         $text[] =  $line = str_replace("\n", "", $line);
        				   }
         
                        }
        			 $log['text'] = $text; 
        		 }
        	  
             break;
    	 
    	 case('sendChat'):
			$chatlog = "chat/logs/$id.txt";
			$nickname = htmlentities(strip_tags($_POST['nickname']));
			$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			$message = htmlentities(strip_tags($_POST['message']));
			if(($message) != "\n"){
				if(preg_match($reg_exUrl, $message, $url)) {
       				$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
					fwrite(fopen("$chatlog", 'a'), "<span>". $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n"); 
				}
			}
			break;
	}
	echo json_encode($log);
?>
