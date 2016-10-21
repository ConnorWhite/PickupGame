function connectToServer(){
	new Ajax.Updater(  
		{ success: 'CD Count', failure: 'errors' },
		'LongPolling.php',{
			method:     'get',
			onSuccess:  function(transport){
				if (parseInt(transport.responseText)) connectToServer();
			}
	});
}
