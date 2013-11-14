<?php
App::uses('AppController', 'Controller', 'QuestionController', 'Model', 'Question');

class QuestionsControllerTest extends ControllerTestCase {

  public $fixtures = array('app.question');

  public $testQuestionData = array('title' => 'test', 'tags' => '');

 	public function testIndex() {
      $result = $this->testAction('/questions/index', array('return' => 'contents'));
      debug($result);
  }

  public function testViewWithoutId() {
    try {
      $result = $this->testAction('/questions/view', array('return' => 'contents'));
      $this->fail('Calling a question view without id should rise an exception');
    } catch (NotFoundException $e) {
      debug($e);
    }
  }

  public function testViewWithNonExistingId() {
    try {
      $result = $this->testAction('/questions/view/0', array('return' => 'contents'));
      $this->fail('Calling a question with a invalid id should rise an exception');
    } catch (NotFoundException $e) {
      debug($e);
    }
  }

  public function testAddNotLoggedIn() {
    $this->Controller = $this->generate('Questions', array(
        'models' => array('Question' => array('save', 'create'))
    ));

    $this->controller->Question->expects($this->never())->method('save');
    $this->controller->Question->expects($this->never())->method('create');
    
    $result = $this->testAction('/questions/add', array('return' => 'contents', 'method' => 'post', 'data' => array(
      'Question' => $this->testQuestionData
      )));

    debug($result);
  }

  public function testAddAdminLoggedIn() {
    $this->Controller = $this->generate('Questions', array(
        'components' => array('Auth' => array('user')),
        'models' => array('Question' => array('save', 'create'))
        ));

    $this->Controller->Auth->staticExpects($this->any())->method('user')->will($this->returnCallback(array($this, 'authUserCallback')));

    $this->controller->Question->expects($this->once())->method('save');
    $this->controller->Question->expects($this->once())->method('create');
    
    $result = $this->testAction('/questions/add', array('return' => 'contents', 'method' => 'post', 'data' => array(
      'Question' => $this->testQuestionData
      )));
    debug($result);
  }

  public function testDeleteNotLoggedIn() {
    $this->Controller = $this->generate('Questions', array(
        'models' => array('Question' => array('delete'))
    ));

    $this->controller->Question->expects($this->never())->method('delete');
    
    $result = $this->testAction('/questions/delete/1', array('return' => 'contents'));
    debug($result);
  }

  public function testDeleteAdminLoggedIn() {
    $this->Controller = $this->generate('Questions', array(
        'components' => array('Auth' => array('user')),
        'models' => array('Question' => array('save'))
        ));

    $this->Controller->Auth->staticExpects($this->any())->method('user')->will($this->returnCallback(array($this, 'authUserCallback')));
    $this->controller->Question->expects($this->once())->method('save');
    
    $result = $this->testAction('/questions/delete/1', array('return' => 'contents'));
    debug($result);
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
}
?>	