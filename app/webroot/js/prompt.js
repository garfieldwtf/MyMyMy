$j(document).ready(function() {	

	//select all the a tag with name equal to modal
	$j('a[name=modal]').click(function(e) {
		//Cancel the link behavior
		e.preventDefault();
        
        //find location of unlock icon
        var loc=document.getElementById($j(this).attr('id'));
        var curtop = 0;
        while(loc.offsetParent){
            curtop += loc.offsetTop;
            if(loc.offsetParent){
                loc = loc.offsetParent;
            }
        }
         
		//Get the A tag
		var id = $j(this).attr('href');

		//Get the screen height and width
		var maskHeight = $j(document).height();
		var maskWidth = $j(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$j('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$j('#mask').fadeIn(1000);	
		$j('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $j(window).height();
		var winW = $j(window).width();
              
		//Set the popup window to center
		$j(id).css('top',  curtop-$j(id).height());
		$j(id).css('left', winW/2-$j(id).width()/2);
	
		//transition effect
		$j(id).fadeIn(2000); 
	
	});
	
	//if close button is clicked
	$j('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$j('#mask').hide();
		$j('.window').hide();
	});		
	
	//if mask is clicked
	$j('#mask').click(function () {
		$j(this).hide();
		$j('.window').hide();
	});			
	
});
