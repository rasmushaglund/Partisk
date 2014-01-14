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

$quizName = isset($quiz['Quiz']['name']) ? $quiz['Quiz']['name'] : 'Stora quizen';

$this->Html->addCrumb('Quiz', array('controller' => 'quizzes', 'action' => 'index'));
$this->Html->addCrumb(ucfirst($quizName));
$this->Html->addCrumb('Resultat');

if (Configure::read('minimizeResources')==1) { 
            $version = Configure::read('PartiskVersion');
            $versionString = $version != null ? "-v" . $version : ""; 
            echo $this->Html->script("graph$versionString.min");
 } ?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <h1>Resultat för <?php echo ucfirst($quizName); ?> 
                    <i class="date"><?php echo date('Y-m-d', strtotime($quizResults['QuizResult']['created'])); ?></i></h1>

                <?php echo $this->element("share"); ?>
            </div>
            <div class="col-md-6">
                <a href="#quizCalculationInfo" data-toggle="modal" data-target="#quizCalculationInfo" class="btn btn-primary quizCalculationInfo">
                    <i class="fa fa-question-circle"></i> Om resultatet
                </a>
            </div>
        </div>
        <?php
            $first = true;
            foreach ($winners as $key => $value) { 
                if ($first) {
                    $first = false; ?>
                <div class="alert alert-info results">
                    <?php echo $this->element('party_header', array('party' => $parties[$key], 'link' => true, 'small' => false, 'title' => false)); ?>
                    <h4><b>Grattis!</b> Ditt resultat stämmer bäst överens med 
                        <b><?php echo $this->Html->link(ucfirst($parties[$key]['name']), array('controller' => 'parties', 'action' => 'view', 
                'name' => $this->Url->slug($parties[$key]['name']))); ?></b>
                        (<?php echo $value; ?>%)</h4>
                </div>
            <?php } ?>
                
        <?php }
        ?>
        
                   
    </div>
</div>

<div class="row">
    <div class="col-md-12">
    </div>
</div>
<div class="row">
    <div id="graphs">
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
    <div id="no-svg">
        <div class="col-md-6">
            <p class="alert alert-danger">Graferna kunde ej visas då din browser inte har stöd för <a href="http://caniuse.com/svg">SVG</a>. 
                <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></p>
        </div>
    </div>
</div>
    
<script type="text/javascript">
  var parties = <?php echo json_encode($parties); ?>;
  var data = <?php echo $quizResults['QuizResult']['data']; ?>;
</script>

<?php if ($quizSession) { ?>

<div class="row">
    <div class="col-md-12 share-line">
        <p>Innehållet nedan visas inte vid delning</p>
        <hr></hr>
    </div>
</div>

<h3>Sammanställning av resultatet</h3>
<table class="table table-striped table-hover">
  <thead>
    <th class="party-column">Parti</th>
    <th><i class="popover-click-link fa fa-thumbs-up" data-content="Matchande svar" data-placement="top"></i> <span class="collapsable-head">Matchande svar</span></th>
    <th><i class="popover-click-link fa fa-thumbs-down" data-content="Ej matchande svar" data-placement="top"></i> <span class="collapsable-head">Ej matchande svar</span></th>
    <th><i class="popover-click-link fa fa-question" data-content="Besvarade frågor" data-placement="top"></i> <span class="collapsable-head">Besvarade frågor</span></th>
    <th><i class="popover-click-link fa fa-plus" data-content="Summa poäng" data-placement="top"></i> <span class="collapsable-head">Summa poäng</span></th>
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
                'title' => $this->Url->slug($question['title']))); ?></p>
            <p>Ditt svar: <b><?php echo $userAnswer !== null ? ucfirst($userAnswer) : "Ingen åsikt"; ?></b></p>
            <p>Viktighet (1-9): <b><?php echo $importance; ?></b></p>
                   
            <div class="table table-striped party-result-table">
              <div class="table-row table-head">
                <div class="table-header party-column">Parti</div>
                <div class="table-header">Svar</div>
                <div class="table-header">Poäng</div>
              </div>
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

                    <div class="table-row <?php echo $pointsClass; ?>">
                      <div class="table-cell"><?php echo $this->element('party_header', array('party' => $party, 'link' => true, 'small' => true, 'title' => true)); ?></div>

                    <?php if ($partyAnswer === null) { ?>
                      <div class="table-cell">Inget svar</div>
                      <div class="table-cell"><span class="result"><?php echo $partyPoints . 'p'; ?></span></div>
                    <?php } else if ($question['parties'][$partyId]['answer'] != null) {
                    $sameAnswer = $partyAnswer['answer'] == $userAnswer;
                    ?>
                      <div class="table-cell <?php echo $sameAnswer ? 'matching-answer' : '' ?>">
                          <span class="answer popover-link" data-id="<?php echo $partyAnswer['id']; ?>" href="#"><?php 
                          echo $partyAnswer['answer'];?></span>
                      </div>
                      <div class="table-cell">
                        <span class="result"><?php echo $pointsPrefix . $partyPoints . 'p'; ?></span></div>
                    <?php } else { ?>
                      <div class="table-cell">Inget svar</div>
                      <div class="table-cell"><span class="result"><?php echo $partyPoints . 'p'; ?></span></div>
                    <?php } ?>
                    </div>
                <?php } ?>
            </div>
          </div>
        </div>
      </div>
  </li>
<?php } ?>
</ul>
</div>

<?php } ?>

<div class="modal fade" id="quizCalculationInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Hur räknas resultatet ut?</h4>
        </div>
        <div class="modal-body">
            <h4>Poäng</h4>
            <p>Quizen består av ett antal frågor där varje fråga kan ge maximalt <b>9 poäng</b> och som minst <b>9 poäng</b> i avdrag.
            Om man väljer ett svar som stämmer överens med vad ett parti tycker får partiet poäng som läggs till det totala resultatet, 
            men om partiet har annan åsikt får partiet minuspoäng. Saknar partiet svar i frågan får partiet varken plus- eller minuspoäng, oavsätt vad man svarar.</p>
            <p>Hur många poäng som delas ut för ett parti på en fråga bestäms av hur viktig man valt att frågan är. Det finns 3 nivåer av hur viktig man tycker
                en fråga är: "<i>Inte så viktig</i>" som ger <b>1 poäng</b>, "<i>Ganska viktig</i>" som ger <b>3 poäng</b>, och "<i>Väldigt viktig</i>" som ger <b>9 poäng</b>.</p>
            <p>Väljer du ett svar på en fråga som du markerar "<i>Ganska viktig</i>" får alla partier som har samma svar <b>3 poäng</b>.</p><br />
            
            <h4>Cirkeldiagrammet</h4>
            <p>Diagrammet visar hur mycket poäng de olika partierna fått. Alla partier som fått under <b>0 poäng</b> döljs.</p><br />
            
            <h4>Stapeldiagrammet</h4>
            <p>Detta diagram visar hur många procent av frågorna som du håller med respektive parti. Om ett parti får 100% betyder det att du håller med om alla 
                partiets svar i quizen.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Stäng</button>
        </div>
      </div>
    </div>
</div>
