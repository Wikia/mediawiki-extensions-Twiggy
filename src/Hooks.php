<?php declare(strict_types=1);

/**
 * Twiggy
 * Hooks for Twiggy
 *
 * @package Twiggy
 * @author  Samuel Hilson
 * @license GPL-2.0-or-later
 */

namespace Twiggy;

use MediaWiki\MediaWikiServices;

class Hooks {
	/**
	 * Undocumented function
	 *
	 * @param MediaWikiServices $services
	 *
	 * @return void
	 */
	public static function onMediaWikiServices(MediaWikiServices $services) {
		$services->defineService('TwiggyService', function (MediaWikiServices $services) {
			return TwigFactory::getInstance($services);
		});
	}
}
