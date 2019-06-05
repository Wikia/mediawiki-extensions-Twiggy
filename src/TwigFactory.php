<?php declare(strict_types = 1);
/**
 * Twig Factory
 *
 * @package Twiggy
 * @author  Samuel Hilson
 * @license GPL-2.0-or-later
 */

namespace Twiggy;

use MediaWiki\MediaWikiServices;

class TwigFactory {
	/**
	 * Container for Twig
	 *
	 * @var TwiggyService
	 */
	private static $twiggy = null;

	/**
	 * Get the twig service
	 *
	 * @param MediaWikiServices $services
	 *
	 * @return TwiggyService
	 */
	public static function getInstance(MediaWikiServices $services): TwiggyService {
		if (self::$twiggy == null) {
			self::$twiggy = new TwiggyService($services);
		}

		return self::$twiggy;
	}
}
