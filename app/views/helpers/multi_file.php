<?php
/* Task Manager is a web-based system for effective management of task delegation,
 * assignment and follow-up monitoring.
 * Copyright (C) 2010 Government Of Malaysia
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @author: Teow Jit Huan
 */

class MultiFileHelper extends AppHelper
{
    var $helpers=array('Javascript');

    function beforeRender(){
        $view = ClassRegistry::getObject('view');
        if (is_object($view)) {
            $view->addScript($this->Javascript->link('scriptaculous/lib/prototype'));
            $view->addScript($this->Javascript->link('scriptaculous/src/scriptaculous'));
            $view->addScript($this->Javascript->link('multifile'));
        }
    }

    function input($fieldName, $options = array()){
        $view =& ClassRegistry::getObject('view');
        $output="<div class=\"multifile\">";
        if(isset($options['label'])){
            $title=$options['label'];
        }
        else{
            $title=$fieldName;
        }
        $output.="<label for=\"$fieldName\">".__(ucwords($title),true)."</label>";
        $output.="<input type=\"file\" name=\"$fieldName\" id=\"$fieldName\"/>";
        $output.="<div id=\"flist$fieldName\"></div>";
        if(isset($view->data['MultiFile'][$fieldName])){
            foreach($view->data['MultiFile'][$fieldName] as $fname=>$fdat){//round(($file / 1048576), 2);
                $output.="<div><input type=\"hidden\" id=\"delold_".$fieldName.'_'.$fdat['Attachment']['id']."\" name=\"delold_".$fieldName.'_'.$fdat['Attachment']['id']."\" value=\"0\">";
                $output.="<span id=\"old_".$fieldName.'_'.$fdat['Attachment']['id']."\">".$fdat['Attachment']['filename']." (".round(($fdat['Attachment']['size'] / 1024), 2). " KB)</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $output.="<input id=\"private_".$fieldName.'_'.$fdat['Attachment']['id']."\" name=\"private_".$fieldName.'_'.$fdat['Attachment']['id']."\"  type=\"hidden\" value=0/>";
                $output.="<input type=\"button\" class='button' value=\"Delete\" onClick=\"delfile('old_".$fieldName.'_'.$fdat['Attachment']['id']."');\"/></div>";
            }
        }
        $output.="</div>";
        $output.="<script type='text/javascript'>var $fieldName=new MultiSelector(\$('flist$fieldName')); $fieldName.addElement(\$('$fieldName'));</script>";
        return $output;
    }
}
?>
