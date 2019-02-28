<?php

/*
 * AppUnbreak (https://github.com/delight-im/AppUnbreak)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the GNU AGPL v3 (https://www.gnu.org/licenses/agpl-3.0.txt)
 */

namespace App;

use Delight\Foundation\App;

final class ContactController {

	public static function getContactInformation(App $app) {
		echo $app->view(
			'contact.html.twig',
			[
				'imageUrl' => $_ENV['IM_DELIGHT_APPUNBREAK_CONTACT_IMAGE_URL_FULL'],
				'imageWidth' => $_ENV['IM_DELIGHT_APPUNBREAK_CONTACT_IMAGE_WIDTH_FULL'],
				'imageAlt' => $_ENV['IM_DELIGHT_APPUNBREAK_CONTACT_IMAGE_ALT'],
				'audioUrl' => $_ENV['IM_DELIGHT_APPUNBREAK_CONTACT_AUDIO_URL_FULL']
			]
		);
	}

}
