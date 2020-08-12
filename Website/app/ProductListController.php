<?php

/*
 * AppUnbreak (https://github.com/delight-im/AppUnbreak)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the GNU AGPL v3 (https://www.gnu.org/licenses/agpl-3.0.txt)
 */

namespace App;

use App\Product\Product;
use App\Throwable\Error;
use App\Throwable\InvalidProductConfigurationError;
use App\Throwable\InvalidProductIdError;
use App\Throwable\ProductConfigurationReadError;
use App\Throwable\ProductConfigurationSearchError;
use Delight\Foundation\App;
use Delight\Foundation\Throwable\NoSupportedLocaleError;
use Delight\I18n\Codes;
use Delight\I18n\Locale;

final class ProductListController {

	const GLOB_PATTERN_DEFINITION_FILES = '/products/*.json';
	const FILE_EXTENSION_DEFINITION_FILES = 'json';
	const SLUG_REGEX = '/^[A-Za-z0-9_-]+$/';

	public static function getList(App $app) {
		$configs = self::loadProductConfigurations($app);

		echo $app->view(
			'product_list.html.twig',
			[
				'products' => $configs,
			]
		);
	}

	/**
	 * Loads the configurations for all products
	 *
	 * @param App $app
	 * @return array the product configurations
	 * @throws Error
	 */
	private static function loadProductConfigurations(App $app) {
		$globPattern = $app->getStoragePath(self::GLOB_PATTERN_DEFINITION_FILES);
		$paths = \glob($globPattern, \GLOB_ERR);

		if ($paths === false) {
			throw new ProductConfigurationSearchError();
		}
		elseif (empty($paths)) {
			return [];
		}

		try {
			$localeCode = $app->i18n()->getLocale();
		}
		catch (NoSupportedLocaleError $e) {
			$localeCode = null;
		}

		if (empty($localeCode)) {
			$localeCode = Codes::EN_US;
		}

		$languageCode = Locale::toLanguageCode($localeCode);

		$allConfigs = [];

		foreach ($paths as $path) {
			if (!\file_exists($path) || !\is_readable($path)) {
				throw new ProductConfigurationReadError();
			}

			$json = \file_get_contents($path);

			if (empty($json)) {
				throw new InvalidProductConfigurationError();
			}

			$singleConfig = \json_decode($json, true);

			if (empty($singleConfig)) {
				throw new InvalidProductConfigurationError();
			}

			if (empty($singleConfig[Product::FIELD_TITLE]) || empty($singleConfig[Product::FIELD_COMPANY])) {
				throw new InvalidProductConfigurationError();
			}

			// flatten locale-specific values to the single value for the current locale where necessary
			foreach (\array_keys($singleConfig) as $key) {
				if (\is_array($singleConfig[$key])) {
					if (!empty($singleConfig[$key][$languageCode])) {
						$singleConfig[$key] = $singleConfig[$key][$languageCode];
					}
					elseif (!empty($singleConfig[$key][$localeCode])) {
						$singleConfig[$key] = $singleConfig[$key][$localeCode];
					}
					else {
						$singleConfig[$key] = \array_shift($singleConfig[$key]);
					}
				}
			}

			// if the current product is to be included in the public overview
			if (isset($singleConfig[Product::FIELD_LISTED]) && $singleConfig[Product::FIELD_LISTED] === true) {
				$appNameSlug = \basename($path, '.' . self::FILE_EXTENSION_DEFINITION_FILES);

				if (empty($appNameSlug) || \preg_match(self::SLUG_REGEX, $appNameSlug) !== 1) {
					throw new InvalidProductIdError();
				}

				unset($singleConfig[Product::FIELD_LISTED]);
				$allConfigs[$appNameSlug] = $singleConfig;
			}
		}

		return $allConfigs;
	}

	private function __construct() {}

}
