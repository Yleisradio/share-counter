<?php

/*
 * Delete week old apilog rows.
 * Run with crontab every day 3.00 am.
 * 
 */

class DeleteWeekOldLogsCommand extends CConsoleCommand {

    public function run() {

        $user = Yii::app()->db->createCommand()
                ->delete('apilog', 'timestamp <' . strtotime("-1week"));
    }

}

?>
