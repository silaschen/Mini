function loading(t,w){
	if(t > 0){
        if(w != undefined) $(".lllcontent p").html(w);
		$("#loading").show();
	}else{
		$("#loading").hide();
	}
}