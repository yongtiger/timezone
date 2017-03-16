<?php

/**
 * TimeZone
 *
 * @link        http://www.brainbook.cc
 * @see         https://github.com/yongtiger/timezone
 * @author      Tiger Yong <tigeryang.brainbook@outlook.com>
 * @copyright   Copyright (c) 2017 BrainBook.CC
 * @license     http://opensource.org/licenses/MIT
 */

namespace yongtiger\timezone;

use DateTimeZone;
use DateTime;

/**
 * Class TimeZone
 *
 * Usecase #1: using sort flags
 *
 * ```php
 * $tzs = TimeZone::timezone_list(TimeZone::SORT_BY_OFFSET);
 * ```
 *
 * This will generate an array looking like:
 *
 * [Pacific/Midway] => (UTC-11:00) Pacific/Midway
 * [Pacific/Pago_Pago] => (UTC-11:00) Pacific/Pago_Pago
 * [Pacific/Niue] => (UTC-11:00) Pacific/Niue
 * [Pacific/Honolulu] => (UTC-10:00) Pacific/Honolulu
 * [Pacific/Fakaofo] => (UTC-10:00) Pacific/Fakaofo
 * ...
 *
 * Usecase #2: customized your own `static::$timezones`
 *
 * ```php
 * TimeZone::$timezones = DateTimeZone::listIdentifiers();
 * $tzs = TimeZone::timezone_list();
 * ```
 *
 * Usecase #3: using timezone list output format template
 *
 * ```php
 * $tzs = TimeZone::timezone_list(TimeZone::SORT_BY_OFFSET, '(GMT{offset_prefix}{offset_formatted}) {timezone}');
 * $tzs = TimeZone::timezone_list(TimeZone::SORT_BY_OFFSET, '(GMT{offset_prefix}{offset_formatted})');
 * $tzs = TimeZone::timezone_list(TimeZone::SORT_BY_OFFSET, '(UTC{offset_prefix}{offset}) - {timezone}');
 * ```
 *
 * Usecase #4: using timezone output format template
 *
 * ```php
 * echo TimeZone::timezone_format($timeZone)
 * ```
 *
 * @see http://stackoverflow.com/questions/1727077/generating-a-drop-down-list-of-timezones-with-php
 * @package yongtiger\timezone
 */
class TimeZone
{
	const NO_SORT = 0;
	const SORT_BY_TIMEZONE = 1;
	const SORT_BY_OFFSET = 2;

    static $regions = [
        DateTimeZone::AFRICA,
        DateTimeZone::AMERICA,
        DateTimeZone::ANTARCTICA,
        DateTimeZone::ASIA,
        DateTimeZone::ATLANTIC,
        DateTimeZone::AUSTRALIA,
        DateTimeZone::EUROPE,
        DateTimeZone::INDIAN,
        DateTimeZone::PACIFIC,
    ];

    static $timezones = [];
    static $timezone_offsets = [];

	/**
	 * Gets timezone list.
	 *
	 * @param integer $sortFlag
	 * @param string $template
	 * @return array
	 */
	public static function timezone_list($sortFlag = TimeZone::NO_SORT, $template = '(UTC{offset_prefix}{offset_formatted}) - {timezone}')
	{
	    if (empty(static::$timezones)) {
		    foreach (static::$regions as $region) {
		        static::$timezones = array_merge(static::$timezones, DateTimeZone::listIdentifiers($region));
		    }
	    }

	    ///Memory cache
	    if (empty(static::$timezone_offsets)) {
		    foreach (static::$timezones as $timezone) {
		        $tz = new DateTimeZone($timezone);
		        static::$timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
		    }
		}

		///Sort `static::$timezone_offsets`
		if ($sortFlag === TimeZone::SORT_BY_TIMEZONE) {
			ksort(static::$timezone_offsets);
		} else if ($sortFlag === TimeZone::SORT_BY_OFFSET) {
		    $input = &static::$timezone_offsets;
		    uksort($input, function($x, $y) use ($input) {
		       if ($input[$x] == $input[$y]) {
		          return strcmp($x, $y);
		       }
		       return $input[$x] - $input[$y];
		    });
		}

	    $tz_list = [];
	    foreach (static::$timezone_offsets as $timezone => $offset) {
	        $tz_list[$timezone] = static::timezone_format($timezone, $offset/3600, $template);
	    }

	    return $tz_list;
	}

	/**
	 * Formats timezone.
	 *
	 * @param string $timezone
	 * @param string|null $offset
	 * @param string $template
	 * @return string
	 */
	public static function timezone_format($timezone, $offset = null, $template = '(UTC{offset_prefix}{offset_formatted}) - {timezone}')
	{
		if ($offset === null) {
			$offset = (new DateTimeZone($timezone))->getOffset(new DateTime);
		}

        $offset_prefix = $offset < 0 ? '-' : '+';
        $offset_formatted = gmdate( 'H:i', abs($offset) );

		return strtr($template, [
			'{offset}' => abs($offset),
			'{offset_prefix}' => $offset_prefix,
			'{offset_formatted}' => $offset_formatted,
			'{timezone}' => $timezone,
		]);
	}
}