<?php

/*
 * AppUnbreak (https://github.com/delight-im/AppUnbreak)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the GNU AGPL v3 (https://www.gnu.org/licenses/agpl-3.0.txt)
 */

namespace App;

use Delight\Foundation\App;
use Delight\PrivacyPolicy\Data\DataBasis;
use Delight\PrivacyPolicy\Data\DataGroup;
use Delight\PrivacyPolicy\Data\DataPurpose;
use Delight\PrivacyPolicy\Data\DataRequirement;
use Delight\PrivacyPolicy\Data\DataType;
use Delight\PrivacyPolicy\Language\EnglishPrivacyPolicy;

final class PrivacyController {

	public static function getPrivacyPolicy(App $app) {
		$policy = new EnglishPrivacyPolicy();

		$policy->setPublishedAt(1550621567);
		$policy->setCanonicalUrl($app->url('/privacy'));
		$policy->setContactImage(
			$_ENV['IM_DELIGHT_APPUNBREAK_CONTACT_IMAGE_URL_MINIMAL'],
			$_ENV['IM_DELIGHT_APPUNBREAK_CONTACT_IMAGE_ALT'],
			$_ENV['IM_DELIGHT_APPUNBREAK_CONTACT_IMAGE_WIDTH_MINIMAL']
		);
		$policy->setContactUrl($_ENV['IM_DELIGHT_APPUNBREAK_CONTACT_AUDIO_URL_MINIMAL']);

		$policy->setUserDataTraded(false);
		$policy->setDataMinimizationGoal(true);
		$policy->setChildrenMinimumAge(16);
		$policy->setPromotionalEmailOptOut(false);
		$policy->setFirstPartyCookies(true);
		$policy->setThirdPartyCookies(false);
		$policy->setAccountDeletable(false);
		$policy->setPreservationInBackups(true);
		$policy->setThirdPartyServiceProviders(true);
		$policy->setInternationalTransfers(true);
		$policy->setTransferUponMergerOrAcquisition(true);
		$policy->setTlsEverywhere(true);
		$policy->setCompetentSupervisoryAuthority(
			$_ENV['IM_DELIGHT_APPUNBREAK_DATA_PROTECTION_SUPERVISORY_AUTHORITY_NAME'],
			$_ENV['IM_DELIGHT_APPUNBREAK_DATA_PROTECTION_SUPERVISORY_AUTHORITY_URL']
		);
		$policy->setNotificationPeriod(30);
		$policy->setRightOfAccess(true);
		$policy->setRightToRectification(true);
		$policy->setRightToErasure(true);
		$policy->setRightToRestrictProcessing(true);
		$policy->setRightToDataPortability(true);
		$policy->setRightToObject(true);
		$policy->setRightsRelatedToAutomatedDecisions(true);

		$policy->addDataGroup(
			'Server logs',
			'Whenever you access our services, including your access of any individual part or section of our services, we record certain information about the nature of your access. That information is never combined with information from other data sources and will not be associated with the identity of any account. However, we reserve the right to review the data retrospectively if there is specific evidence supporting the suspicion of a case of fraud or any other illegal activity or illegal use of our services.',
			[ DataBasis::LEGITIMATE_INTERESTS ],
			null,
			[ DataPurpose::ADMINISTRATION ],
			DataRequirement::ALWAYS,

			function (DataGroup $group) {
				$retentionTimeHours = 24 * 14;

				$group->addElement(
					DataType::ACCESS_HTTP_METHOD,
					DataRequirement::ALWAYS,
					$retentionTimeHours
				);

				$group->addElement(
					DataType::ACCESS_HTTP_STATUS,
					DataRequirement::ALWAYS,
					$retentionTimeHours
				);

				$group->addElement(
					DataType::ACCESS_IP_ADDRESS,
					DataRequirement::ALWAYS,
					$retentionTimeHours
				);

				$group->addElement(
					DataType::ACCESS_REFERER,
					DataRequirement::ALWAYS,
					$retentionTimeHours
				);

				$group->addElement(
					DataType::ACCESS_SIZE,
					DataRequirement::ALWAYS,
					$retentionTimeHours
				);

				$group->addElement(
					DataType::ACCESS_DATETIME,
					DataRequirement::ALWAYS,
					$retentionTimeHours
				);

				$group->addElement(
					DataType::ACCESS_URL,
					DataRequirement::ALWAYS,
					$retentionTimeHours
				);

				$group->addElement(
					DataType::ACCESS_USERAGENT_STRING,
					DataRequirement::ALWAYS,
					$retentionTimeHours
				);
			}
		);

		echo $app->view(
			'privacy.html.twig',
			[
				'html' => $policy->toHtml()
			]
		);
	}

}
