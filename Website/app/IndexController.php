<?php

/*
 * AppUnbreak (https://github.com/delight-im/AppUnbreak)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the GNU AGPL v3 (https://www.gnu.org/licenses/agpl-3.0.txt)
 */

namespace App;

use Delight\Foundation\App;

final class IndexController {

	public static function getIndex(App $app) {
		$app->redirect('/a/example');
		exit;
	}

	private function __construct() {}

}
