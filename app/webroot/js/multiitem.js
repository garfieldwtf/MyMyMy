/*
 * Javascript for mutliitem helper
 * by Teow Jit Huan
 */


var $j = jQuery.noConflict();

// Compare two options within a list by VALUES
function compareOptionValues(a, b){ 
    // Radix 10: for numeric values; Radix 36: for alphanumeric values
    var sA = parseInt( a.value, 36 );  
    var sB = parseInt( b.value, 36 );  
    return sA - sB;
}

// Compare two options within a list by TEXT
function compareOptionText(a, b) { 
    // Radix 10: for numeric values;Radix 36: for alphanumeric values
    var sA = parseInt( a.text, 36 );  
    var sB = parseInt( b.text, 36 );  
    return sA - sB;
}

// Dual list move function
function moveDualList(srcList, destList, moveAll,righList,fname ){ 
    // Do nothing if nothing is selected
    if (  ( srcList.selectedIndex == -1 ) && ( moveAll == false )   ){
        return;
    }

    newDestList = new Array( destList.options.length );
    var len = 0;
    for( len = 0; len < destList.options.length; len++ ) {
        if ( destList.options[ len ] != null ){
            newDestList[ len ] = new Option( destList.options[ len ].text, destList.options[ len ].value, destList.options[ len ].defaultSelected, destList.options[ len ].selected );
        }
    }
    for( var i = 0; i < srcList.options.length; i++ ) { 
        if ( srcList.options[i] != null && ( srcList.options[i].selected == true || moveAll ) ){
            // Statements to perform if option is selected
            // Incorporate into new list
            newDestList[ len ] = new Option( srcList.options[i].text, srcList.options[i].value, srcList.options[i].defaultSelected, srcList.options[i].selected );
            len++;
        }
    }

    // Sort out the new destination list
    //newDestList.sort( compareOptionValues );   // BY VALUES
    newDestList.sort( compareOptionText );   // BY TEXT
  
    // Populate the destination with the items from the new array
    for ( var j = 0; j < newDestList.length; j++ ) {
        if ( newDestList[ j ] != null ){
            destList.options[ j ] = newDestList[ j ];
        }
    }

    // Erase source list selected elements
    for( var i = srcList.options.length - 1; i >= 0; i-- ) { 
        if ( srcList.options[i] != null && ( srcList.options[i].selected == true || moveAll ) ){
            // Erase Source
            srcList.options[i]       = null;
        }
    }
    
    hidlist(fname,righList);
    
}

//send the selected value in data[fieldname]
function hidlist(fname,righList){
    fname1=fname+'_hidden';
    r='<input type=\"hidden\" id=\"data['+fname+'][edit]\" name=\"data['+fname+'][edit]\" value=1><br/>';
    for( var i = righList.options.length - 1; i >= 0; i-- ) { 
       r+= '<input type=\"hidden\" id=\"data['+fname+']['+i+']\" name=\"data['+fname+']['+i+']\" value='+righList.options[i].value+'><br/>';
    }
    e = document.getElementById(fname1);
    e.innerHTML = r;
}

//add new data
function addNew(fname,listLefts,listRights){
    
    //add new item name
    text='Please enter new '+fname+' name.';
    jPrompt(text, ' ','Add new '+fname,function(name){
        
        //advoid the null data
        if(name!=null && name!="" && name!=" "){
            //add new unique value
            var vvalue=virtualValue(listLefts,listRights);
    
            //add the added data in the right list
            var newItem = new Option( name, vvalue, false, false );
            listRights.options[ listRights.options.length ] = newItem;
        
            //send the selected value in data[fieldname_add]
            fname2=fname+'_add';
            s= '<input type=\"hidden\" id=\"data['+fname2+']['+vvalue+']\" name=\"data['+fname2+']['+vvalue+']\" value="'+name+'"><br/>';
            f = document.getElementById(fname2);
            f.innerHTML += s;
    
            //resend the selected value in data[fieldname]
            hidlist(fname,listRights);
        }
        
    });
   
}

