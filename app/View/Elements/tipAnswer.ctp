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
 * @package     app.View.Elements
 * @license     http://opensource.org/licenses/MIT MIT
 */


$parties = $this->requestAction('parties/all');
$questions = $this->requestAction('questions/all');

echo $this->Bootstrap->create('Answer', array('modal' => true, 'ajax' => true, 'action' => 'tipAnswer', 'label' => 'Tipsa om svar'));
echo $this->Bootstrap->dropdown('party_id', 'Party', array('label' => 'Parti', 'options' => $parties, 
    				'selected' => isset($partyId) ? $partyId : null)); 
echo $this->Bootstrap->dropdown('question_id', 'Question', array('label' => 'Fråga', 'options' => $questions, 'titleField' => 'title', 
    				'selected' => isset($questionId) ? $questionId : null)); 
echo $this->Bootstrap->input('answer', array('label' => 'Svar', 'placeholder' => 'Skriv in partiets svar för frågan (obligatoriskt)'));
echo $this->Bootstrap->input('source', array('label' => 'Källa', 'placeholder' => 'Skriv in vart du hittade svaret (obligatoriskt)'));
echo $this->Bootstrap->date('date', array('label' => 'Datum för källa', 'placeholder' => 'Datumet källan är ifrån. Skriv dagens datum om inget datum anges (obligatoriskt)')); 
echo $this->Bootstrap->textarea('description', array('label' => 'Kommentar', 'placeholder' => 'Skriv om du har någon kommentar'));
echo $this->Bootstrap->end("Skicka in fråga", array('modal' => true)); 

?>