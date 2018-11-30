#!/usr/bin/env php
<?php

include_once __DIR__ . '/config/parameters.php';
require_once __DIR__ . '/include/constants.php';
require_once __DIR__ . '/include/messages.php';
require_once __DIR__ . '/include/logs.php';

# set default permission for log files
umask(027);

# get message headers
$headers = getMessageHeaders(STDIN);

# check to, subject to match unsubscribe
$from = extractEmail(getHeaderValue($headers, 'from'));
$to = extractEmail(getHeaderValue($headers, 'to'));
$subject = strtolower(getHeaderValue($headers, 'subject'));

# save sender email to the log file if criteria matched
if (!empty($to) && !empty($subject) && $to == LIST_UNSUBSCRIBE_EMAIL && $subject == LIST_UNSUBSCRIBE_SUBJECT) {
    $date = getHeaderValue($headers, 'date', date('Y-m-d H:i:s'));
    addUnsubscribeEmail([
        'email' => $from,
        'date' => $date,
        ]);
}
