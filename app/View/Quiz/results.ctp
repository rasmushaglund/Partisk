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

$this->Html->addCrumb('Quiz', array('controller' => 'quiz', 'action' => 'index'));
$this->Html->addCrumb('Resultat');

?>


<h3>Resultat</h3>

<div id="points-percentage-graph" class="graph">
  <svg></svg>
  <p class="description">Hur många poäng partierna fått relativt varandra.</p>
</div>
<div id="question-agree-rate-graph" class="graph">
  <svg></svg>
  <p class="description">Hur stor andel av svaren stämmer överens med respetive partis svar.</p>
</div>

<script type="text/javascript">

  var parties = <?php echo json_encode($parties); ?>;
  var data = <?php echo $data; ?>;

  function getQuestionAgreeRate() {
    var result = {key: 'questionAgreeRate', values: []};

    var agree_rate = data["question_agree_rate"];

    for (var value in agree_rate) {
      result.values.push({value: agree_rate[value],
                                        label: capitalizeFirstLetter(parties[value].name), color: parties[value].color});      
    }

   return [result];
 }

 function getPointsPercentage() {
    var result = {key: 'pointsPercentage', values: []};

    var points_percentage = data['points_percentage'];

    for (var value in points_percentage) {
      result.values.push({value: points_percentage[value],
                                        label: capitalizeFirstLetter(parties[value].name), color: parties[value].color});
    }

   return [result];
 }

 nv.addGraph(function() {
    var chart = nv.models.pieChart()
        .x(function(d) { return d.label })
        .y(function(d) { return d.value })
        .tooltips(true)
        .color(function (item) {  return item.data.color; })
        .labelThreshold(.06)
        .tooltipContent(function (key, value, e, graph) {
          return '<h3>' + key + '</h3>' + '<p>' + Math.round(value) + '%</p>' ;
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
      .tooltipContent(function (e, key, value, graph) {
        return '<h3>' + key + '</h3>' + '<p>' + Math.round(value) + '%</p>' ;
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

<?php if ($ownQuiz) { ?>

<?php 
echo $this->Html->link('<i class="fa fa-times"></i> Avsluta', '/quiz/close', array('class' => 'btn btn-danger', 'escape' => false));
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
    $partyPoints = $points['parties'][$party['id']];
  ?>
    <tr>
    <td><?php echo ucfirst($party['name']); ?></td>
    <td><?php echo $partyPoints['matched_questions']; ?> st</td>
    <td><?php echo $partyPoints['missmatched_questions']; ?> st</td>
    <td><?php echo $partyPoints['matched_questions']+$partyPoints['missmatched_questions']; ?> st</td>
    <td><?php echo $partyPoints['points']; ?> poäng</td>
    </tr>
<?php } ?>
</tbody>
</table>



<h2>Resultat per fråga</h2>
<ul class="list-unstyled">
<?php foreach ($points['questions'] as $question) { 
  $userAnswer = $question['answer'];
  $importance = $question['importance'];
  $title = $question['title'];
  ?>
  <li><h3><?php echo $title; ?></h3>
    <p>Ditt svar: <b><?php echo $userAnswer !== null ? ucfirst($userAnswer) : "Ingen åsikt"; ?></b></p>
    <p>Viktighet (1-3): <b><?php echo $importance; ?></b></p>
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

          <tr>
              <td><?php echo ucfirst($party['name']); ?></td>
            
          <?php 

            $partyAnswer = $question['parties'][$partyId]['answer'];
            $partyPoints = $question['parties'][$partyId]['points'];

            if ($userAnswer === null) { ?>
              <td>Inget svar</td>
              <td><?php echo $partyPoints . 'p'; ?></td>
            <?php } else if ($question['parties'][$partyId]['answer'] != null) {
            $sameAnswer = $partyAnswer == $userAnswer;
            ?>
              <td class="<?php echo $sameAnswer ? 'matching-answer' : '' ?>"><?php echo ucfirst($partyAnswer); ?></td>
              <td><?php echo (intval($partyPoints)/intval($importance)) . '*' . $importance . '=' . $partyPoints . 'p'; ?></td>
            <?php } else { ?>
              <td>Inget svar</td>
              <td><?php echo $partyPoints . 'p'; ?></td>
            <?php } ?>
            </tr>
        <?php } ?>
      </tbody>
    </table>
  </li>
<?php } ?>
</ul>

<?php } ?>