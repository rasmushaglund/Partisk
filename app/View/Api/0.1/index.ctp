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
 * @package     app.View.Questions
 * @license     http://opensource.org/licenses/MIT MIT
 */

$this->Html->addCrumb('Api');
?>

<h1>API version <?php echo Configure::read('apiVersion'); ?></h1>
<p>Följande API används för att hämta ut frågor, svar, partier och taggar.</p>
<h2>Frågor</h2>
<table class="table table-striped table-bordered">
    <tr>
        <td><b>Alla frågor</b></td>
        <td><span>/api/<?php echo $version; ?>/questions</span></td>
        <td><a href="<?php echo Router::url('/', false); ?>api/<?php echo $version; ?>/questions/">Exempel</a></td>
    </tr>
    <tr>
        <td><b>Visa fråga</b></td>
        <td><span>/api/<?php echo $version; ?>/questions/{question_id}</span></td>
        <td><a href="<?php echo Router::url('/', false); ?>api/<?php echo $version; ?>/questions/18">Exempel</a></td>
    </tr>
    <tr>
        <td><b>Visa flera frågor</b></td>
        <td><span>/api/<?php echo $version; ?>/questions/{id 1},{id 2},{...},{id n}</span></td>
        <td><a href="<?php echo Router::url('/', false); ?>api/<?php echo $version; ?>/questions/18,116">Exempel</a></td>
    </tr>
</table>

<div class="row">
    <div class="col-md-6">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Fält</th>
                    <th>Typ</th>
                    <th>Beskrivning</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>question_id</th>
                    <td>integer</td>
                    <td>Frågans unika id</td>
                </tr>
                <tr>
                    <th>title</th>
                    <td>string</td>
                    <td>Frågans namn</td>
                </tr>
                <tr>
                    <th>type</th>
                    <td>string</td>
                    <td>Om frågan är av typen ja/nej (YESNO) eller fritext (CHOICE)</td>
                </tr>
                <tr>
                    <th>description</th>
                    <td>string</td>
                    <td>Beskrivning av frågan</td>
                </tr>
                <tr>
                    <th>created_date</th>
                    <td>timestamp</td>
                    <td>När frågan skapades</td>
                </tr>
                <tr>
                    <th>updated_date</th>
                    <td>timestamp</td>
                    <td>När frågan senast uppdaterades</td>
                </tr>
                <tr>
                    <th>approved_date</th>
                    <td>timestamp</td>
                    <td>När frågan senast godkändes</td>
                </tr>
                <tr>
                    <th>answers</th>
                    <td>[integer]</td>
                    <td>Lista med svarsidn</td>
                </tr>
                <tr>
                    <th>tags</th>
                    <td>[integer]</td>
                    <td>Lista med taggidn</td>
                </tr>
                <tr>
                    <th>revision_id</th>
                    <td>integer</td>
                    <td>Unikt id på frågans revision</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<h2>Svar</h2>
<table class="table table-striped table-bordered">
    <tr>
        <td><b>Alla svar</b></td>
        <td><span>/api/<?php echo $version; ?>/answers</span></td>
        <td><a href="<?php echo Router::url('/', false); ?>api/<?php echo $version; ?>/answers/">Exempel</a></td>
    </tr>
    <tr>
        <td><b>Visa svar</b></td>
        <td><span>/api/<?php echo $version; ?>/answers/{answer_id}</span></td>
        <td><a href="<?php echo Router::url('/', false); ?>api/<?php echo $version; ?>/answers/18">Exempel</a></td>
    </tr>
    <tr>
        <td><b>Visa flera svar</b></td>
        <td><span>/api/<?php echo $version; ?>/answers/{id 1},{id 2},{...},{id n}</span></td>
        <td><a href="<?php echo Router::url('/', false); ?>api/<?php echo $version; ?>/answers/18,14">Exempel</a></td>
    </tr>
</table>

<div class="row">
    <div class="col-md-6">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Fält</th>
                    <th>Typ</th>
                    <th>Beskrivning</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>id</th>
                    <td>integer</td>
                    <td>Svarets unika id</td>
                </tr>
                <tr>
                    <th>answer</th>
                    <td>string</td>
                    <td>Svaret (ofta ja/nej)</td>
                </tr>
                <tr>
                    <th>party_id</th>
                    <td>integer</td>
                    <td>Partiet svaret hör till</td>
                </tr>
                <tr>
                    <th>question_id</th>
                    <td>integer</td>
                    <td>Frågan svaret hör till</td>
                </tr>
                <tr>
                    <th>source</th>
                    <td>string</td>
                    <td>Länk till källan</td>
                </tr>
                <tr>
                    <th>created_date</th>
                    <td>timestamp</td>
                    <td>När svaret skapades</td>
                </tr>
                <tr>
                    <th>updated_date</th>
                    <td>timestamp</td>
                    <td>När svaret senast uppdaterades</td>
                </tr>
                <tr>
                    <th>approved_date</th>
                    <td>timestamp</td>
                    <td>När svaret senast godkändes</td>
                </tr>
                <tr>
                    <th>date</th>
                    <td>timestamp</td>
                    <td>Datumet källan är ifrån</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<h2>Partier</h2>
