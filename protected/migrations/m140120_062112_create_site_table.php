<?php

class m140120_062112_create_site_table extends CDbMigration
{

    public function up()
    {
        $this->createTable('site', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT',
            'url' => 'varchar(512) NOT NULL',
            'updated' => 'int(11) DEFAULT NULL',
            'facebook_shares' => 'int(6) NOT NULL DEFAULT "0"',
            'facebook_likes' => 'int(6) NOT NULL DEFAULT "0"',
            'facebook_comments' => 'int(6) NOT NULL DEFAULT "0"',
            'twitter_tweets' => 'int(6) NOT NULL DEFAULT "0"',
            'linkedin_shares' => 'int(6) NOT NULL DEFAULT "0"',
            'not_changed' => 'int(3) NOT NULL DEFAULT "0"',
            'title' => 'varchar(256) DEFAULT NULL',
            'published' => 'int(11) DEFAULT NULL',
            'shares_per_hour' => 'int(11) NOT NULL DEFAULT "0"',
            'brand' => 'int(2) DEFAULT NULL',
            'page_views' => 'int(11) NOT NULL DEFAULT "0"',
            'PRIMARY KEY (id)',
            'KEY `url` (url(255), updated)',
            'KEY `brand` (`brand`)',
            'KEY `shares_per_hour` (`shares_per_hour`)',
        ));
    }

    public function down()
    {
        $this->dropTable('site');
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