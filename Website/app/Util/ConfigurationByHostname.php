<?php

/*
 * AppUnbreak (https://github.com/delight-im/AppUnbreak)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the GNU AGPL v3 (https://www.gnu.org/licenses/agpl-3.0.txt)
 */

namespace App\Util;

use Delight\Foundation\App;

final class ConfigurationByHostname {

	public static function find(App $app, $key) {
		if (isset($_ENV[$key])) {
			$json = (string) $_ENV[$key];
			$decoded = \json_decode($json, true);

			if ($decoded !== null) {
				if (\is_array($decoded)) {
					if (isset($decoded[$app->getCanonicalHost()])) {
						return (string) $decoded[$app->getCanonicalHost()];
					}
					elseif (isset($decoded[$app->getHost()])) {
						return (string) $decoded[$app->getHost()];
					}

					return null;
				}

				return (string) $decoded;
			}

			return $json;
		}

		return null;
	}

}
