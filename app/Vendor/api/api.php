<?php

// Credits: http://deadlytechnology.com/php/cakephp-api-component/

App::import('Inflector');
class Api extends Object
{
    public $controller;
    public $version = null;
    public $rendered = false;   
 
    /**
     * Error codes for API errors
     */
    private $errorCodes = array(
        1001 => array('httpCode'=>500, 'errorMessage'=>'Version does not exist.'),
        1002 => array('httpCode'=>500, 'errorMessage'=>'Unknown output file.'),
        1003 => array('httpCode'=>500, 'errorMessage'=>'Unrecognised method.'),
    );
 
    /**
     * Retrieve data relating to an API error code
     * 
     * @param $errorCode Int API error code
     * @return Array Data associated with the error code.
     */
    public function getError($errorCode) {
        if (in_array($errorCode, array_keys($this->errorCodes))) {
            return $this->errorCodes[$errorCode];
        }
        return false;
    }
 
    /**
     * Render the API request using a version to select the view.
     * 
     * @return void
     */
    function render($json = null) {      
        $etag = $this->controller->response->etag($json['etag']);
        
        // Only set the data if it is 
        if (!$this->controller->response->checkNotModified($this->controller->request)) {
            $this->controller->set('data', $json['data']);
        
            $this->controller->set('etag', $etag);
            $this->controller->cacheAction = "+1h";
            $this->controller->layout = 'json';
            $this->controller->response->type('json');
            $this->controller->render('/Layouts/json'); 
            $this->rendered = true;
        }
        
        $this->controller->autoRender = false;
    }
    
    function getJson($data) {
        $json = array();
        
        $json['data'] = json_encode($data, JSON_UNESCAPED_SLASHES);
        $json['etag'] = md5($json['data']);
        
        return $json;
    }
 
    /**
     * Dispatch the API request to the corresponding method.
     * 
     * @param $controller Object Controller of original request
     * @return void
     */
    function dispatch(&$controller, $args = null) {
 
        $this->controller =& $controller;
 
        $controllerName = $this->controller->name;
        $actionName = $this->controller->action;
 
        $functionName = Inflector::variable(str_replace('api', Inflector::variable($controllerName), $actionName));
 
        //Check that method exists
        if (method_exists($this, $functionName)) {
            if (isset($args)) {
                $this->$functionName($args);
            } else {
                $this->$functionName();
            }
        }
        else {
            $this->cakeError('apiError', array('apiErrorCode'=>1003));
        }
 
        //Render if it hasn't already done so
        if (!$this->rendered) {
            $this->render();
        }
    }
}