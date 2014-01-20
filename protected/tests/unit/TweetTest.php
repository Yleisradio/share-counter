<?php

class TweetTest extends CDbTestCase
{

    public $fixtures = array(
        'sites' => 'Site',
    );

    public function testUpdate()
    {
        $tweet = new Tweet();
        $tweet->site_id = 1;
        $this->assertInternalType('integer', $tweet->fetchValue());
    }

}
