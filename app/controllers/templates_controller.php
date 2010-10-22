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

class TemplatesController extends AppController {

	var $name = 'Templates';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Template->recursive = 0;            
        if(!empty($this->curgroup['Group']['id'])){
            $this->set('templates', $this->paginate(array('foreign_key'=>$this->curgroup['Group']['id'],'Template.model'=>'Group')));
        }else{
            $this->set('templates', $this->paginate(array('foreign_key'=>0)));
        }
	}
    
	function edit($id = null,$group_name=null) {
        if(!empty($group_name)){
            $this->set('group_name',$group_name);
            $this->set('id',$id);
        }
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Template',true)));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Template->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Template',true)));
                if(!empty($group_name)){
                    $this->redirect(array('action'=>'index',$group_name));
                }
				$this->redirect(array('action'=>'index'));
			} else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Template',true)).__('Please try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Template->read(null, $id);
		}
	}

    //retrieve template
    function retrieve($group_name, $template_id=null){
        if(empty($template_id)){
            $this->Template->duplicate(array('Template.model'=>'System'),'Group',$this->curgroup['Group']['id']);
        }else{
            $old_template=$this->Template->find('first',array('conditions'=>array('Template.id'=>$template_id)));
            $this->Template->duplicate(array('Template.model'=>'System','Template.type'=>$old_template['Template']['type']),'Group',$this->curgroup['Group']['id']);
        }
        $this->Session->setFlash(__('Template had been retrieved', true));
        $this->redirect(array('action'=>'index',$group_name));
    }
    
    function guide() {
    }

}
?>
