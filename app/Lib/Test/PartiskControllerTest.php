<?php
App::uses('AppController', 'Controller', 'QuestionController', 'Model', 'Question');

class PartiskControllerTest extends ControllerTestCase {

  public function login($role = null) {
      $this->Controller->Auth->staticExpects($this->any())->method('user')->will(
        $this->returnCallback(array($this, 'authUserCallback')));
  }

  public function authUserCallback($param){
    $user = array(
        'id' => 1,
        'username' => 'test',
        'Role' => array('name' => 'admin')
    );

    if(empty($param)){
        return $user;
    } else {
        return $user[$param];
    }
  }

  public function init($model, $args = null) {
    $generateArgs = array('components' => array('Auth' => array('user')));
    if ($args != null) $generateArgs = array_merge($generateArgs, $args);
    $this->Controller = $this->generate($model, $generateArgs);
  }


  //http://stackoverflow.com/questions/1019076/how-to-search-by-key-value-in-a-multidimensional-array-in-php/1019126#1019126
  public function search($array, $key, $value) {
    $results = array();

    $this->search_r($array, $key, $value, $results);

    return empty($results) ? null : $results;
  }

  public function search_r($array, $key, $value, &$results) {
    if (!is_array($array))
        return;

    if (isset($array[$key]) && $array[$key] == $value)
        $results[] = $array;

    foreach ($array as $subarray)
        $this->search_r($subarray, $key, $value, $results);
  }
}
?>	