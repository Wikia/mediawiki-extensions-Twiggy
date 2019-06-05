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
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwiggyService extends Environment {
	/**
	 * Container for FilesystemLoader
	 *
	 * @var FilesystemLoader
	 */
	private $loader;

	/**
	 * Configure Twig
	 *
	 * @param MediaWikiServices $services
	 */
	public function __construct(MediaWikiServices $services) {
		$mainConfig = $services->getMainConfig();
		$cacheDirectory = $mainConfig->get('CacheDirectory');
		$extensionDirectory = $mainConfig->get('ExtensionDirectory');
		$this->loader = new FilesystemLoader($extensionDirectory);
		parent::__construct($this->loader, [
			'cache' => $cacheDirectory
		]);
	}

	/**
	 * Add a Template Location
	 *
	 * @param string $namespace
	 * @param string $directory
	 *
	 * @return void
	 */
	public function setTemplateLocation(string $namespace, string $directory): void {
		$this->loader->addPath($directory, $namespace);
	}
}
