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

<script type="text/javascript">
  var parties = <?php echo json_encode($parties); ?>;
  var data = <?php echo $quizResults['QuizResult']['data'] === null ? "null" : $quizResults['QuizResult']['data']; ?>;
  var quizId = "<?php echo $guid; ?>";
</script>

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
            
            if ($winners) { ?>
        
            <div class="row">
                <div class="col-md-12">
        <?php
            foreach ($winners as $key => $value) { 
                if ($first) {
                    $first = false; ?>
                <div class="alert alert-info results">
                    <?php echo $this->element('party_header', array('party' => $parties[$key], 'link' => true, 'small' => false, 'title' => false)); ?>
                    <h4>Dina åsikter stämmer bäst överens med 
                        <b><?php echo $this->Html->link(ucfirst($parties[$key]['name']), array('controller' => 'parties', 'action' => 'view', 
                'name' => $this->Url->slug($parties[$key]['name']))); ?></b>
                        (<?php echo $value; ?>%)</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-6 disclaimer">
                    <p class="disclaimer-warning">
                        <i class="fa fa-exclamation-circle"></i>
                        Resultatet berättar inte hur du ska rösta, utan visar endast hur mycket du håller med partierna baserat
                        på de frågor och svar som finns inlagda i systemet. Syftet är att få dig som besökare att tänka till och reflektera
                        över vad du själv tycker och förhoppningsvis få en ögonöppnare.
                    </p>
                </div>
            </div>
                <?php }
            }
            } else { ?>
            <div class="alert alert-danger">För att kunna visa detta resultat måste du ange rätt nyckel.</div>
            <?php }
        ?>
            </div>
        </div>
        
                   
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
          <p class="description">Diagrammet visar hur mycket du håller med svaren för varje parti.</p>
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

<div id="quiz-summary">
    <h3>Sammanställning av resultatet</h3>
    <div id="result-table" class="table-scrolled-overflow-container">
        <table class="table table-striped table-hover">
          <thead>
            <th class="party-column">Parti</th>
            <th><i class="popover-click-link fa fa-thumbs-up" data-content="Pluspoäng" data-placement="top"></i> <span class="collapsable-head">Pluspoäng</span></th>
            <th><i class="popover-click-link fa fa-thumbs-down" data-content="Minuspoäng" data-placement="top"></i> <span class="collapsable-head">Minuspoäng</span></th>
            <th><i class="popover-click-link fa fa-plus" data-content="Summa poäng" data-placement="top"></i> <span class="collapsable-head">Summa poäng</span></th>
            <th><i class="popover-click-link" data-content="Totalt" data-placement="top">%</i> <span class="collapsable-head">Totalt</span></th>
         </thead>
          <tbody>
        </tbody>
        </table>
    </div>
</div>
    
<div id="session-results"></div>

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
