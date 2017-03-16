# Timezone v0.0.2 ({offset})

[![Latest Stable Version](https://poser.pugx.org/yongtiger/timezone/v/stable)](https://packagist.org/packages/yongtiger/timezone)
[![Total Downloads](https://poser.pugx.org/yongtiger/timezone/downloads)](https://packagist.org/packages/yongtiger/timezone) 
[![Latest Unstable Version](https://poser.pugx.org/yongtiger/timezone/v/unstable)](https://packagist.org/packages/yongtiger/timezone)
[![License](https://poser.pugx.org/yongtiger/timezone/license)](https://packagist.org/packages/yongtiger/timezone)


## FEATURES


## USAGE

* Usecase #1: using sort flags

```php
$tzs = TimeZone::timezone_list(TimeZone::SORT_BY_OFFSET);
```

* This will generate an array looking like:

```
[Pacific/Midway] => (UTC-11:00) Pacific/Midway
[Pacific/Pago_Pago] => (UTC-11:00) Pacific/Pago_Pago
[Pacific/Niue] => (UTC-11:00) Pacific/Niue
[Pacific/Honolulu] => (UTC-10:00) Pacific/Honolulu
[Pacific/Fakaofo] => (UTC-10:00) Pacific/Fakaofo
...
```

* Usecase #2: customized your own `static::$timezones`

```php
TimeZone::$timezones = DateTimeZone::listIdentifiers();
$tzs = TimeZone::timezone_list();
```

* Usecase #3: using output format template

```php
$tzs = TimeZone::timezone_list(TimeZone::SORT_BY_OFFSET, '(GMT{offset_prefix}{offset_formatted}) {timezone}');
$tzs = TimeZone::timezone_list(TimeZone::SORT_BY_OFFSET, '(GMT{offset_prefix}{offset_formatted})');
$tzs = TimeZone::timezone_list(TimeZone::SORT_BY_OFFSET, '(UTC{offset_prefix}{offset}) - {timezone}');
```


## NOTES


## DOCUMENTS


## SEE ALSO

* http://stackoverflow.com/questions/1727077/generating-a-drop-down-list-of-timezones-with-php
* http://stackoverflow.com/questions/24059235/php-sort-an-array-by-value-and-for-equal-values-sort-by-key
* http://stackoverflow.com/questions/31183575/access-array-key-using-uasort-in-php
* http://php.net/manual/en/function.uksort.php
* http://stackoverflow.com/questions/4755704/php-timezone-list
* https://gist.github.com/Xeoncross/1204255
* https://randomdrake.com/2008/08/06/time-zone-abbreviation-difficulties-with-php/

## TODO


## [Development roadmap](docs/development-roadmap.md)


## LICENSE 
**Timezone** is released under the MIT license, see [LICENSE](https://opensource.org/licenses/MIT) file for details.
