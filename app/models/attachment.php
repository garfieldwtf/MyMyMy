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
class Attachment extends AppModel {

	var $name = 'Attachment';
    var $useTable="attachments";
	var $validate = array(
		'foreign_key' => array('numeric'),
		'size' => array('numeric')
	);


    //check the user is task implementor or not
    function viewPermission($att,$user_id){
        if($att['Attachment']['model']=='Task'){
            $this->Implementor=& ClassRegistry::init('Implementor');
            $this->Implementor->recursive=-1;
            if($this->Implementor->find('count',array('conditions'=>array('user_id'=>$user_id,'task_id'=>$att['Attachment']['foreign_key'])))){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

}
?>
