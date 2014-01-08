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
 * @package     app.View.Parties
 * @license     http://opensource.org/licenses/MIT MIT
 */

$this->Html->addCrumb('Partier');
?>
<h1>Partier</h1>
<?php if ($this->Permissions->isLoggedIn()) { ?>
<div class="tools">
  <?php echo $this->element('saveParty'); ?>
</div>
<?php } ?>

<table class="table party-table table-bordered table-striped data-table table-hover">
    <thead>
        <th>Parti</th>
        <th>Bästa resultat av senaste EU- och riksdagsval</th>
        <th>Resultat senaste riksdagsval (2010)</th>
        <th>Resultat senaste EU-val (2009)</th>
        <?php if ($this->Permissions->isLoggedIn()) { ?>
        <th>Verktyg</th>
        <?php } ?>
    </thead>
    <tbody>
        <?php foreach ($parties as $party): ?>
        <tr>
            <th>
            <?php echo $this->element('party_header', array('party' => $party['Party'], 'link' => true, 'small' => true, 'title' => true)); ?>
            </th>
            <td><i class="percent"><?php echo round($party['Party']['best_result'], 1); ?>%</i></td>
            <td><i class="percent"><?php echo round($party['Party']['last_result_parliment'], 1); ?>%</i></td>
            <td><i class="percent"><?php echo round($party['Party']['last_result_eu'], 1); ?>%</i></td>
            <?php if ($this->Permissions->isLoggedIn()) { ?>
            <td>
                <?php echo $this->element('partyAdminToolbox', array('party' => $party)); ?>
            </td>
            <?php } ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>