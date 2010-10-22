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

class TitlesController extends AppController {

	var $name = 'Titles';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Title->recursive = 0;
		$this->set('titles', $this->paginate());
	}

	function add() {
		if (!empty($this->data)) {
			$this->Title->create();
			if ($this->Title->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Title',true)));
				$this->redirect(array('action'=>'index'));
			} else {
                $this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Title',true)).__('Please try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
            $this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Title',true)));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Title->save($this->data)) {
                $this->Session->setFlash(sprintf(__('The %s has been saved', true),__('Title',true)));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. ', true),__('Title',true)).__('Please try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Title->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s.',true),__('Title',true)));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Title->del($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true),__('Title',true)));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
