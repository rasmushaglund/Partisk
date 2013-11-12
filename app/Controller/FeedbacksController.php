<?php
/** 
 * Controller for managing feedback to the user
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
 * @package     app.Controller
 * @license     http://www.gnu.org/licenses/ GPLv2
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