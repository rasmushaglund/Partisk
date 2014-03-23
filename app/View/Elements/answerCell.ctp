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
 * @package     app.View.Elements
 * @license     http://opensource.org/licenses/MIT MIT
 */

$answerClass = null;

$answerHtml = $this->Html->link($answer['Answer']['answer'],
      array('controller' => 'answers', 'action' => 'view', $answer['Answer']['id']), array('escape' => false, 'class' => 'popover-link'));

$notApproved = !$answer['Answer']['approved'];

if($answer['Answer']['answer'] == "ja") { $answerClass = 'class="table-cell yes"'; } 
else if($answer['Answer']['answer'] == "nej") { $answerClass = 'class="table-cell no"'; } 
else { $answerClass = 'class="table-cell etc"'; } ?>

<div <?php echo $answerClass  ?>>
  <div class="party-answer"><?php echo $this->element('party_header', array('party' => $party, 'link' => true, 'small' => true, 'title' => true)); ?></div>
  <span class="popover-link<?php echo $notApproved?' answer-not-approved':''; ?>" 
        data-id="<?php echo $answer['Answer']['id']; ?>"><?php echo $answer['Answer']['answer']; ?></span>
</div>