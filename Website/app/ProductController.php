<?php

/*
 * AppUnbreak (https://github.com/delight-im/AppUnbreak)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the GNU AGPL v3 (https://www.gnu.org/licenses/agpl-3.0.txt)
 */

namespace App;

use App\Hardware\Vendor;
use App\Throwable\InvalidProductConfigurationError;
use App\Throwable\InvalidProductIdException;
use App\Throwable\UnknownProductIdException;
use Delight\Foundation\App;

final class ProductController {

	const DEFINITION_STORAGE_PATH = '/products/%s.json';
	const SLUG_REGEX = '/^[A-Za-z0-9_-]+$/';

	public static function getProduct(App $app, $product) {
		try {
			$config = self::loadProductConfiguration($app, $product);
		}
		catch (InvalidProductIdException $e) {
			$app->setStatus(400);
			exit;
		}
		catch (UnknownProductIdException $e) {
			$app->setStatus(404);
			exit;
		}

		echo $app->view(
			'product.html.twig',
			[
				'product' => $config['title']['en'],
				'company' => $config['company']['en'],
				'vendors' => [
					'primary' => Vendor::getList(true),
					'secondary' => Vendor::getList(false),
				],
			]
		);
	}

	/**
	 * Loads the configuration for the specified product
	 *
	 * @param App $app
	 * @param string $product the product ID
	 * @return array the product configuration
	 * @throws InvalidProductIdException
	 * @throws UnknownProductIdException
	 */
	public static function loadProductConfiguration(App $app, $product) {
		if (\preg_match(self::SLUG_REGEX, $product)) {
			$storagePath = \sprintf(self::DEFINITION_STORAGE_PATH, $product);
			$path = $app->getStoragePath($storagePath);

			if (\file_exists($path) && \is_readable($path)) {
				$json = \file_get_contents($path);

				if (!empty($json)) {
					$config = \json_decode($json, true);

					if (!empty($config)) {
						if (!empty($config['title']) && !empty($config['company'])) {
							return $config;
						}
						else {
							throw new InvalidProductConfigurationError();
						}
					}
					else {
						throw new InvalidProductConfigurationError();
					}
				}
				else {
					throw new InvalidProductConfigurationError();
				}
			}
			else {
				throw new UnknownProductIdException();
			}
		}
		else {
			throw new InvalidProductIdException();
		}
	}

	private function __construct() {}

}
