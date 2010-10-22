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
 ?>
<DIR>
    <?php 
        foreach($multi_data as $data){
            echo "<li class='autocomplete'>";
            $string=$text->highlight($text->excerpt($data['Task']['task_name'],$dtext,'50'),$dtext);
            echo $html->link($string, array('controller'=>'tasks','action'=>'view', $data['Group']['name'],'task_id'=>$data['Task']['id']),null,null,false); 
            if(!empty($data['Task']['task_desc'])){
                echo '<br/>';
                echo $text->highlight($text->excerpt($data['Task']['task_desc'],$dtext,'50'),$dtext);
            }
            echo "</li>";
        }
    ?>
</DIR>
