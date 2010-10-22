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

class GradesController extends AppController {

	var $name = 'Grades';
	var $helpers = array('Html', 'Form','CurLink');
	var $layout = 'tab';

	function index() {
		$this->Grade->recursive = 0;
        $this->paginate=array('order'=>array('length(Grade.rank) ASC','Grade.rank ASC'));
		$this->set('grades', $this->paginate());
	}

	function add() {
		if (!empty($this->data)) {
			$this->Grade->create();
			if ($this->Grade->save($this->data)) {
                if($this->Grade->find('first',array('conditions'=>array('Grade.rank'=>$this->data['Grade']['rank'],'Grade.grade!="'.$this->data['Grade']['grade'].'"')))){
                    $low_grades=$this->Grade->find('all',array('conditions'=>array('Grade.rank>='.$this->data['Grade']['rank'],'Grade.grade!="'.$this->data['Grade']['grade'].'"')));
                    foreach($low_grades as $g){
                        $g['Grade']['rank']+=1;
                        $this->Grade->save($g);
                    }
                }
				$this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Grade',true)));
				$this->redirect(array('action'=>'index'));
			} else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Grade',true)).__('Please try again.', true));
			}
		}
	}

	function edit($id = null) {
        $grade=$this->Grade->read(null, $id);
		if (!$id && empty($this->data)) {
            $this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Grade',true)));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
            if($this->Grade->find('first',array('conditions'=>array('Grade.rank'=>$this->data['Grade']['rank'],'Grade.grade!="'.$this->data['Grade']['grade'].'"')))){
                if($grade['Grade']['rank']>$this->data['Grade']['rank']){
                    $diff_grade=$this->Grade->find('all',array('conditions'=>array('Grade.rank<'.$grade['Grade']['rank'],'Grade.rank>='.$this->data['Grade']['rank'])));
                    foreach($diff_grade as $g){
                        $g['Grade']['rank']+=1;
                        $this->Grade->save($g);
                    }
                }elseif($grade['Grade']['rank']<$this->data['Grade']['rank']){
                    $diff_grade=$this->Grade->find('all',array('conditions'=>array('Grade.rank>'.$grade['Grade']['rank'],'Grade.rank<'.$this->data['Grade']['rank'],'Grade.rank>='.$this->data['Grade']['rank'])));
                    foreach($diff_grade as $g){
                        $g['Grade']['rank']-=1;
                        $this->Grade->save($g);
                    }
                    $this->data['Grade']['rank']-=1;
                }
            }
			if ($this->Grade->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Grade',true)));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Grade',true)).__('Please try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $grade;
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Grade',true)));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Grade->del($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true),__('Grade',true)));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
