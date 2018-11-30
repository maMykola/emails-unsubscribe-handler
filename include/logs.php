<?php

/**
 * Save given information to process unsubscribe emails later.
 *
 * ASSUMPTION: $info must include at least email and date when
 *             unsubscribe email was send.
 *
 * @param  array  $info
 * @return void
 * @author Mykola Martynov
 **/
function addUnsubscribeEmail($info)
{
    $log_file = LOG_DIR . date('Ymd-H') . '.log';
    $fh = fopen($log_file, 'a');
    fputs($fh, serialize($info) . PHP_EOL);
    fclose($fh);
}
