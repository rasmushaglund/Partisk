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
 * @package     app.View.Pages
 * @license     http://opensource.org/licenses/MIT MIT
 */
 ?>

<div class="row">
    <div class="col-md-6">
        <h2>Vi gör politik lättare</h2>
        <p>Partisk.nu finns här för att göra Sveriges största partiers åsikter lättare att förstå.
        Vi samlar de viktigaste frågorna och presenterar svaren på ett 
        <?php echo $this->Html->link('överskådligt sätt', array('controller' => 'questions', 'action' => 'index')); ?>.</p>
        <p>Nya frågor och svar läggs in fortlöpande och om du saknar någonting eller hittar felaktigheter tveka inte att 
        <?php echo $this->Html->link('kontakta oss', array('controller' => 'pages', 'action' => 'contact')); ?>.</p>
        <p>Antal frågor: <b><?php echo $this->requestAction('questions/getNumberOfQuestions'); ?></b>, 
            antal svar: <b><?php echo $this->requestAction('answers/getNumberOfAnswers'); ?></b>.</p>
        <?php echo $this->element("share"); ?>
    </div>
    <div class="col-md-6">
        <h2>Vilket parti matchar dig?</h2>
        <p>Här finns det flera quiz att göra för att ta reda på vilka partier som passar dig bäst.</p>
        <?php echo $this->Html->link('<i class="fa fa-warning"></i> Testa dig nu!', array('controller'  => 'quizzes', 'action' => 'index'),
                array('class' => 'btn btn-success btn-xl', 'escape' => false)); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">     
        <h2>Senaste frågorna</h2>
        <?php echo $this->element('qa-table', array(
                  'parties' => $parties,
                  'questions' => $questions,
                  'answers' => $answers,
                  'fixedHeader'  => false
                  )); ?>
    </div>  
</div>