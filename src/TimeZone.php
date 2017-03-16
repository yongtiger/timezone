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

/**
 * Class TimeZone
 *
 * @package yongtiger\timezone
 */
class TimeZone
{
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

	/*
	This will generate an array looking like:

	[Pacific/Midway] => (UTC-11:00) Pacific/Midway
	[Pacific/Pago_Pago] => (UTC-11:00) Pacific/Pago_Pago
	[Pacific/Niue] => (UTC-11:00) Pacific/Niue
	[Pacific/Honolulu] => (UTC-10:00) Pacific/Honolulu
	[Pacific/Fakaofo] => (UTC-10:00) Pacific/Fakaofo
	…
	It's currently sorted by offsets, but you can easily sort by the timezone name by doing a ksort() instead of asort().
	@see http://stackoverflow.com/questions/1727077/generating-a-drop-down-list-of-timezones-with-php
	*/
	public static function timezone_list()
	{
	    $timezones = [];
	    foreach (static::$regions as $region) {
	        $timezones = array_merge($timezones, DateTimeZone::listIdentifiers($region));
	    }

	    $timezone_offsets = [];
	    foreach ($timezones as $timezone) {
	        $tz = new DateTimeZone($timezone);
	        $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
	    }

	    // asort($timezone_offsets);
	    // ksort($timezone_offsets);
	    $input = &$timezone_offsets;
	    uksort($input, function($x, $y) use ($input) {
	       if ($input[$x] == $input[$y]) {
	          return strcmp($x, $y);
	       }
	       return $input[$x] - $input[$y];
	    });

	    $tz_list = [];
	    foreach ($timezone_offsets as $timezone => $offset) {
	        $offset_prefix = $offset < 0 ? '-' : '+';
	        $offset_formatted = gmdate( 'H:i', abs($offset) );

	        $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

	        $tz_list[$timezone] = "(${pretty_offset}) $timezone";
	    }

	    return $tz_list;
	}
}