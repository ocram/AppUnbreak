<?php

/*
 * AppUnbreak (https://github.com/delight-im/AppUnbreak)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the GNU AGPL v3 (https://www.gnu.org/licenses/agpl-3.0.txt)
 */

namespace App;

use App\Hardware\Device;
use App\Product\Product;
use App\Throwable\InvalidProductIdException;
use App\Throwable\UnknownProductIdException;
use Delight\Foundation\App;

final class DeviceController {

	public static function getDevice(App $app, $product, $vendor, $device) {
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
			$devices = \array_filter($devices, function ($each) use ($device) {
				return $each[Device::FIELD_TITLE] === $device;
			});
			$devices = \array_values($devices);

			if (!empty($devices)) {
				if (\count($devices) === 1) {
					if (\count($devices[0]) === Device::COUNT_FIELDS_RECORD) {
						echo $app->view(
							'device.html.twig',
							[
								'product' => $productConfig[Product::FIELD_TITLE],
								'unofficial' => isset($productConfig[Product::FIELD_UNOFFICIAL]) ? (bool) $productConfig[Product::FIELD_UNOFFICIAL] : false,
								'productSlug' => $product,
								'vendor' => $vendor,
								'device' => $devices[0][Device::FIELD_TITLE],
								'androidMin' => $devices[0][Device::RECORD_FIELD_ANDROID_OS_MIN],
								'androidMax' => $devices[0][Device::RECORD_FIELD_ANDROID_OS_MAX],
								'redirected' => !empty($_GET['redirected']),
							]
						);
					}
					elseif (\count($devices[0]) === Device::COUNT_FIELDS_REDIRECT) {
						$app->setStatus(301);
						$app->redirect('/a/' . \rawurlencode($product) . '/' . \rawurlencode($devices[0][Device::REDIRECT_FIELD_VENDOR]) . '/' . \rawurlencode($devices[0][Device::FIELD_TITLE]));
						exit;
					}
					else {
						$app->setStatus(500);
					}
				}
				else {
					$app->setStatus(500);
				}
			}
			else {
				$app->setStatus(404);
			}
		}
		else {
			$app->setStatus(404);
		}
	}

	private function __construct() {}

}
