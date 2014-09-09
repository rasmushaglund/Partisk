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

$this->Html->addCrumb('Quiz', array('controller' => 'quizzes', 'action' => 'index'));
$this->Html->addCrumb('Frågor');

?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="quiz-answers modal open-modal-on-load">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                          <p class="quiz-progress"><?php echo "Fråga " . ($quizSession['QuizSession']['index'] +1) . " av " .
                                $quizSession['QuizSession']['questions']; ?></p>
                        <div class="progress progress-striped">
                          <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                               style="width: <?php echo (($quizSession['QuizSession']['index'])/ $quizSession['QuizSession']['questions'])*100; ?>%">
                          </div>
                        </div>

                     </div>
                        <h2 class="text-center"><?php echo $question['Question']['title']; ?></h2>
                        <?php
                        echo $this->Form->create('QuizSession', array('url' => '/quizzes/next'));
                        ?>
                        <p><?php echo $question['Question']['description']; ?></p>

                    <div class="modal-body">



                        <div>
                        <?php
                                if ($answer == null) { $answer = 'NO_OPINION'; }

                            if ($question['Question']['type'] == 'YESNO') {
                                echo $this->Form->input('answer', array('type' => 'radio', 'options' => array('NO_OPINION' => 'ingen åsikt', 'ja' => 'ja', 'nej' => 'nej'),
                                'default' => 'NO_OPINION', 'legend' => 'Ditt svar', 'value' => $answer, 'separator' => '<div></div>'));
                            } else {
                                echo $this->Form->input('answer', array('type' => 'radio', 'options' => $choices,
                                'default' => 'NO_OPINION', 'legend' => 'Ditt svar', 'value' => $answer, 'separator' => '<div></div>'));
                            }
                        ?>
                        <?php
                                echo $this->Form->input('importance', array('type' => 'radio', 'options' =>
                                                            array(1 => 'Inte så viktig',
                                                                  2 => 'Ganska viktig',
                                                                  3 => 'Väldigt viktig'),
                                                            'value' => $importance,
                                                            'legend' => "Hur viktig är frågan för dig?", 'separator' => '<div></div>'));
                        ?>

                        </div>
                    </div>
                    <div class="modal-footer quiz-buttons">
                            <?php

                                    if ($quizSession['QuizSession']['index'] != 0) {
                                            echo $this->Html->link('<i class="fa fa-chevron-left"></i> Föregående',  array('controller' => 'quizzes', 'action' => 'prev'), array('class' => 'btn btn-primary', 'escape' => false));
                                    } else {
                                            echo $this->Html->link('<i class="fa fa-chevron-left"></i> Föregående',  array('controller' => 'quizzes', 'action' => 'prev'), array('class' => 'btn btn-primary disabled', 'escape' => false));
                                }


                                    if ($quizSession['QuizSession']['index'] < $quizSession['QuizSession']['questions'] - 1) {
                            ?>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-chevron-right"></i> Nästa</button>
                            <?php
                                    } else {
                            ?>
                                    <button type="submit" class="btn btn-primary disabled"><i class="fa fa-chevron-right"></i> Nästa</button>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-bar-chart-o"></i> Till resultatet</button>
                            <?php
                                    }


                            ?>

                                <a class="btn btn-danger" data-toggle="modal" data-target="#abort-quiz"><i class="fa fa-times"></i> Avbryt</a>

                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="abort-quiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Är du säker på att du vill avbryta quizen?</h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Nej, fortsätt</button>
          <?php echo $this->Html->link('<i class="fa fa-times"></i> Ja, avbryt', array('controller' => 'quizzes', 'action' => 'close'), array('class' => 'btn btn-danger', 'escape' => false)); ?>
        </div>
      </div>
    </div>
</div>
