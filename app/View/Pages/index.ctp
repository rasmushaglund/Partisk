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
	<!--<div class="col-md-6">
		<h2>Partisk.nu</h2>
		<p>Välkommen till Partisk.nu, sidan med den stora uppgiften att hjälpa er att hitta rätt bland alla 
                    partiers åsikter. Här kan du söka runt bland 
		<?php echo $this->Html->link('frågor/svar',
		                  array('controller' => 'questions', 'action' => 'index')); ?> och dessutom göra en 
		<?php echo $this->Html->link('quiz',
		                  array('controller' => 'quizzes', 'action' => 'index')); ?> för att se hur mycket du håller med 
                                  de olika partierna.</p>
                <p>Tjänsten är fortfarande under snabb utveckling så vi hoppas att ni har överseende med att allt kanske
                    inte fungerar som det är tänkt. Om du har några förslag eller hittar ett fel kan du skicka in feedback
                    på knappen längst ned i högra hörnet. Du kan även
		<?php echo $this->Html->link('kontakta oss',
		                  array('controller' => 'pages', 'action' => 'contact')); ?>
                    som utvecklar sidan. </p>
		<p><?php echo $this->Html->link('Mer information',
		                  array('controller' => 'pages', 'action' => 'about')); ?>
                    om sidan.
                </p>
	</div>

	<div class="col-md-6">
		<h2>Nya frågor</h2>
		<table class="table table-bordered table-striped">
                    <thead>
                        <tr><th class="table-date-column">Datum</th><th>Fråga</th></tr>
                    </thead>
                    <tbody>
		<?php foreach ($questions as $question): ?>
		    <tr>
                        <td><?php echo date('Y-m-d', strtotime($question['Question']['approved_date'])); ?></td>
		        <td><?php echo $this->Html->link($question['Question']['title'],
                                array('controller' => 'questions', 'action' => 'view', 
                                                'title' => str_replace(' ', '_', strtolower($question['Question']['title'])))); ?></td>
		    </tr>
		 <?php endforeach; ?>
                    </tbody>
		 </table>
	 </div>-->
                                                
         <div class="col-md-6">
             
	 </div>
                                                
         <div class="col-md-6">
             
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