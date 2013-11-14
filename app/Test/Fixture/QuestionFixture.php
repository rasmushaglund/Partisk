<?php
class QuestionFixture extends CakeTestFixture {

  public $useDbConfig = 'test';
  public $fields = array(
      'id' => array('type' => 'integer', 'key' => 'primary'),
      'title' => array('type' => 'string', 'length' => 200, 'null' => false),
      'type' => 'text',
      'created_by' => array('type' => 'integer', 'null' => false),
      'deleted' => array('type' => 'integer', 'default' => '0', 'null' => false),
      'updated_by' => array('type' => 'integer', 'null' => false),
      'updated_date' => 'timestamp',
      'created_date' => 'timestamp',
      'description' => 'text',
      'approved' => array('type' => 'integer', 'default' => '0', 'null' => false), 
      'approved_by' => array('type' => 'integer', 'default' => '0', 'null' => false),
      'approved_date' => 'timestamp'
  );
  public $records = array(
      array('id' => 1, 'title' => 'Question1', 'type' => 'YESNO', 'created_by' => '1', 'deleted' => '0', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice question', 
            'approved' => '1', 'approved_by' => '1', 'approved_date' => '2013-01-01'),
      array('id' => 2, 'title' => 'Question2', 'type' => 'YESNO', 'created_by' => '2', 'deleted' => '1', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice question', 
            'approved' => '1', 'approved_by' => '1', 'approved_date' => '2013-01-01'),
      array('id' => 3, 'title' => 'Question3', 'type' => 'YESNO', 'created_by' => '3', 'deleted' => '0', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice question', 
            'approved' => '0', 'approved_by' => '1', 'approved_date' => '2013-01-01')
  );
}

 ?>