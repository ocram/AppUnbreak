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
				[ 'Honor', 0 ],
				[ 'Huawei', 0 ],
				[ 'Lenovo', 0 ],
				[ 'LG', 0 ],
				[ 'Motorola', 0 ],
				[ 'Nokia', 0 ],
				[ 'OnePlus', 0 ],
				[ 'Samsung', 0 ],
				[ 'Sony', 0 ],
				[ 'Xiaomi', 0 ],
			]);
		}

		if (!isset($leading) || $leading === false) {
			$results = \array_merge($results, [
				[ 'Acer', 0 ],
				[ 'Asus', 0 ],
				[ 'BQ', 0 ],
				[ 'Fero', 0 ],
				[ 'Google', 0 ],
				[ 'HTC', 0 ],
				[ 'LeEco', 0 ],
				[ 'Meizu', 0 ],
				[ 'Oppo', 0 ],
				[ 'Vivo', 0 ],
				[ 'ZTE', 0 ],
				[ 'Android', 0 ],
			]);
		}

		return $results;
	}

	public static function fromHttpClient() {
		if (!empty($_SERVER['HTTP_USER_AGENT'])) {
			$ua = $_SERVER['HTTP_USER_AGENT'];

			if (\preg_match('/[0-9]; (?:SAMSUNG[ -])?(?:SM|GT)-[A-Z0-9]{4,}/', $ua) === 1) {
				return 'Samsung';
			}
			elseif (\preg_match('/[0-9]; (?:ALE-L21|AMN-LX9|ANE-LX1|ANE-LX2|ATU-L21|BLA-L09|BLA-L29|CLT-L09|CLT-L29|DUB-LX1|ELE-L29|EML-L09|EML-L29|EVA-L09|EVR-L29|FIG-LX1|GRA-L09|HMA-L29|INE-LX1|LDN-L21|LYA-L09|LYA-L29|MAR-LX1A|MAR-LX1B|MAR-LX1M|MAR-LX2|MHA-L29|MRD-LX1|MYA-L11|PIC-LX9|POT-LX1|PRA-LX1|RNE-L21|SNE-LX1|STK-LX1|TRT-LX1|VKY-L09|VNS-L31|VOG-L04|VOG-L09|VOG-L29|VTR-L09|WAS-LX1|WAS-LX1A)/', $ua) === 1) {
				return 'Huawei';
			}
			elseif (\preg_match('/[0-9]; HUAWEI [A-Z0-9]{2,4}-/', $ua) === 1) {
				return 'Huawei';
			}
			elseif (\preg_match('/[0-9]; (?:BKL-L09|BLN-L21|BND-L21|COL-L29|DUA-L22|FRD-L09|HRY-LX1|JSN-L21|KIW-L21|LLD-L31|PCT-L29|STF-L09|YAL-L21|YAL-L41)/', $ua) === 1) {
				return 'Honor';
			}
			elseif (\preg_match('/; Redmi(?: Note)? [A-Z0-9]{1,3}[ )]/', $ua) === 1) {
				return 'Xiaomi';
			}
			elseif (\preg_match('/; M[Ii](?: Note| MAX| MIX| PLAY)? [0-9A-Z]{1,2}[ )]/', $ua) === 1) {
				return 'Xiaomi';
			}
			elseif (\preg_match('/[0-9]; Pixel [0-9A-Z]/', $ua) === 1) {
				return 'Google';
			}
			elseif (\preg_match('/; Nexus [0-9][A-Z]?[ )]/', $ua) === 1) {
				return 'Google';
			}
			elseif (\preg_match('/[0-9]; ONEPLUS [A0-9]{5}[ )]/', $ua) === 1) {
				return 'OnePlus';
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
