<?php

class LinkedInShareTest extends CDbTestCase
{

    public $fixtures = array(
        'sites' => 'Site',
    );

    public function testUpdate()
    {
        $linkedInShare = new LinkedInShare();
        $linkedInShare->site_id = 1;
        $this->assertInternalType('integer', $linkedInShare->fetchValue());
    }

}
