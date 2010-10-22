<?php
/*
 * Helper to create a dual list input
 * by Teow Jit Huan
 * 
 */

class MultiItemHelper extends AppHelper
{
    var $helpers=array('Javascript');

    function beforeRender(){
        $view = ClassRegistry::getObject('view');
        if (is_object($view)) {
            $view->addScript($this->Javascript->link('jquery.alerts'));
            $view->addScript($this->Javascript->link('multiitem'));
        }
    }


    /*
     * $fieldname = field name
     * in $options, 
     * 'label' = label for the field, 
     * 'option' = all option
     * 'selected' = option which should be in right list
     * 'add'= enable the add new option button
     * 
     */
    function input($fieldName, $options = array()){

        //label
        if(isset($options['label'])){
            $title=$options['label'];
        }
        else{
            $title=$fieldName;
        }
        $output="<label for=\"$fieldName\">".__(ucwords($title),true)."</label>";
        
        $output.='<table border="0">';
            $output.='<tr>';
                
                //left box
                $output.='<td>';
                    $output.=$this->left_field($fieldName.'listLeft',$options);
                $output.='</td>';
                    
                //buttons    
                $output.='<td>';
                    $output.='<input type="button" class="button" style="width:130px" onclick="moveDualList( this.form.'.$fieldName.'listLeft,  this.form.'.$fieldName.'listRight, false ,this.form.'.$fieldName.'listRight,\''.$fieldName.'\');"  name="Add >>" value="'.__('Add',true).' >>"/><br/>';
                    $output.='<input type="button" class="button" style="width:130px" onclick="moveDualList( this.form.'.$fieldName.'listRight, this.form.'.$fieldName.'listLeft,  false ,this.form.'.$fieldName.'listRight,\''.$fieldName.'\')" name="Remove <<"  value="'.__('Remove',true).' <<"/><br/>';
                    $output.='<input type="button" class="button" style="width:130px" onclick="moveDualList( this.form.'.$fieldName.'listLeft,  this.form.'.$fieldName.'listRight, true  ,this.form.'.$fieldName.'listRight,\''.$fieldName.'\')" name="Add All >>"  value="'.__('Add All',true).' >>"/><br/>';
                    $output.='<input type="button" class="button" style="width:130px" onclick="moveDualList( this.form.'.$fieldName.'listRight, this.form.'.$fieldName.'listLeft,  true  ,this.form.'.$fieldName.'listRight,\''.$fieldName.'\')" name="Remove All<<"  value="'.__('Remove All',true).' <<"/><br/>';
                $output.='</td>';

                //right box
                $output.='<td>';
                    $output.=$this->right_field($fieldName,$options);
                $output.='</td>';
            $output.='</tr>';
            $output.='<tr><td colspan="2">';
            //add new item field
                if(isset($options['add']) && $options['add']==true){
                    $value=sprintf(__('Add New %s',true),__(ucfirst($fieldName),true));
                    $output.='<input type="button" class="button" value="'.$value.'" name="add" onclick="addNew(\''.$fieldName.'\',this.form.'.$fieldName.'listLeft,this.form.'.$fieldName.'listRight)"/>';
                    $output.='</td><td>';
            		$output.='<span id="'.$fieldName.'_add"></span>';
                }
            $output.='</td></tr>';
        $output.='</table>';
        
        $output.='<br/>';
        
        return $output;
    }
    
    function multiinput($left,$right,$options=null){
    	$output='<table class="multiinput">';
            $output.='<tr>';
            	$output.='<td>';
    				foreach($left as $l=>$ldata){
    					$title=isset($ldata['label'])?$ldata['label']:$l;
    					$output.="<div class='label'>".__(ucwords($title),true)."</div>";
    					$output.=$this->left_field($l,$ldata['options']).'<br/>';
    					$lname[]=$l;
					}
				$output.='</td>';
            	$output.='<td>';
            		$output.='<table>';
            			foreach($right as $r=>$rdata){
            				$output.='<tr>';
            					$output.='<td>';
    								$title=isset($rdata['label'])?$rdata['label']:$r;
                    				$output.='<input type="button" class="button" style="width:220px" onclick="moveImplementor(this.form.'.$lname[0].',this.form.'.$lname[1].',this.form.'.$r.'listRight,\''.$r.'\');"  name="Add'.$title.'" value="'.__('Add as',true).' '.$title.'>>"/><br/>';
                    				$output.='<input type="button" class="button" style="width:220px" onclick="backImplementor(this.form.'.$lname[0].',this.form.'.$lname[1].',this.form.'.$r.'listRight,\''.$r.'\');"  name="Remove'.$title.'" value="'.__('Remove',true).' '.$title.'<<"/><br/>';
            					$output.='</td>';
            					$output.='<td>';
    			
    								$output.="<div class='label'>".__(ucwords($title),true)."</div>";
    								$output.=$this->right_field($r,$rdata['options']).'<br/>';
    							$output.='</td>';
    						$output.='</tr>';
						}
					$output.='</table>';
				$output.='</td>';
			$output.='</tr>';
        $output.='</table>';
    	return $output;
    	
    	
        
    }
    
    function left_field($fieldName,$options){
        $output='<select multiple style="overflow:auto;height:130px;width:300px" name="'.$fieldName.'">';
        if(!empty($options['option']) && !empty($options['selected'])){
        	$options['option']=array_diff($options['option'],$options['selected']);
        }
        if(!empty($options['option'])){
        	foreach($options['option'] as $oid=>$oname){
            	$output.='<option value="'.$oid.'">'.$oname.'</option>';
            }
        }
        $output.='</select>';
        return $output;
    }
    
    function right_field($fieldName,$options){
    	$output='<select multiple style="overflow:auto;height:130px;width:300px" name="'.$fieldName.'listRight">';
        	if(!empty($options['selected'])){
            	foreach($options['selected'] as $sid=>$sname){
                	$output.='<option value="'.$sid.'">'.$sname.'</option>';
                }
            }
        $output.='</select>';
        $output.='<span id="'.$fieldName.'_hidden"></span>';
        return $output;
	}

}
?>
