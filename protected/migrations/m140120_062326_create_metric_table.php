<?php

class m140120_062326_create_metric_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('metric', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'site_id' => 'int(11) NOT NULL',
            'timestamp' => 'int(11) NOT NULL',
            'type' => 'int(2) NOT NULL',
            'value' => 'int(11) NOT NULL',
            'PRIMARY KEY (id)',
            'KEY `timestamp` (timestamp, type)',
            'KEY `site_id` (`site_id`)',
        ));
    }

    public function down()
    {
        $this->dropTable('metric');
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