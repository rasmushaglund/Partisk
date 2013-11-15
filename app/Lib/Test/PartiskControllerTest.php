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

}
?>	