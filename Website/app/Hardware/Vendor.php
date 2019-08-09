<?php

/*
 * AppUnbreak (https://github.com/delight-im/AppUnbreak)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the GNU AGPL v3 (https://www.gnu.org/licenses/agpl-3.0.txt)
 */

namespace App\Hardware;

final class Vendor {

	const FIELD_TITLE = 0;
	const FIELD_POPULARITY = 1;

	public static function getList($leading = null) {
		$results = [];

		if (!isset($leading) || $leading === true) {
			$results = \array_merge($results, [
				[ 'Honor', 0.0334 ],
				[ 'Huawei', 0.2626 ],
				[ 'Lenovo', 0.0355 ],
				[ 'LG', 0.0235 ],
				[ 'Motorola', 0.0725 ],
				[ 'Nokia', 0.0277 ],
				[ 'OnePlus', 0.0548 ],
				[ 'Samsung', 1.0000 ],
				[ 'Sony', 0.0483 ],
				[ 'Xiaomi', 0.2143 ],
			]);
		}

		if (!isset($leading) || $leading === false) {
			$results = \array_merge($results, [
				[ 'Acer', 0.0079 ],
				[ 'Asus', 0.0206 ],
				[ 'BQ', 0.0000 ],
				[ 'Fero', 0.0018 ],
				[ 'Google', 0.0054 ],
				[ 'HTC', 0.0039 ],
				[ 'LeEco', 0.0019 ],
				[ 'Meizu', 0.0028 ],
				[ 'Oppo', 0.0114 ],
				[ 'Vivo', 0.0053 ],
				[ 'ZTE', 0.0039 ],
				[ 'Android', 0.0000 ],
			]);
		}

		return $results;
	}

	public static function fromHttpClient() {
		if (!empty($_SERVER['HTTP_USER_AGENT'])) {
			$ua = $_SERVER['HTTP_USER_AGENT'];

			if (\strpos($ua, '; SAMSUNG ') !== false || \strpos($ua, '; SAMSUNG-') !== false) {
				return 'Samsung';
			}
			elseif (\strpos($ua, '; ONEPLUS ') !== false) {
				return 'OnePlus';
			}
			elseif (\strpos($ua, '; HUAWEI ') !== false || \strpos($ua, ' Build/HUAWEI') !== false || \strpos($ua, ' Build/Huawei') !== false) {
				return 'Huawei';
			}
			elseif (\strpos($ua, ' XiaoMi/') !== false || \strpos($ua, '; Redmi Note ') !== false || \strpos($ua, '; Redmi ') !== false) {
				return 'Xiaomi';
			}
			elseif (\strpos($ua, '; Pixel ') !== false || \strpos($ua, '; Nexus ') !== false) {
				return 'Google';
			}
			elseif (\strpos($ua, '; ASUS_') !== false) {
				return 'Asus';
			}
			elseif (\strpos($ua, '; Lenovo ') !== false) {
				return 'Lenovo';
			}
			elseif (\strpos($ua, '; HTC ') !== false) {
				return 'HTC';
			}
			elseif (\strpos($ua, '; ZTE ') !== false) {
				return 'ZTE';
			}
			elseif (\strpos($ua, '; vivo ') !== false) {
				return 'Vivo';
			}
			elseif (\strpos($ua, '; Nokia ') !== false) {
				return 'Nokia';
			}
			elseif (\strpos($ua, '; Xperia ') !== false) {
				return 'Sony';
			}
			elseif (\strpos($ua, '; Moto ') !== false || \strpos($ua, '; moto ') !== false) {
				return 'Motorola';
			}
			elseif (\strpos($ua, '; LG-') !== false) {
				return 'LG';
			}
			elseif (\strpos($ua, ' OppoBrowser/') !== false) {
				return 'Oppo';
			}
			else {
				return null;
			}
		}
		else {
			return null;
		}
	}

	private function __construct() {}

}
