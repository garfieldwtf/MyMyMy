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

class Membership extends AppModel {

	var $name = 'Membership';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'foreign_key',
			'conditions' => array('Membership.model'=>'User'),
			'fields' => '',
			'order' => ''
		),
		'Group2' => array(
			'className' => 'Group2',
			'foreignKey' => 'foreign_key',
			'conditions' => array('Membership.model'=>'Group2'),
			'fields' => '',
			'order' => ''
		),
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	/*produce list for options
     * eg. array($id=>$name)
     */
	function lists($data,$type){
        $result=array();
		foreach($data as $d){
			$result[$d[$type]['foreign_key']]=$d[$d[$type]['model']]['name'];
		}
		return $result;
	}
    
	/*produce list for options with model
     * eg: array('User1'=>$name)
     */
	function lists2($data,$type){
		foreach($data as $d){
			$result[$d[$type]['model'].$d[$type]['foreign_key']]=$d[$d[$type]['model']]['name'];
		}
		return $result;
	}
    
    /* find the group which head is $user 
     * if $task, find out which group have the child task
     * 
     * return: 
     * [n]['Membership']  ---all the group
     * ['subtask'][n]['Task'],['subtask'][n]['Group']
     * ['available'][n]['Membership']
     * 
     */
    function head_group($user_id,$group2_id,$task=null){
        $group=$this->find('all',array('conditions'=>array('Membership.head'=>1,'or'=>array(array('Membership.model'=>'User','Membership.foreign_key'=>$user_id),array('Membership.model'=>'Group2','Membership.foreign_key'=>$group2_id)))));
        $group['subtask']=$this->User->Implementor->Task->find('all',array('conditions'=>array('Task.parent_id'=>$task['Task']['id'],'Task.group_id'=>set::extract($group,'{n}.Membership.group_id'))));
        $group['available']=array();
        foreach($group as $gdata){
            if(!empty($gdata['Membership']) && !(in_array($gdata['Membership']['group_id'],set::extract($group['subtask'],'{n}.Task.group_id')) || $gdata['Membership']['group_id']==$task['Task']['group_id'])){
                $group['available'][]=$gdata;
            }
            
        }
        return $group;
    }

}
?>
