<?php
App::uses('AppController', 'Controller');

class QuestionsControllerTest extends ControllerTestCase {

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
      $result = $this->testAction('/questions/view/1as241fa2s431241251243', array('return' => 'contents'));
      $this->fail('Calling a question with a invalid id should rise an exception');
    } catch (NotFoundException $e) {
      debug($e);
    }
  }

  public function testAddNotLoggedIn() {
      //$this->Controller->expects($this->once())->method('referer');
      $this->testAction('/questions/add');
  }
}
?>	