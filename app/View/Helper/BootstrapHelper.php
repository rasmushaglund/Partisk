<?php

/**
 * Bootstrap helper
 *
 * Partisk : Political Party Opinion Visualizer
 * Copyright (c) Partisk.nu Team (https://www.partisk.nu)
 *
 * Partisk is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Partisk is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Partisk. If not, see http://www.gnu.org/licenses/.
 *
 * @copyright   Copyright (c) Partisk.nu Team (https://www.partisk.nu)
 * @link        https://www.partisk.nu
 * @package     app.View.Helper
 * @license     http://www.gnu.org/licenses/ GPLv2
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

    public function dropdown($field, $modelField, $args = null) {
        if ($args == null) {
            $args = array();
        }

        $args['field'] = $field;
        $args['modelField'] = $modelField;
        $args['mode'] = $this->mode;
        $args['id'] = ucfirst($this->model) . ucfirst($field);
        
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

        return $this->_View->element('bootstrap/endForm', $args);
    }

}

?>