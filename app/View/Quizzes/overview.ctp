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
$this->Html->addCrumb('Översikt');

?>

<h1>Senaste sparade quiz</h1>
<br />
<table class="table table-striped">
<thead>
	<tr>
	<td>GUID</td>
	<td>Version</td>
	<td>Quiz id</td>
	<td>Skapad</td>
	</tr>
</thead>
<tbody>
<?php foreach ($results as $result) { ?>
<tr>
<td><?php echo $this->Html->link($result['QuizResult']['id'],
		                  array('controller' => 'quizzes', 'action' => 'results', 'guid' => $result['QuizResult']['id'])); ?></td>
<td><?php echo $result['QuizResult']['version']; ?></td>
<td><?php echo $result['QuizResult']['quiz_id']; ?></td>
<td><?php echo $result['QuizResult']['created']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>