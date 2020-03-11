<?php

/*
 * AppUnbreak (https://github.com/delight-im/AppUnbreak)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the GNU AGPL v3 (https://www.gnu.org/licenses/agpl-3.0.txt)
 */

namespace App\Android;

final class Version {

	// https://en.wikipedia.org/wiki/Android_version_history#Version_history_by_API_level
	const NUMBERS = [
		'01.00.00',
		'01.01.00',
		'01.05.00',
		'01.06.00',
		'02.00.00',
		'02.00.01',
		'02.01.00',
		'02.02.00',
		'02.02.01',
		'02.02.02',
		'02.02.03',
		'02.03.00',
		'02.03.01',
		'02.03.02',
		'02.03.03',
		'02.03.04',
		'02.03.05',
		'02.03.06',
		'02.03.07',
		'03.00.00',
		'03.01.00',
		'03.02.00',
		'03.02.01',
		'03.02.02',
		'03.02.03',
		'03.02.04',
		'03.02.05',
		'03.02.06',
		'04.00.00',
		'04.00.01',
		'04.00.02',
		'04.00.03',
		'04.00.04',
		'04.01.00',
		'04.01.01',
		'04.01.02',
		'04.02.00',
		'04.02.01',
		'04.02.02',
		'04.03.00',
		'04.03.01',
		'04.04.00',
		'04.04.01',
		'04.04.02',
		'04.04.03',
		'04.04.04',
		'05.00.00',
		'05.00.01',
		'05.00.02',
		'05.01.00',
		'05.01.01',
		'06.00.00',
		'06.00.01',
		'07.00.00',
		'07.01.00',
		'07.01.01',
		'07.01.02',
		'08.00.00',
		'08.01.00',
		'09.00.00',
		'10.00.00',
	];

	public static function listBetween($min, $max) {
		$versions = [];

		foreach (self::NUMBERS as $number) {
			if ($number >= $min && $number <= $max) {
				$versions[] = $number;
			}
		}

		return $versions;
	}

	public static function fromHttpClient() {
		if (!empty($_SERVER['HTTP_USER_AGENT'])) {
			if (\preg_match('/[ ;(]Android ([0-9]{1,2})(?:\.([0-9]{1,2})(?:\.([0-9]{1,2}))?)?[ ;)]/', $_SERVER['HTTP_USER_AGENT'], $matches)) {
				$components = [
					!empty($matches[1]) ? (int) $matches[1] : 0,
					!empty($matches[2]) ? (int) $matches[2] : 0,
					!empty($matches[3]) ? (int) $matches[3] : 0,
				];

				return \sprintf('%02d.%02d.%02d', ...$components);
			}
			else {
				return null;
			}
		}
		else {
			return null;
		}
	}

}
