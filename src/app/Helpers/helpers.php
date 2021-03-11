<?php

/**
 * @param string $content
 * @return string
 */
function clearXmlContent(string $content): string
{
    $content = str_replace("<content:encoded><![CDATA[", "<contentEncoded>", $content);
    $content = str_replace("]]></content:encoded>", "</contentEncoded>", $content);
    $content = str_replace("\n", "", $content);
    return $content;
}

/**
 * @param int $year
 * @param int $month
 * @param int $day
 * @return DateTime
 */
function convertToDatetime(int $year, int $month, int $day): string
{
    return date('Y-m-d H:i:s',strtotime("$year-$month-$day"));
}
