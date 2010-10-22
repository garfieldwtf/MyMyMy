/*
 * javascript code to call the balloon style confirm box
 * 
 * by Teow Jit Huan
 */ 

$j(document).ready(function() {
    /*delete*/
    $j('.confirmdelete').jConfirmAction({question : "Are you sure<br/>to delete this item?", yesAnswer : "Yes", cancelAnswer : "No"});		
    $j('.pastihapus').jConfirmAction({question : "Adakah anda pasti<br/>untuk hapuskan butiran ini?", yesAnswer : "Ya", cancelAnswer : "Tidak"});
    /*reset password*/		
    $j('.confirmreset').jConfirmAction({question : "Are you sure to reset<br/>the password for this user?", yesAnswer : "Yes", cancelAnswer : "No"});		
    $j('.pastireset').jConfirmAction({question : "Adakah anda pasti untuk set <br/>semula kata laluan pengguna?", yesAnswer : "Ya", cancelAnswer : "Tidak"});		
    $j('.confirmedit').jConfirmAction({question : "Are you sure<br/>to change this member's role ?", yesAnswer : "Yes", cancelAnswer : "No"});		
    $j('.pastikemaskini').jConfirmAction({question : "Adakah anda pasti<br/>untuk kemaskini peranan ahli ini?", yesAnswer : "Ya", cancelAnswer : "Tidak"});		
    $j('.confirmedit1').jConfirmAction({question : "Your priviledge will be changed, are you sure to proceed?", yesAnswer : "Yes", cancelAnswer : "No"});		
    $j('.pastikemaskini1').jConfirmAction({question : "Hak anda akan diubahkan, adakah anda pasti?", yesAnswer : "Ya", cancelAnswer : "Tidak"});		
    $j('.confirmretrieve').jConfirmAction({question : "This edited templates will lost,<br/>are you sure to retrieve?", yesAnswer : "Yes", cancelAnswer : "No"});		
    $j('.pastidapat').jConfirmAction({question : "Templat ini akan dipulihkan,<br/>adakah anda pasti?", yesAnswer : "Ya", cancelAnswer : "Tidak"});		
});


/*
 * jQuery Plugin : jConfirmAction
 * 
 * by Hidayat Sagita
 * http://www.webstuffshare.com
 * Licensed Under GPL version 2 license.
 *
 */
(function($){

	jQuery.fn.jConfirmAction = function (options) {
		
		// Some jConfirmAction options (limited to customize language) :
		// question : a text for your question.
		// yesAnswer : a text for Yes answer.
		// cancelAnswer : a text for Cancel/No answer.
		var theOptions = jQuery.extend ({
			question: "Are You Sure ?",
			yesAnswer: "Yes",
			cancelAnswer: "Cancel"
		}, options);
		
		return this.each (function () {
			
			$(this).bind('click', function(e) {

				e.preventDefault();
				thisHref	= $(this).attr('href');
                
                //if the clicked link have rightbutton class
                if($(this).attr('class').indexOf('rightbutton')>=0){
                    if($(this).next('.questionright').length <= 0){
                        $(this).after('<div class="questionright">'+theOptions.question+'<br/> <span class="yes">'+theOptions.yesAnswer+'</span><span class="cancel">'+theOptions.cancelAnswer+'</span></div>');
                    }
                    $(this).next('.questionright').animate({opacity: 1}, 300);
				
                    $('.yes').bind('click', function(){
                        window.location = thisHref;
                    });
		
                    $('.cancel').bind('click', function(){
                        $(this).parents('.questionright').fadeOut(300, function() {
                            $(this).remove();
                        });
                    });
                    
                }else{
				
                    if($(this).next('.question').length <= 0){
                        $(this).after('<div class="question">'+theOptions.question+'<br/> <span class="yes">'+theOptions.yesAnswer+'</span><span class="cancel">'+theOptions.cancelAnswer+'</span></div>');
                    }
                    $(this).next('.question').animate({opacity: 1}, 300);
				
                    $('.yes').bind('click', function(){
                        window.location = thisHref;
                    });
		
                    $('.cancel').bind('click', function(){
                        $(this).parents('.question').fadeOut(300, function() {
                            $(this).remove();
                        });
                    });
                }
				
            });
			
		});
	}
	
})(jQuery);

