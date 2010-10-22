<?php
/*
 * Copyright (c) 2008 Government of Malaysia
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE REGENTS AND CONTRIBUTORS ``AS IS'' AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED.  IN NO EVENT SHALL THE REGENTS OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
 * OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 *
 * @author: Abdullah Zainul Abidin, Nuhaa All Bakry
 *          Eavay Javay Barnad, Sarogini Muniyandi
 *
 */

/**
 * Autocomplete Helper
 *
 * @author  Nik Chankov
 * @website http://nik.chankov.net
 * @version 1.0.0
 *
 * @updated   2008-02-13
 * @author    Abdullah
 * @website   http://abdullahsolutions.com
 * @changes   Used helpers array. Also used beforeRender so that the javascripts and theme is automatically loaded
 */

class DatePickerHelper extends FormHelper {

    var $format = '%Y-%m-%d';
    var $helpers = array('Javascript','Html');

    /**
     *Setup the format if exist in Configure class
     */
    function _setup(){
        $format = Configure::read('DatePicker.format');
        if($format != null){
            $this->format = $format;
        }
        else{
            $this->format = '%Y-%m-%d';
        }
    }

    function beforeRender(){
        $view = ClassRegistry::getObject('view');
        if (is_object($view)) {
            $view->addScript($this->Javascript->link('jscalendar/calendar.js'));
            $view->addScript($this->Javascript->link('jscalendar/lang/calendar-en.js'));
            $view->addScript($this->Javascript->link('common.js'));
            $view->addScript($this->Html->css('../js/jscalendar/skins/aqua/theme'));
        }
    }

    /**
     * The Main Function - picker
     *
     * @param string $field Name of the database field. Possible usage with Model.
     * @param array $options Optional Array. Options are the same as in the usual text input field.
     */   
    function picker($fieldName, $options = array()) {
        $this->_setup();
        //$this->setFormTag($fieldName);
        $this->setEntity($fieldName);
        $htmlAttributes = $this->domId($options);       
        $divOptions['class'] = 'date';
        $options['type'] = 'text';
        $options['div']['class'] = 'date';
        $time='';
        if(isset($options['showstime'])){
            if($options['showstime']===true) {
                $time=',"24"';
                $this->format.=" %k:%M";
            }
            unset($options['showstime']);
        }
        $options['after'] = $this->Html->link($this->Html->image('../js/jscalendar/img.gif'), '#', array('onClick'=>"return showCalendar('".$htmlAttributes['id']."', '".$this->format."'$time); return false;"), null, false);
        $output = $this->input($fieldName, $options);

        return $output;
    }

    function flat($fieldName, $options = array()){
        $this->_setup();
        $this->setFormTag($fieldName);
        $htmlAttributes = $this->domId($options);       
        $divOptions['class'] = 'date';
        $options['type'] = 'hidden';
        $options['div']['class'] = 'date';
        $hoder = '<div id="'.$htmlAttributes['id'].'_cal'.'"></div><script type="text/javascript">showFlatCalendar("'.$htmlAttributes['id'].'", "'.$htmlAttributes['id'].'_cal'.'", "'.$this->format.'", function(cal, date){document.getElementById(\''.$htmlAttributes['id'].''.'\').value = date});</script>';
        $output = $this->input($fieldName, $options).$hoder;

        return $output;
    }
}
?>
