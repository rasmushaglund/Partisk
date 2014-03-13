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
 * @package     app.View.Tags
 * @license     http://opensource.org/licenses/MIT MIT
 */

$this->Html->addCrumb('Taggar', Router::url(array('controller' => 'tags', 'action' => 'index'), true));
$this->Html->addCrumb(ucfirst($tag['Tag']['name']));

?>

<div class="row">
    <div class="col-md-12">
<h1><i class="fa fa-tag"></i> 
<?php echo ucfirst(h($tag['Tag']['name'])); ?>
        <?php echo $this->element('tagAdminToolbox', array('tag' => $tag)); ?>
</h1>
<?php echo $this->element("share"); ?>
<?php 
if (!$this->Permissions->isLoggedIn()) { ?>
<div class="tools">
<?php  echo $this->element('saveTag', array('tagId' => $tag['Tag']['id'])); 
  echo $this->element('saveQuestion', array('tagId' => $tag['Tag']['id'])); ?>
  </div>
  <?php echo $this->element('qa-table', array(
                  'parties' => $parties,
                  'questions' => $questions,
                  'answers' => $answers,
                  'fixedHeader' => true,
                  'loggedIn' => false
                  )); ?>
<?php } else { 
    echo $this->element('qa-table', array(
                  'parties' => $parties,
                  'questions' => $questions,
                  'answers' => $answers,
                  'fixedHeader' => true,
                  'loggedIn' => true
                  )); 
} ?>

<?php echo $this->element('authorInfo', array('object' => $tag, 'model' => 'Tag')); ?>
    </div>
</div>