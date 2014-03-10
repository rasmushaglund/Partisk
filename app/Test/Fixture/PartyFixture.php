<?php
class PartyFixture extends CakeTestFixture {

  public $useDbConfig = 'test';
  public $fields = array(
      'id' => array('type' => 'integer', 'key' => 'primary'),
      'name' => array('type' => 'string', 'length' => 200, 'null' => false),
      'website' => 'text',
      'color' => 'text',
      'created_by' => array('type' => 'integer', 'null' => false),
      'deleted' => array('type' => 'integer', 'default' => '0', 'null' => false),
      'updated_by' => array('type' => 'integer', 'null' => false),
      'updated_date' => 'timestamp',
      'created_date' => 'timestamp',
      'description' => 'text',
      'last_result_parliment' => 'float', 
      'last_result_eu' => 'float'
  );
  public $records = array(
      array('id' => 1, 'name' => 'Party1', 'website' => 'Website1', 'color' => '#fff', 'deleted' => '0', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice party 1', 
            'last_result_parliment' => '5', 'last_result_eu' => '3', 'created_by' => '1'),
      array('id' => 2, 'name' => 'Party2', 'website' => 'Website3', 'color' => '#fff', 'deleted' => '0', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice party 1', 
            'last_result_parliment' => '6', 'last_result_eu' => '2', 'created_by' => '1'),
      array('id' => 3, 'name' => 'Party3', 'website' => 'Website4', 'color' => '#fff', 'deleted' => '0', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice party 1', 
            'last_result_parliment' => '4', 'last_result_eu' => '8', 'created_by' => '1'),

      // Deleted
      array('id' => 4, 'name' => 'Party4', 'website' => 'Website2', 'color' => '#fff', 'deleted' => '1', 
            'updated_by' => '0', 'updated_date' => '2012-03-18', 'created_date' => '2012-01-18', 'description' => 'Nice party 1', 
            'last_result_parliment' => '10', 'last_result_eu' => '20', 'created_by' => '1')
  );
}

 ?>