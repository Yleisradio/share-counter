<?php

/**
 * Test checks, that DeleteWeekOldLogsCommand will work correctly.
 */
class DeleteWeekOldLogsCommandTest extends CDbTestCase {

    public $fixtures = array(
        'apilog' => 'Apilog',
    );

    public function testRun() {
        DeleteWeekOldLogsCommand::run();

        $apilog = $this->apilog('new');
        $this->assertNotNull($apilog);

        $apilog = $this->apilog('old');
        $this->assertNull($apilog);
    }

}
