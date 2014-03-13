<?php
  $userAnswer = $question['answer'];
  $importance = $question['importance'];
  $title = $question['title'];
?>

<div class="panel-body">
    <p><?php echo $this->Html->link($question['title'], array('controller' => 'questions', 'action' => 'view', 
        'title' => $this->Url->slug($question['title']))); ?></p>
    <p>Ditt svar: <b><?php echo $userAnswer !== null ? ucfirst($userAnswer) : "Ingen åsikt"; ?></b></p>
    <p>Viktighet (1-9): <b><?php echo $importance; ?></b></p>

    <div class="table-scrolled-overflow-container">
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