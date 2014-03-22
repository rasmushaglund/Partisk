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
 * @package     app.View.Quizzes
 * @license     http://opensource.org/licenses/MIT MIT
 */

$this->Html->addCrumb('Quiz');
?>

<h1>Quiz</h1>
<?php echo $this->element("share", array(
    "text" => "Se vilka partier du håller med mest i olika frågor"
)); ?>
<?php if ($this->Permissions->isLoggedIn()) { ?>
    <div class="tools">
    <?php echo $this->element('saveQuiz'); ?>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-6">
<p>Här kan du testa dig i olika quiz och se hur mycket du håller med de olika partierna i olika frågor.
Testen berättar inte för dig hur du ska rösta utan ger endast en indikation på vilka partier du håller med mest i olika frågor.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
<ul class="list-unstyled">
<?php foreach ($quizzes as $quiz) { ?>
    <li>
    	<?php echo $this->element('quizElement', array('quizSession' => $quizSession, 'quiz' => $quiz, 
                                                       'adminTools' => true)); ?>			
    </li>
<?php } ?>
</ul>
    </div>
</div>

