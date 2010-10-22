<?php

class AppModel extends Model {
    
    function replacetemplate($template,$data=null){
        $template=str_replace('%slogan',Configure::read('agency_slogan'),$template);
        preg_match_all('/(%[a-zA-Z._:]+)/',$template,$matches);
        foreach($matches[1] as $curmatch){
            $curmatch=substr($curmatch,1);
            // remove trailing . 
            if(substr($curmatch,-1,1)=='.' && Set::check($data,substr($curmatch,0,-1))){
                $curmatch=substr($curmatch,0,-1);
            }
            $fullmatch=$curmatch;
            // get the text to link to
            if(($pos=strpos($curmatch,':'))!==false){
                $text=substr($curmatch,$pos+1);
                $curmatch=substr($curmatch,0,$pos);
            }
            else{
                $text='address';
            }
            if(Set::check($data,$curmatch)){ 
                $replacedata=Set::classicExtract($data,$curmatch);
                if(strtolower(substr($curmatch,0,4))=='link'){ // if it's %Link.aaa:bbbb
                    $server=Configure::read('server_url');
                    if(($pos=strpos($server,'://'))!==false){
                        $protocol=substr($server,0,$pos).'://';
                    }elseif(isset($_SERVER["HTTPS"])){
                        $protocol='https://';
                    }else{
                        $protocol='http://';
                    }
                    if(isset($_SERVER['SERVER_NAME'])){
                        $server=$_SERVER['SERVER_NAME'];
                    }
                    $address=$protocol.$server.Router::url($replacedata);
                    if($text=='address') $text=$address;
                    $replacedata="<a href='$address'>$text</a>";
                }
                $template=str_replace('%'.$fullmatch,$replacedata,$template);
            }
        }
        return $template;
    }
    
}
?>
