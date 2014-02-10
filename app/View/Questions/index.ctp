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
 * @package     app.View.Questions
 * @license     http://opensource.org/licenses/MIT MIT
 */

$this->Html->addCrumb('Frågor');

?>
<h1>Så här tycker partierna</h1>
<?php echo $this->element("share"); ?>
<?php if ($this->Permissions->isLoggedIn()) { ?>
    <div class="tools">
        <?php  echo $this->element('saveQuestion'); 
            echo $this->element('saveAnswer'); ?>
        <?php echo $this->Html->link('<i class="fa fa-question-circle"></i> Visa ej godkända frågor', array('controller' => 'questions', 'action' => 'notApproved'), array('class' => 'btn btn-s btn-info', 'escape' => false)); ?>
        <?php echo $this->Html->link('<i class="fa fa-question-circle"></i> Visa frågor utan beskrivning', array('controller' => 'questions', 'action' => 'noDescription'), array('class' => 'btn btn-s btn-info', 'escape' => false)); ?>
    </div>
 <?php } ?>

<h2>Populäraste frågorna just nu</h2>
<?php echo $this->element('qa-table', array(
                  'parties' => $parties,
                  'questions' => $popularQuestions,
                  'answers' => $answers,
                  'fixedHeader'  => false
                  )); ?>

<h2>Kategorier</h2>
<div class="panel-group" id="accordion">
    <ul class="list-unstyled">
        <?php
            foreach ($categories as $category) { 
        ?>
        <li>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $category['Tag']['id']; ?>" class="collapsed">
                            <i class="fa fa-plus-square toggle"></i> <?php echo ucfirst($category['Tag']['name']); ?></a>
                    </h4>
                </div>
                <div id="collapse<?php echo $category['Tag']['id']; ?>" data-type='category' data-id="<?php echo $category['Tag']['id']; ?>" 
                     class="ajax-load-table panel-collapse collapse">
                </div>
            </div>
        </li>
        <?php } ?>
    </ul> 
</div>
<?php



?>