<table class="table table-striped table-bordered">
    <tr>
        <td><b>Alla partier</b></td>
        <td><span>/api/<?php echo $version; ?>/parties</span></td>
        <td><a href="<?php echo Router::url('/', false); ?>api/<?php echo $version; ?>/parties/">Exempel</a></td>
    </tr>
    <tr>
        <td><b>Visa parti</b></td>
        <td><span>/api/<?php echo $version; ?>/parties/{party_id}</span></td>
        <td><a href="<?php echo Router::url('/', false); ?>api/<?php echo Configure::read('apiVersion'); ?>/parties/1">Exempel</a></td>
    </tr>
    <tr>
        <td><b>Visa flera partier</b></td>
        <td><span>/api/<?php echo $version; ?>/parties/{id 1},{id 2},{...},{id n}</span></td>
        <td><a href="<?php echo Router::url('/', false); ?>api/<?php echo Configure::read('apiVersion'); ?>/parties/1,2">Exempel</a></td>
    </tr>
</table>

<div class="row">
    <div class="col-md-6">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Fält</th>
                    <th>Typ</th>
                    <th>Beskrivning</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>id</th>
                    <td>integer</td>
                    <td>Partiets unika id</td>
                </tr>
                <tr>
                    <th>name</th>
                    <td>string</td>
                    <td>Partiets namn</td>
                </tr>
                <tr>
                    <th>last_result_parliment</th>
                    <td>decimal</td>
                    <td>Resultat i senaste riksdagsval</td>
                </tr>
                <tr>
                    <th>last_result_eu</th>
                    <td>decimal</td>
                    <td>Resultat i senaste EU-val</td>
                </tr>
                <tr>
                    <th>color</th>
                    <td>string</td>
                    <td>Hexadecimal representation av partiets huvudfärg</td>
                </tr>
                <tr>
                    <th>short_name</th>
                    <td>integer</td>
                    <td>Förkortningen av partiets namn</td>
                </tr>
                <tr>
                    <th>website</th>
                    <td>string</td>
                    <td>Partiets hemsida</td>
                </tr>
                <tr>
                    <th>answers</th>
                    <td>[integer]</td>
                    <td>Lista med partiets alla svar</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<h2>Taggar</h2>
<table class="table table-striped table-bordered">
    <tr>
        <td><b>Alla taggar</b></td>
        <td><span>/api/<?php echo $version; ?>/tags</span></td>
        <td><a href="<?php echo Router::url('/', false); ?>api/<?php echo $version; ?>/tags/">Exempel</a></td>
    </tr>
    <tr>
        <td><b>Visa tagg</b></td>
        <td><span>/api/<?php echo $version; ?>/tags/{tag_id}</span></td>
        <td><a href="<?php echo Router::url('/', false); ?>api/<?php echo $version; ?>/tags/35">Exempel</a></td>
    </tr>
    <tr>
        <td><b>Visa flera taggar</b></td>
        <td><span>/api/<?php echo $version; ?>/tags/{id 1},{id 2},{...},{id 3}</span></td>
        <td><a href="<?php echo Router::url('/', false); ?>api/<?php echo $version; ?>/tags/35,120">Exempel</a></td>
    </tr>
</table>

<div class="row">
    <div class="col-md-6">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Fält</th>
                    <th>Typ</th>
                    <th>Beskrivning</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>id</th>
                    <td>integer</td>
                    <td>Taggens unika id</td>
                </tr>
                <tr>
                    <th>name</th>
                    <td>string</td>
                    <td>Taggens namn</td>
                </tr>
                <tr>
                    <th>created_date</th>
                    <td>timestamp</td>
                    <td>Tiden när taggen skapades</td>
                </tr>
                <tr>
                    <th>updated_date</th>
                    <td>timestamp</td>
                    <td>Tiden när taggen senast uppdaterades</td>
                </tr>
                <tr>
                    <th>is_category</th>
                    <td>boolean</td>
                    <td>Om taggen även är en huvudkategori som visas på "Så här tycker partierna"</td>
                </tr>
                <tr>
                    <th>number_of_questions</th>
                    <td>integer</td>
                    <td>Antal frågor som taggen innehåller</td>
                </tr>
                <tr>
                    <th>questions</th>
                    <td>[integer]</td>
                    <td>Alla frågor som taggen innehåller</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>