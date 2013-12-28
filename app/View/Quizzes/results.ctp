<?php
/** 
 * Quiz results view
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
 * @package     app.View.Quiz
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

$quizName = isset($quiz['Quiz']['name']) ? $quiz['Quiz']['name'] : 'Stora quizen';

$this->Html->addCrumb('Quiz', array('controller' => 'quizzes', 'action' => 'index'));
$this->Html->addCrumb(ucfirst($quizName));
$this->Html->addCrumb('Resultat');

if (Configure::read('debug')==0) { 
            $version = Configure::read('PartiskVersion'); 
            echo $this->Html->script("graph-v$version.min");
 } ?>
<div class="row">
    <div class="col-md-12">
    <h2>Resultat för <?php echo ucfirst($quizName); ?> 
        <i class="date"><?php echo date('Y-m-d', strtotime($quizResults['QuizResult']['created'])); ?></i></h2>
        
        <div class="share">
            <a href="http://www.facebook.com/sharer/sharer.php?u=http://www.partisk.nu/quiz/resultat/<?php echo $guid; ?>" title="Facebook"><i class="fa fa-facebook-square"></i></a>
            <a href="https://twitter.com/intent/tweet?url=http://www.partisk.nu/quiz/resultat/<?php echo $guid; ?>&text=Mitt resultat&via=partisknu" title="Twitter"><i class="fa fa-twitter-square"></i></a>
            <a href="https://plus.google.com/share?url=http://www.partisk.nu/quiz/resultat/<?php echo $guid; ?>" title="Google+"><i class="fa fa-google-plus-square"></i></a>
            <a href="http://www.linkedin.com/shareArticle?url=http://www.partisk.nu/quiz/&t=Mitt resultat" title="LinkedIn"><i class="fa fa-linkedin-square"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div id="points-percentage-graph" class="graph">
          <svg></svg>
          <p class="description">Grafen visar hur många poäng partierna fått relativt varandra. Partier med en negativ poängsumma visas ej.</p>
        </div>
    </div>
    <div class="col-md-6">
        <div id="question-agree-rate-graph" class="graph">
          <svg></svg>
          <p class="description">Diagrammet visar hur mycket du håller med om varje partis svar.</p>
        </div>
    </div>
</div>
    
<script type="text/javascript">
  var parties = <?php echo json_encode($parties); ?>;
  var data = <?php echo $quizResults['QuizResult']['data']; ?>;
</script>

<?php if ($quizSession) { ?>

<h3>Sammanställning av resultatet</h3>
<table class="table table-striped">
  <thead>
    <th class="party-column">Parti</th>
    <th>Matchande svar</th>
    <th>Ej matchande svar</th>
    <th>Besvarade frågor</th>
    <th>Summa poäng</th>
  </thead>
  <tbody>
<?php foreach ($parties as $party) { 
    $partyPoints = $quizSession['QuizSession']['points']['parties'][$party['id']];

    $pointsClass = "";
    $pointsPrefix = "";
    if ($partyPoints['points'] > 0) { $pointsClass = "plus-points"; $pointsPrefix = "+"; }
    if ($partyPoints['points'] < 0) { $pointsClass = "minus-points"; } ?>
  
    <tr class="<?php echo $pointsClass; ?>">
    <td><?php echo $this->element('party_header', array('party' => $party, 'link' => true, 'small' => true, 'title' => true)); ?></td>
    <td><?php echo $partyPoints['matched_questions']; ?> st</td>
    <td><?php echo $partyPoints['missmatched_questions']; ?> st</td>
    <td><?php echo $partyPoints['matched_questions']+$partyPoints['missmatched_questions']; ?> st</td>
    <td><span class="result"><?php echo $pointsPrefix . $partyPoints['points']; ?>p</span>  </td>
    </tr>
<?php } ?>
</tbody>
</table>

<h3>Resultat per fråga</h3>
<div class="panel-group" id="accordion">
    
<ul class="list-unstyled question-summary-list">
    
<?php foreach ($quizSession['QuizSession']['points']['questions'] as $question) { 
  $userAnswer = $question['answer'];
  $importance = $question['importance'];
  $title = $question['title'];
  ?>
  <li>
    <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $question['id']; ?>" class="collapsed">
              <i class="fa fa-plus-square toggle"></i> <?php echo $question['title']; ?>
            </a>
          </h4>
        </div>
        <div id="collapse<?php echo $question['id']; ?>" class="panel-collapse collapse">
          <div class="panel-body">
            <p><?php echo $this->Html->link($question['title'], array('controller' => 'questions', 'action' => 'view', 
                'title' => str_replace(' ', '_', strtolower($question['title'])))); ?></p>
            <p>Ditt svar: <b><?php echo $userAnswer !== null ? ucfirst($userAnswer) : "Ingen åsikt"; ?></b></p>
            <p>Viktighet (1-9): <b><?php echo $importance; ?></b></p>
            <table class="table table-striped party-result-table">
              <thead>
                <th class="party-column">Parti</th>
                <th>Svar</th>
                <th>Poäng</th>
              </thead>
              <tbody>
                <?php foreach ($parties as $party) { 
                  $partyId = $party['id']; 
                  $sameAnswer = null; 
                  $partyPoints = 0; ?>


                  <?php 
                    $partyAnswer = $question['parties'][$partyId]['answer'];
                    $partyPoints = $question['parties'][$partyId]['points'];

                    $pointsClass = "";
                    $pointsPrefix = "";
                    if ($partyPoints > 0) { $pointsClass = "plus-points"; $pointsPrefix = "+"; }
                    if ($partyPoints < 0) { $pointsClass = "minus-points"; } ?>

                    <tr class="<?php echo $pointsClass; ?>">
                      <td><?php echo $this->element('party_header', array('party' => $party, 'link' => true, 'small' => true, 'title' => true)); ?></td>

                    <?php if ($partyAnswer === null) { ?>
                      <td>Inget svar</td>
                      <td><span class="result"><?php echo $partyPoints . 'p'; ?></span></td>
                    <?php } else if ($question['parties'][$partyId]['answer'] != null) {
                    $sameAnswer = $partyAnswer['answer'] == $userAnswer;
                    ?>
                      <td class="<?php echo $sameAnswer ? 'matching-answer' : '' ?>">
                          <span class="answer popover-link" data-id="<?php echo $partyAnswer['id']; ?>" href="#"><?php 
                          echo $partyAnswer['answer'];?></span>
                      </td>
                      <td>
                        <span class="result"><?php echo $pointsPrefix . $partyPoints . 'p'; ?></span></td>
                    <?php } else { ?>
                      <td>Inget svar</td>
                      <td><span class="result"><?php echo $partyPoints . 'p'; ?></span></td>
                    <?php } ?>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </li>
<?php } ?>
</ul>
</div>

<?php } ?>