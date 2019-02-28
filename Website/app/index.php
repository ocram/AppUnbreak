<?php

/*
 * AppUnbreak (https://github.com/delight-im/AppUnbreak)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the GNU AGPL v3 (https://www.gnu.org/licenses/agpl-3.0.txt)
 */

$app->getTemplateManager()->addGlobal('SITE_NAME', \App\Util\ConfigurationByHostname::find($app, 'IM_DELIGHT_APPUNBREAK_SITE_NAME'));
$app->getTemplateManager()->addGlobal('SITE_SLOGAN', $_ENV['IM_DELIGHT_APPUNBREAK_SITE_SLOGAN']);
$app->getTemplateManager()->addGlobal('COMPANY_NAME', $_ENV['IM_DELIGHT_APPUNBREAK_COMPANY_NAME']);
$app->getTemplateManager()->addGlobal('COMPANY_URL', $_ENV['IM_DELIGHT_APPUNBREAK_COMPANY_URL']);
$app->getTemplateManager()->addGlobal('HTML_HEAD_FINAL', $_ENV['IM_DELIGHT_APPUNBREAK_HTML_HEAD_FINAL']);
$app->getTemplateManager()->addGlobal('HTML_BODY_FINAL', $_ENV['IM_DELIGHT_APPUNBREAK_HTML_BODY_FINAL']);

$app->get('/', '\App\IndexController::getIndex');
$app->get('/a/:product', '\App\ProductController::getProduct');
$app->get('/a/:product/:vendor', '\App\VendorController::getVendor');
$app->get('/a/:product/:vendor/:device', '\App\DeviceController::getDevice');
$app->post('/api/v1/advice/vote/:direction', '\App\AdviceApiController::postVote');
$app->get('/privacy', '\App\PrivacyController::getPrivacyPolicy');
$app->get('/contact', '\App\ContactController::getContactInformation');

// return an error for undefined pages
$app->setStatus(404);
