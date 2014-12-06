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
 * @package     app.Controller
 * @license     http://opensource.org/licenses/MIT MIT
 */

class FeedbacksController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('add'));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Feedback->create();

            $isReport = isset($this->request->data['Feedback']['report']);

            if ($isReport) {
                $this->request->data['Feedback']['text'] = "Error report: " . $this->request->data['Feedback']['report'];
            }

            $this->request->data['Feedback']['ip'] = $this->request->clientIp();
            $this->request->data['Feedback']['date'] = date('c');
            $this->request->data['Feedback']['referer'] = $this->referer();

            if ($this->Feedback->save($this->request->data)) {
                if ($isReport) {
                    $this->customFlash(__('Felrapporten har skickats in, tack för din hjälp!'));
                } else {
                    $this->customFlash(__('Din feedback har skickats in, tack!'));
                }
            } else {
                if ($isReport) {
                    $this->customFlash(__('Kunde inte skicka in din feedback, försök gärna igen.'), 'danger');
                } else {
                    $this->customFlash(__('Detta är pinsamt, din felrapport kunde inte skickas in.'), 'danger');
                }
            }
        }

        return $this->redirect($this->referer());
    }
}

?>