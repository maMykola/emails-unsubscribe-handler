<?php

/**
 * Return email message headers and read lines from given file handler.
 * All header keys changed to lowercase.
 *
 * @param  resource  $fh
 * @return array
 * @author Mykola Martynov
 **/
function getMessageHeaders($fh)
{
    $headers = [];
    $key = '';

    while (!feof($fh)) {
        $line = rtrim(fgets($fh));
        if (empty($line)) {
            break;
        }

        # add value to previously added header
        if (preg_match('#^[\s\t]+(?P<data>.*)$#', $line, $match)) {
            $headers[$key] .= ' ' . $match['data'];
            continue;
        }

        # otherwise get new key/value pair
        if (preg_match('#^(?P<key>.*?):\s*(?P<value>.*)$#', $line, $match)) {
            $key = strtolower($match['key']);
            $headers[$key] = $match['value'];
            continue;
        }

        # if message header invalid, clear previous key
        $key = '';
    }

    return $headers;
}

/**
 * Extract email from the given text.
 *
 * @param  string  $text
 * @return string
 * @author Mykola Martynov
 **/
function extractEmail($text)
{
    $email = filter_var(trim($text), FILTER_VALIDATE_EMAIL);
    if (!empty($email)) {
        return $email;
    }

    if (!preg_match('#<(?P<email>.*?)>#', $text, $match)) {
        return '';
    }

    return $match['email'];
}

/**
 * Return value from the headers list with given key.
 *
 * ASSUMPTION: key must be lowercase.
 *
 * @param  array   $headers
 * @param  string  $key
 * @param  string  $default
 * @return string
 * @author Mykola Martynov
 **/
function getHeaderValue($headers, $key, $default = '')
{
    return array_key_exists($key, $headers) ? $headers[$key] : $default;
}
