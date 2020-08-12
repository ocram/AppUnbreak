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

			// unless automatic redirects are prevented using a query parameter
			if (!isset($_GET['redirect']) || $_GET['redirect'] === '1') {
				// try to detect the device automatically
				$suggestedDevice = Device::fromHttpClient();

				// if a known device has been detected
				if (!empty($suggestedDevice)) {
					// indicate that a temporary redirect will be performed
					$app->setStatus(302);
					// indicate that the redirect depends on the specific `User-Agent` value
					\header('Vary: User-Agent');
					// redirect to the page for the detected device
					\header('Location: ' . $app->urlWithLang($app->currentRoute() . '/' . \rawurlencode($suggestedDevice[Device::FIELD_TITLE]) . '?redirected=1'));
					exit;
				}
			}

			echo $app->view(
				'vendor.html.twig',
				[
					'product' => $productConfig[Product::FIELD_TITLE],
					'unofficial' => isset($productConfig[Product::FIELD_UNOFFICIAL]) ? (bool) $productConfig[Product::FIELD_UNOFFICIAL] : false,
					'vendor' => $vendor,
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
