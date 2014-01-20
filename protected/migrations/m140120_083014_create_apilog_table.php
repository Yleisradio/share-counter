<?php

class m140120_083014_create_apilog_table extends CDbMigration
{

    public function up()
    {
        $this->createTable('apilog', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'service' => 'int(2) NOT NULL',
            'timestamp' => 'int(11) NOT NULL',
            'response' => 'text NOT NULL',
            'response_code' => 'int(3) NULL',
            'total_time' => 'float(5,2) NOT NULL',
            'request' => 'text NOT NULL',
            'PRIMARY KEY (id)',
            'KEY `service` (service, timestamp)',
        ));
    }

    public function down()
    {
        $this->dropTable('apilog');
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}