//give the unique value for new item
function virtualValue(leftList,righList){
    var j=0;
    do{
        var a='A'+j;
        var k=0;
        //in array?
        for( var i = righList.options.length - 1; i >= 0; i-- ) { 
            if (a==righList.options[i].value){ k++;}
        }
        for( var i = leftList.options.length - 1; i >= 0; i-- ) { 
            if (a==leftList.options[i].value){ k++;}
        }
        if(k==0){ return a; }
        j++;
    }while (k>0);
}

function moveImplementor(lft1,lft2,rght,fname){
	// Do nothing if nothing is selected
	var left=new Array(2);
	left[0]=lft1;
	left[1]=lft2;
	var lname=new Array(2);
	lname[0]='User';
	lname[1]='Group2';

   	if (  ( left[0].selectedIndex == -1 ) && ( left[1].selectedIndex == -1  )   ){
        return;
    }

    newDestList = new Array(rght.options.length );
    var len = 0;
    for( len = 0; len < rght.options.length; len++ ) {
        if ( rght.options[ len ] != null ){
            newDestList[ len ] = new Option( rght.options[ len ].text, rght.options[ len ].value, rght.options[ len ].defaultSelected, rght.options[ len ].selected );
        }
    }
	
    //process left list

	var l = 0;
    for( l = 0; l< left.length; l++ ) {	
    	srcList=left[l];
    	for( var i = 0; i < srcList.options.length; i++ ) { 
        	if ( srcList.options[i] != null && ( srcList.options[i].selected == true ) ){
            	// Statements to perform if option is selected
            	// Incorporate into new list
            	newDestList[ len ] = new Option( srcList.options[i].text, lname[l]+srcList.options[i].value, srcList.options[i].defaultSelected, srcList.options[i].selected );
            	len++;
        	}
    	}
	}

    // Sort out the new destination list
    newDestList.sort( compareOptionText );   // BY TEXT
    
    // Populate the destination with the items from the new array
    for ( var j = 0; j < newDestList.length; j++ ) {
        if ( newDestList[ j ] != null ){
            rght.options[ j ] = newDestList[ j ];
        }
    }
    // Erase source list selected elements
    var l = 0;
    for( l = 0; l< left.length; l++ ) {
		srcList=left[l];
    	
    	for( var i = srcList.options.length - 1; i >= 0; i-- ) { 
        	if ( srcList.options[i] != null && ( srcList.options[i].selected == true) ){
            	// Erase Source
            	srcList.options[i]= null;
        	}
    	}
	}
    hidlist(fname,rght);
}

function backImplementor(lft1,lft2,rght,fname){
	// Do nothing if nothing is selected
	var left=new Array(2);
	left[0]=lft1;
	left[1]=lft2;
	var lname=new Array(2);
	lname[0]='User';
	lname[1]='Group2';

   	if ( ( rght.selectedIndex == -1 ) ){
        return;
    }

    for( var i = 0; i < rght.options.length; i++ ) { 
        if ( rght.options[i] != null && ( rght.options[i].selected == true ) ){
            // Statements to perform if option is selected
            a=' '+rght.options[i].value;
            for(var l = 0; l< left.length; l++ ) {
                if(a.indexOf(lname[l])==1){
                    b=left[l];
                    newDestList = new Array(b.options.length );
                    var len = 0;
                    for( len = 0; len < b.options.length; len++ ) {
                        if ( b.options[ len ] != null ){
                            newDestList[ len ] = new Option( b.options[ len ].text, b.options[ len ].value, b.options[ len ].defaultSelected, b.options[ len ].selected );
                        }
                    }
                    newDestList[ len ] = new Option( rght.options[i].text, rght.options[i].value.replace(lname[l],''), rght.options[i].defaultSelected, rght.options[i].selected );
                    len++;
                    
                    // Sort out the new destination list
                    newDestList.sort( compareOptionText );   // BY TEXT
    
                    // Populate the destination with the items from the new array
                    for ( var j = 0; j < newDestList.length; j++ ) {
                        if ( newDestList[ j ] != null ){
                            b.options[ j ] = newDestList[ j ];
                        }
                    }
                }
            }
               
        }
    }
	

    // Erase source list selected elements
    for( var i = rght.options.length - 1; i >= 0; i-- ) { 
        if ( rght.options[i] != null && ( rght.options[i].selected == true) ){
            // Erase Source
            rght.options[i]= null;
        }
    }
	
    hidlist(fname,rght);

}
