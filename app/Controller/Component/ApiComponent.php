<?php 

// Credits: http://deadlytechnology.com/php/cakephp-api-component/

App::import('Vendor', 'Api_0_1', array('file' =>'api'.DS.'0.1'.DS.'api.php'));
class ApiComponent extends Component
{
    public $api = null;

    /**
     * Initialize API component.
     * Called before Controller::beforeFilter()
     *
     * @param $controller
     * @param $settings
     * @return void
     */
    function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    /**
     * Dispatch the API request to the correct API class depending on version
     *
     * @return void
     */
    function dispatch() {

        //Want to dispatch to correct method in API class, get the name of the class
        $className = 'Api_'.str_replace('.', '_', $this->controller->params['version']);

        //Confirm class exists
        if (class_exists($className)) {
            $this->api = new $className();
        }
        else {
            //No need to worry about apiErrors just at the moment
            $this->cakeError('apiError', array('apiErrorCode'=>1001));
        }

        //Pass in controller
        $this->api->dispatch($this->controller, $this->controller->params['args']);
    }
}

?>