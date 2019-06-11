<?php declare(strict_types = 1);
/**
 * Twig Factory
 *
 * @package Twiggy
 * @author  Samuel Hilson
 * @license GPL-2.0-or-later
 */

namespace Twiggy;

use Closure;
use Twig\Environment;
use Twig\Loader\LoaderInterface;
use Twig\TwigFunction;

class TwiggyService extends Environment {
	/**
	 * Constructor
	 *
	 * @param LoaderInterface $loader
	 * @param array           $options
	 */
	public function __construct(LoaderInterface $loader, $options = []) {
		parent::__construct($loader, $options);
		$this->addExtensionFunction('wfMessage', $this->wfMessageCallback());
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
		$this->getLoader()->addPath($directory, $namespace);
	}

	/**
	 * Extend Twig with a function
	 *
	 * @param string  $name
	 * @param Closure $function
	 *
	 * @return $this
	 */
	public function addExtensionFunction(string $name, Closure $function) {
		$this->addFunction(new TwigFunction($name, $function));
		return $this;
	}

	/**
	 * Wrap the wfMessage function
	 *
	 * @return Closure
	 */
	private function wfMessageCallback() {
		return function (string $msg, string $output, ...$params) {
			$allowedOutput = ['plain', 'text', 'escaped', 'parse', 'parseAsBlock'];
			// Unsupported output modes are reported and defaulted to escaped.
			if (!in_array($output, $allowedOutput)) {
				wfLogWarning($output . " is not a supported output mode for wfMessage");
				$output = 'escaped';
			}
			return wfMessage($msg, ...$params)->{$output}();
		};
	}
}
