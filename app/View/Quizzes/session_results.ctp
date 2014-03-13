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

if ($quizSession) { ?>

    <div class="row">
        <div class="col-md-12 share-line">
            <p>Innehållet nedan visas inte vid delning</p>
            <hr></hr>
        </div>
    </div>

    <h3>Resultat per fråga</h3>
    <div class="panel-group" id="accordion">

    <ul class="list-unstyled question-summary-list">

    <?php foreach ($quizSession['QuizSession']['points']['questions'] as $question) { 
      ?>
      <li>
        <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $question['question_id']; ?>" class="collapsed">
                  <i class="fa fa-plus-square toggle"></i> <?php echo $question['title']; ?>
                </a>
              </h4>
            </div>
            <div id="collapse<?php echo $question['question_id']; ?>" data-type="quiz-question" data-id="<?php echo $question['question_id']; ?>" 
                 class="ajax-load-table panel-collapse collapse">
            </div>
          </div>
      </li>
    <?php } ?>
    </ul>
    </div>

<?php } ?>