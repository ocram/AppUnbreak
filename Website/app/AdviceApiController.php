<?php

/*
 * AppUnbreak (https://github.com/delight-im/AppUnbreak)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the GNU AGPL v3 (https://www.gnu.org/licenses/agpl-3.0.txt)
 */

namespace App;

use App\Android\Version;
use Delight\Db\Throwable\IntegrityConstraintViolationException;
use Delight\Foundation\App;

final class AdviceApiController {

	public static function postVote(App $app, $direction) {
		if ($direction === 'up') {
			$addend = 1;
		}
		elseif ($direction === 'down') {
			$addend = -1;
		}
		else {
			$app->setStatus(400);
			exit;
		}

		$adviceId = $app->input()->post('adviceId', \TYPE_STRING);
		$userId = \sha1($app->getClientIp() . "\n" . \date('Y-m-d') . "\n" . $adviceId);
		$vendorName = $app->input()->post('vendorName', \TYPE_STRING);
		$deviceName = $app->input()->post('deviceName', \TYPE_STRING);
		$osVersionMin = $app->input()->post('osVersionMin', \TYPE_STRING);
		$osVersionMax = $app->input()->post('osVersionMax', \TYPE_STRING);

		if (empty($adviceId) || empty($vendorName) || empty($deviceName) || empty($osVersionMin) || empty($osVersionMax)) {
			$app->setStatus(400);
			exit;
		}

		if (\strlen($osVersionMin) !== 8 || \strlen($osVersionMax) !== 8) {
			$app->setStatus(400);
			exit;
		}

		$versions = Version::listBetween($osVersionMin, $osVersionMax);

		try {
			$app->db()->insert(
				'advice_votes',
				[
					'advice_id' => $adviceId,
					'user_id' => $userId,
					'cast_at' => \time(),
				]
			);
		}
		catch (IntegrityConstraintViolationException $e) {
			$app->setStatus(403);
			exit;
		}

		$app->db()->exec(
			'INSERT INTO advice_for_devices (advice_id, vendor, device, relevance) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE relevance = relevance + VALUES(relevance)',
			[
				$adviceId,
				$vendorName,
				$deviceName,
				$addend
			]
		);

		foreach ($versions as $version) {
			$app->db()->exec(
				'INSERT INTO advice_for_os_versions (advice_id, vendor, os_version, relevance) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE relevance = relevance + VALUES(relevance)',
				[
					$adviceId,
					$vendorName,
					$version,
					$addend
				]
			);
		}
	}

}
