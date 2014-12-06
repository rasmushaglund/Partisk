<?php
/**
 * Copyright 2013-2014 Partisk.nu Team
 * https://www.partisk.nu/
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * 
 * @copyright   Copyright 2013-2014 Partisk.nu Team
 * @link        https://www.partisk.nu
 * @package     app.View.Helper
 * @license     http://opensource.org/licenses/MIT MIT
 */

App::uses('AppHelper', 'View/Helper');

class BootstrapHelper extends AppHelper {

    var $helpers = array('Session');
    var $model;
    var $mode;

    public function input($field, $args = null) {
        if ($args == null) {
            $args = array();
        }

        $args['field'] = $field;
        $args['model'] = $this->model;
        $args['mode'] = $this->mode;
        $args['id'] = ucfirst($this->model).ucfirst($field);
        
        if (!isset($args['value'])) { $args['value'] = null; }
        if (!isset($args['type'])) { $args['type'] = 'text'; }
        if (!isset($args['placeholder'])) { $args['placeholder'] = ''; }
        if (!isset($args['label'])) { $args['label'] = $field; }

        return $this->_View->element('bootstrap/input', $args);
    }

    public function hidden($field, $args = null) {
        if ($args == null) {
            $args = array();
        }

        $args['field'] = $field;
        $args['model'] = $this->model;
        $args['mode'] = $this->mode;
        $args['id'] = ucfirst($this->model) . ucfirst($field);

        if (!isset($args['value'])) {
            $args['value'] = '';
        }

        return $this->_View->element('bootstrap/hidden', $args);
    }

    public function checkbox($field, $args = null) {
        if ($args == null) {
            $args = array();
        }

        $args['field'] = $field;
        $args['model'] = $this->model;
        $args['mode'] = $this->mode;
        $args['id'] = ucfirst($this->model) . ucfirst($field);

        if (!isset($args['label'])) {
            $args['label'] = $field;
        }

        return $this->_View->element('bootstrap/checkbox', $args);
    }

    public function date($field, $args = null) {
        if ($args == null) {
            $args = array();
        }

        $args['field'] = $field;
        $args['model'] = $this->model;
        $args['mode'] = $this->mode;
        $args['id'] = ucfirst($this->model).ucfirst($field);
        
        if (empty($args['value'])) { 
            $args['value'] = null; 
        } else { 
            $args['value'] = date('Y-m-d', strtotime($args['value']));
        }

        if (!isset($args['label'])) {
            $args['label'] = $field;
        }

        return $this->_View->element('bootstrap/date', $args);
    }

    public function textarea($field, $args = null) {
        if ($args == null) {
            $args = array();
        }

        $args['field'] = $field;
        $args['model'] = $this->model;
        $args['mode'] = $this->mode;
        $args['id'] = ucfirst($this->model).ucfirst($field);
        
        if (!isset($args['value'])) { $args['value'] = null; }
        if (!isset($args['placeholder'])) { $args['placeholder'] = ''; }
        if (!isset($args['label'])) { $args['label'] = $field; }

        return $this->_View->element('bootstrap/textarea', $args);
    }

    public function dropdown($field, $modelField, $args = null, $idField = "id") {
        if ($args == null) {
            $args = array();
        }

        $args['field'] = $field;
        $args['modelField'] = $modelField;
        $args['mode'] = $this->mode;
        $args['id'] = ucfirst($this->model) . ucfirst($field);
        $args['idField'] = $idField;
        
        if (!isset($args['options'])) {
            $args['options'] = array();
        }
        if (!isset($args['label'])) {
            $args['label'] = $field;
        }
        if (!isset($args['model'])) {
            $args['model'] = $this->model;
        }
        if (!isset($args['selected'])) {
            $args['selected'] = null;
        }
        if (!isset($args['titleField'])) {
            $args['titleField'] = 'name';
        }


        return $this->_View->element('bootstrap/dropdown', $args);
    }

    public function create($model, $args = null) {
        if ($args == null) {
            $args = array();
        }

        $this->model = $model;
        $this->mode = isset($args['editMode']) && $args['editMode'] ? 'update' : 'create';

        $args['controller'] = strtolower(Inflector::pluralize($model));
        $args['model'] = $model;
        if (!isset($args['idName'])) {
            $args['idName'] = 'id';
        }
        if (!isset($args['id'])) {
            $args['id'] = null;
        }
        if (!isset($args['action'])) {
            $args['action'] = $args['id'] ? "edit" : "add";
        }
        if (!isset($args['modal'])) {
            $args['modal'] = false;
        }
        if (!isset($args['action'])) {
            $args['modal'] = false;
        }
        if (!isset($args['label'])) {
            $args['label'] = '';
        }
        if (!isset($args['icon'])) {
            $args['icon'] = 'fa fa-plus-square';
        }
        if (!isset($args['ajax'])) {
            $args['ajax'] = false;
        }
        if (!isset($args['modalLabel'])) {
            $args['modalLabel'] = $args['label'];
        }
        if (!isset($args['class'])) {
            $args['class'] = 'btn btn-primary';
        }

        return $this->_View->element('bootstrap/createForm', $args);
    }

    public function end($label, $args = null) {
        if ($args == null) {
            $args = array();
        }

        $args['label'] = $label;
        if (!isset($args['modal'])) {
            $args['modal'] = false;
        }
        
        if (!isset($args['submitClass'])) { $args['submitClass'] = 'btn-primary'; }
        if (!isset($args['abortText'])) { $args['abortText'] = 'Avbryt'; }

        return $this->_View->element('bootstrap/endForm', $args);
    }

        }
        
?>