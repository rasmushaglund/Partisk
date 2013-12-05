<?php
/** 
 * Questions view
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
 * @package     app.View.Questions
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

$this->Html->addCrumb('Frågor');

?>

<?php if ($current_user) { ?>
<div class="tools">
<?php  echo $this->element('saveQuestion'); 
  echo $this->element('saveAnswer'); ?>
  </div>
 <?php } ?>
 
<?php echo $this->element('qa-table', array(
                  'parties' => $parties,
                  'questions' => $questions,
                  'answers' => $answers,
                  'fixedHeader'  => true
                  )); ?>
