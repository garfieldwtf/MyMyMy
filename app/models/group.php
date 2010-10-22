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

class Group extends AppModel {

    var $actsAs = array('Tree');
	var $name = 'Group';
	var $validate = array(
		'deleted' => array('numeric'),
        'group_name'=>array('isUnique'=>array('rule'=>'isUnique'),'notEmpty'=>array('rule'=>'notEmpty'),'character'=>array('rule' => array('custom', '/^[\da-zA-Z _]+$/')))
    );

    var $displayField ='group_name';
    
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Membership' => array(
			'className' => 'Membership',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
		
	);
    
    function groupList($data){
        if(empty($data)){
            return null;
        }
        $group_id=set::extract($data,'{n}.Group.id');
        $group_name=$this->generatetreelist(array('id'=>$group_id), null, '{n}.Group.name', '_');
        foreach($group_name as $gid=>$gname){
            $d=$data[array_search($gid,$group_id)];
            $d['order_rank']=strlen(str_replace($d['Group']['name'],'',$gname));
            $group[]=$d;
        }
        
        /*
        $rank=set::Extract($group,'{n}.order_rank');
        
        //find the parent location
        $parent_id=array_filter(set::Extract($group,'{n}.Group.parent_id'));
        $parent=array_keys(array_diff_key($rank,$parent_id));
        $parent[]=count($rank);
        $j=0;
        $rank1=array();
        for($i=0;$i<count($parent)-1;$i++){
            while($j<$parent[$i+1]){
                $rank1[$i][$j]=$rank[$j];
                $j++;
            }
        }
        //find which the |should be removed
        foreach($rank1 as $rk=>$r){
            $last=array_flip($r);
            for($i=1;$i<count($last)-1;$i++){
                for($j=$last[$i]+1;$j<count($rank) && isset($r[$j]);$j++){
                    if($r[$j]>$i){
                    $group[$j]['remove'][]=$group[$j]['order_rank']-$i+1;
                    }
                }
            }
        }
        */
        return $group;
    }
    
    //after delete
    function deleteRelate($group_id){
        
        $simpleDelete=array('Project','Category','Meeting','Membership','Client');
        foreach($simpleDelete as $s){
            $this->bindmodel(array('hasMany'=>array($s)));
            $data=$this->{$s}->find('first',array('conditions'=>array($s.'.group_id'=>$group_id)));
            while(!empty($data)){
                $this->{$s}->delete($data[$s]['id']);
                $data=$this->{$s}->find('first',array('conditions'=>array($s.'.group_id'=>$group_id)));
            }
        }
        $this->bindmodel(array('hasMany'=>array('Template')));
        $template=$this->Template->find('first',array('conditions'=>array('Template.foreign_key'=>$group_id,'Template.model'=>'Group')));
        while(!empty($template)){
            $this->Template->delete($template['Template']['id']);
            $template=$this->Template->find('first',array('conditions'=>array('Template.foreign_key'=>$group_id,'Template.model'=>'Group')));
        }
        
        //delete task
        $this->bindmodel(array('hasMany'=>array('Task')));
        $task=$this->Task->find('first',array('conditions'=>array('Task.group_id'=>$group_id)));
        while(!empty($task)){
            $this->Task->deleteRelate($task['Task']['id']);
            $task=$this->Task->find('first',array('conditions'=>array('Task.group_id'=>$group_id)));
        }
        
        
    }
    
}
?>
