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

<h3>Resultat för <?php echo $quizName; ?>, 
    <?php echo date('Y-m-d', strtotime($quizResults['QuizResult']['created'])); ?></h3>

<div id="points-percentage-graph" class="graph">
  <svg></svg>
  <p class="description">Hur många poäng partierna fått relativt varandra. Partier med en negativ poängsumma visas ej.</p>
</div>
<div id="question-agree-rate-graph" class="graph">
  <svg></svg>
  <p class="description">Hur stor andel av svaren stämmer överens med respektive partis svar.</p>
</div>

<script type="text/javascript">

  var parties = <?php echo json_encode($parties); ?>;
  var data = <?php echo $quizResults['QuizResult']['data']; ?>;

  function getQuestionAgreeRate() {
    var result = {key: 'questionAgreeRate', values: []};

    var agree_rate = data["question_agree_rate"];

    for (var value in agree_rate) {
      result.values.push({value: agree_rate[value]['result'], range: agree_rate[value]['range'], plus_points: agree_rate[value]['plus_points'],
                                        label: capitalizeFirstLetter(parties[value].name), minus_points: agree_rate[value]['minus_points'], 
                                        color: parties[value].color, order: parties[value].order});      
    }

   result.values.sort(function (a, b) { return a.order - b.order; });
   return [result];
 }

 function getPointsPercentage() {
    var result = {key: 'pointsPercentage', values: []};

    var points_percentage = data['points_percentage'];

    for (var value in points_percentage) {
      result.values.push({value: points_percentage[value]['result'], range: points_percentage[value]['range'], 
                          points:points_percentage[value]['points'], label: capitalizeFirstLetter(parties[value].name), 
                          color: parties[value].color, order: parties[value].order});
    }

   result.values.sort(function (a, b) { return a.order - b.order; });
   return [result];
 }

 nv.addGraph(function() {
    var chart = nv.models.pieChart()
        .x(function(d) { return d.label })
        .y(function(d) { return d.value })
        .tooltips(true)
        .color(function (item) {  
            if (item.data && item.data.color) return item.data.color;
            return "#333";
        })
        .labelThreshold(.06)
        .tooltipContent(function (key, value, item, graph) {
          var result = '<h3>' + key + '</h3>' + '<p>' + Math.round(value) + '%</p>';
          result += '<p>' + item.point.points + 'p' + '</p>';
          return result;
        })
        .showLabels(true);

    d3.select("#points-percentage-graph svg")
        .datum(getPointsPercentage())
        .transition().duration(500)
        .call(chart);
 
   nv.utils.windowResize(chart.update);

   return chart;
 });

 nv.addGraph(function() {
   var chart = nv.models.discreteBarChart()
      .x(function(d) { return d.label })
      .y(function(d) { return d.value })
      .staggerLabels(true)
      .tooltips(true)
      .tooltipContent(function (id, key, value, item) {
        var result = '<h3>' + key + '</h3>' + '<p>' + Math.round(value) + '%</p>';
        result += '<p>För: ' + item.point.plus_points + 'p</p>';
        result += '<p>Emot: ' + item.point.minus_points + 'p</p>';
        return result;
      })
      .valueFormat(function (value) { return Math.round(value) + "%"; })
      .showValues(true);

   d3.select('#question-agree-rate-graph svg')
       .datum(getQuestionAgreeRate())
       .transition().duration(500)
       .call(chart);
 
   nv.utils.windowResize(chart.update);
 
   return chart;
 });



 
 
</script>

<?php if ($quizSession) { ?>

<?php 
echo $this->Html->link('<i class="fa fa-times"></i> Avsluta',  array('controller' => 'quizzes', 'action' => 'close'), array('class' => 'btn btn-danger', 'escape' => false));
?>

<h2>Sammanställning av resultatet</h2>
<table class="table table-striped">
  <thead>
    <th>Parti</th>
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

<h2>Resultat per fråga</h2>
<ul class="list-unstyled">
<?php foreach ($quizSession['QuizSession']['points']['questions'] as $question) { 
  $userAnswer = $question['answer'];
  $importance = $question['importance'];
  $title = $question['title'];
  ?>
  <li><h3><?php echo $this->Html->link($question['title'], array('controller' => 'questions', 'action' => 'view', 
                                'title' => str_replace(' ', '_', strtolower($question['title'])))); ?></h3>
    <p>Ditt svar: <b><?php echo $userAnswer !== null ? ucfirst($userAnswer) : "Ingen åsikt"; ?></b></p>
    <p>Viktighet (1-9): <b><?php echo $importance; ?></b></p>
    <table class="table table-striped party-result-table">
      <thead>
        <th>Parti</th>
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
  </li>
<?php } ?>
</ul>

<?php } ?>