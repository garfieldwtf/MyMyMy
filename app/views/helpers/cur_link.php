<?php
/**
 * CurLink Helper
 * help to create a desired link or button
 *
 * @author    Teow Jit Huan
 */

class CurLinkHelper extends AppHelper
{   
    
    var $helpers = array('Html','Javascript');

    //tab
    function li($link,$key){
        if(strpos(' '.$this->params['url']['url'],$key)){
            $output='<li class="cur">';
        }else{
            $output='<li>';
        }
        $output.=$link;
        $output.='</li>';
        
        return $output;
    }
    
    //if cond, echo $link, else echo $text
    function link($text,$link,$cond){
        if($cond){
            return $link;
        }else{
            return $text;
        }
    }
    
    //add a "plus" image in the button
    function add($link){
        $output="<center><div class='buttonposition'><span class='button rightbutton'>";
        $output.=$this->Html->image('icons/add.png');
        $output.="&nbsp;";
        $output.=$link;
        $output.="</span></div></center><br/>";
        return $output;
    }
    
    //add a "back" image in the button
    function back($link){
        $output="<span class='button backbutton'>";
        $output.=$this->Html->image('icons/back.png');
        $output.="&nbsp;";
        $output.=$link;
        $output.="</span>";
        return $output;
    }
    
    //change the prompt box design
    function prompt($display,$id,$element,$option=null){
        echo $this->Javascript->link('prompt', false);
        $attr='';
        if(!empty($option)){
            foreach($option as $okey=>$o){
                $attr.=' '.$okey.'="'.$o.'"';
            }
        }
        $output='<a href="#prompt'.$id.'" id="modal" name="modal"'.$attr.'>'.$display.'</a>';
        $output.='<div id="boxes">';
            $output.='<div id="prompt'.$id.'" class="window">';
                $output.=$element;
            $output.='</div>';
            $output.='<div id="mask"></div>';
        $output.='</div>';
        return $output;
    }
    
    //change the dialog design
    function dialogPage($link,$title,$attr=null){
        echo $this->Javascript->link('jquery-effect', false);
        echo $this->Javascript->link('dialogPage', false);
        if(!empty($attr)){
            return $this->Html->link($title, '#',array_merge(array('onclick'=>"openPage('".$link."','".$title."')"),$attr));
        }
        return $this->Html->link($title, '#',array('onclick'=>"openPage('".$link."','".$title."')"));
        
    }
    
    //if allowed, will echo the link
    function permit($key,$task_permission,$link,$text=null){
    	if(in_array($key,$task_permission)){
    		return $link;
		}else{
			return $text;
		}
	}

}
?>
