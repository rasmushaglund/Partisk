<?php
App::uses('AppController', 'Controller', 'QuestionController', 'Model', 'Question');
App::uses('PartiskControllerTest', 'Test');

class QuestionsControllerTest extends PartiskControllerTest {

  public $fixtures = array('app.question', 'app.answer', 'app.party');

  public $testQuestionData = array('title' => 'test', 'tags' => '');

 	public function testIndex() {
      $result = $this->testAction('/questions/index', array('return' => 'vars'));

      $this->assertNotEquals($this->search($result['answers'], 'id', 2), null);

      // No deleted answers/questions should be displayed unless the user is logged in
      $this->assertEquals($this->search($result['answers'], 'deleted', 1), null);
      $this->assertEquals($this->search($result['questions'], 'deleted', 1), null);

      $this->assertTrue(sizeof($result['answers']) == 3);
      $this->assertTrue(sizeof($result['parties']) == 3);
      $this->assertTrue(sizeof($result['questions']) == 4);

      // The multiple answers that belong to the same party and question should be reduced to one
      $this->assertTrue(sizeof($result['answers'][1]['answers']) == 1);
      $this->assertTrue(sizeof($result['answers'][2]['answers']) == 2);
      //debug($result);
  }

  public function testViewWithoutId() {
    $result = null;
    try {
      $result = $this->testAction('/questions/view', array('return' => 'vars'));
      $this->fail('Calling a question view without id should rise an exception');
    } catch (NotFoundException $e) {
      debug($e);
    }
  }

  public function testViewWithNonExistentId() {
    $result = null;
    try {
      $result = $this->testAction('/questions/view/1337', array('return' => 'vars'));
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

  public function testViewNotLoggedIn() {
    $result = $this->testAction('/questions/view/3', array('return' => 'vars'));
    $this->assertFalse(empty($result['answers']));
    $this->assertFalse(empty($result['question']));
    $this->assertEquals($this->search($result['answers'], 'deleted', 1), null);
    $this->assertTrue(sizeof($result['answers']) == 1);
    //debug($result);
  }

  public function testViewLoggedIn() {
    $this->init('Questions');
    $this->login();
    $result = $this->testAction('/questions/view/4', array('return' => 'vars'));
    $this->assertFalse(empty($result['answers']));
    $this->assertFalse(empty($result['question']));
    $this->assertNotEquals($this->search($result['question'], 'deleted', 1), null);
    $this->assertTrue(sizeof($result['answers']) == 1);
  }

  public function testViewWithNoAnswers() {
    $result = $this->testAction('/questions/view/5', array('return' => 'vars'));
    $this->assertTrue(empty($result['answers']));
    $this->assertFalse(empty($result['question']));
  }

  public function testAddNotLoggedIn() {
    $this->init('Questions', array(
        'methods' => array('abuse'),
        'models' => array('Question' => array('save', 'create'))
    ));

    $this->controller->Question->expects($this->never())->method('save');
    $this->controller->Question->expects($this->never())->method('create');
    $this->controller->expects($this->once())->method('abuse');
    
    $result = $this->testAction('/questions/add', array('return' => 'contents', 'method' => 'post', 'data' => array(
      'Question' => $this->testQuestionData
      )));
  }

  public function testAddAdminLoggedIn() {
    $this->init('Questions', array(
        'components' => array('Auth' => array('user')),
        'models' => array('Question' => array('save', 'create'))
        ));
    $this->login();

    $this->controller->Question->expects($this->once())->method('save');
    $this->controller->Question->expects($this->once())->method('create');
    
    $result = $this->testAction('/questions/add', array('return' => 'contents', 'method' => 'post', 'data' => array(
      'Question' => $this->testQuestionData
      )));
    debug($result);
  }

  public function testAddAndLoad() {
    $this->init('Questions', array(
        'components' => array('Auth' => array('user'))
        ));
    $this->login();

    $questionData = $this->testQuestionData;

    $this->testAction('/questions/add', array('return' => 'contents', 'method' => 'post', 'data' => array(
      'Question' => $questionData
      )));

    $this->Controller->Question->recursive = -1;
    $question = $this->Controller->Question->findById($this->Controller->Question->getLastInsertId());

    $this->assertEquals($question['Question']['title'], $questionData['title']);
  }

  public function testSaveError() {
    $this->init('Questions', array(
        'methods' => array('addTags'),
        'components' => array('Auth' => array('user')),
        'models' => array('Question' => array('save'))
        ));
    $this->login();

    $this->testAction('/questions/add', array('return' => 'contents', 'method' => 'post', 'data' => array(
      'Question' => array()
      )));

    $this->controller->expects($this->never())->method('addTags');
  }

  public function testDeleteNotLoggedIn() {    
    $this->init('Questions', array(
        'methods' => array('abuse'),
        'models' => array('Question' => array('delete'))
    ));

    $this->controller->Question->expects($this->never())->method('delete');
    $this->controller->expects($this->once())->method('abuse');
    
    $result = $this->testAction('/questions/delete/1', array('return' => 'contents'));
    debug($result);
  }

  public function testDeleteAdminLoggedIn() {
    $this->init('Questions', array('models' => array('Question' => array('save'))));
    $this->login();

    $this->controller->Question->expects($this->once())->method('save');
    $this->controller->expects($this->never())->method('abuse');
    
    $result = $this->testAction('/questions/delete/1', array('return' => 'contents'));
    debug($result);
  }

  public function testDelete() {
    $this->init('Questions');
    $this->login();

    $result = $this->testAction('/questions/delete/1', array('return' => 'contents'));

    $this->Controller->Question->recursive = -1;
    $question = $this->Controller->Question->findById(1);
    $this->assertEquals($question['Question']['deleted'], 1);
  }
}
?>	