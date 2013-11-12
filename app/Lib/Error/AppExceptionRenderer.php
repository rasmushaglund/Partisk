<?php
// http://stackoverflow.com/questions/9620363/cakephp-2-0-how-to-make-custom-error-pages
App::uses('ExceptionRenderer', 'Error');

class AppExceptionRenderer extends ExceptionRenderer {

    public function notFound($error) {
        $this->controller->redirect(array('controller' => 'errors', 'action' => 'error404'));
    }
}