<?php

/*
 * AppUnbreak (https://github.com/delight-im/AppUnbreak)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the GNU AGPL v3 (https://www.gnu.org/licenses/agpl-3.0.txt)
 */

namespace App;

use App\Hardware\Device;
use App\Throwable\InvalidProductIdException;
use App\Throwable\UnknownProductIdException;
use Delight\Foundation\App;

final class VendorController {

	public static function getVendor(App $app, $product, $vendor) {
		try {
			$productConfig = ProductController::loadProductConfiguration($app, $product);
		}
		catch (InvalidProductIdException $e) {
			$app->setStatus(400);
			exit;
		}
		catch (UnknownProductIdException $e) {
			$app->setStatus(404);
			exit;
		}

		$devices = Device::getList($vendor);

		if (!empty($devices)) {
			$devices = \array_map(function ($each) {
				return $each[Device::FIELD_TITLE];
			}, $devices);

			$suggestedDevice = Device::fromHttpClient();

			if (!empty($suggestedDevice)) {
				$suggestedDevice = $suggestedDevice[Device::FIELD_TITLE];
			}

			echo $app->view(
				'vendor.html.twig',
				[
					'product' => $productConfig['title'],
					'vendor' => $vendor,
					'suggestedDevice' => $suggestedDevice,
					'devices' => $devices,
				]
			);
		}
		else {
			$app->setStatus(404);
		}
	}

	private function __construct() {}

}
