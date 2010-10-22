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

class Template extends AppModel {

	var $name = 'Template';
	var $validate = array(
		'foreign_key' => array('numeric')
	);
    
    
    //to retrieve the system template or duplicate the template
    function duplicate($conditions,$model,$foreign_key){
        $templates=$this->find('all',array('conditions'=>$conditions));
        foreach($templates as $tem){
            $template1=$this->find('first',array('conditions'=>array('Template.type'=>$tem['Template']['type'],'Template.model'=>$model,'Template.foreign_key'=>$foreign_key)));
            if(!empty($template1)){
                $tem['Template']['id']=$template1['Template']['id'];
            }
            else{
                $this->create();
                unset($tem['Template']['id']);
            }
            $tem['Template']['model']=$model;
            $tem['Template']['foreign_key']=$foreign_key;
            $this->save($tem);
        }
    }

}
?>
