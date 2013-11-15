<?php
class AnswerFixture extends CakeTestFixture {

  public $useDbConfig = 'test';
  public $fields = array(
      'id' => array('type' => 'integer', 'key' => 'primary'),
      'party_id' => array('type' => 'integer', 'default' => '0', 'null' => false),
      'answer' => array('type' => 'string', 'length' => 100, 'null' => false),
      'question_id' => array('type' => 'integer', 'default' => '0', 'null' => false),
      'source' => 'text',
      'date' => 'timestamp',
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
      // Same question, different dates (test case for https://github.com/rasmushaglund/Partisk/issues/3)
      array('id' => 1, 'party_id' => 1, 'answer' => 'yes', 'question_id' => '1', 'date' => '2010-01-01', 'created_by' => '1', 'deleted' => '0', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice answer', 
            'approved' => '1', 'approved_by' => '1', 'approved_date' => '2013-01-01'),
      array('id' => 2, 'party_id' => 1, 'answer' => 'no', 'question_id' => '1', 'date' => '2011-01-01', 'created_by' => '1', 'deleted' => '0', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice answer', 
            'approved' => '1', 'approved_by' => '1', 'approved_date' => '2013-01-01'),
      array('id' => 3, 'party_id' => 1, 'answer' => 'maybe', 'question_id' => '1', 'date' => '2009-01-01', 'created_by' => '1', 'deleted' => '0', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice answer', 
            'approved' => '1', 'approved_by' => '1', 'approved_date' => '2013-01-01'),
      array('id' => 4, 'party_id' => 1, 'answer' => 'maybe', 'question_id' => '1', 'date' => '2013-01-01', 'created_by' => '1', 'deleted' => '1', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice answer', 
            'approved' => '1', 'approved_by' => '1', 'approved_date' => '2013-01-01'), // Deleted

      // Ordinary answers for not deleted question
      array('id' => 5, 'party_id' => 2, 'answer' => 'no', 'question_id' => '2', 'date' => '2010-01-01', 'created_by' => '1', 'deleted' => '0', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice answer', 
            'approved' => '1', 'approved_by' => '1', 'approved_date' => '2013-01-01'),
      array('id' => 6, 'party_id' => 3, 'answer' => 'yes', 'question_id' => '2', 'date' => '2010-01-01', 'created_by' => '1', 'deleted' => '0', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice answer', 
            'approved' => '1', 'approved_by' => '1', 'approved_date' => '2013-01-01'),

      // Answer for not approved question
      array('id' => 7, 'party_id' => 3, 'answer' => 'no', 'question_id' => '3', 'date' => '2010-01-01', 'created_by' => '1', 'deleted' => '0', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice answer', 
            'approved' => '0', 'approved_by' => '0', 'approved_date' => '2013-01-01'),

      // Answer for deleted question
      array('id' => 8, 'party_id' => 4, 'answer' => 'no', 'question_id' => '4', 'date' => '2010-01-01', 'created_by' => '1', 'deleted' => '0', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice answer', 
            'approved' => '1', 'approved_by' => '0', 'approved_date' => '2013-01-01')
  );
}

 ?>