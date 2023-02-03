<?php
/**
 * Twig Factory
 *
 * @package Twiggy
 * @author  Samuel Hilson
 * @license GPL-2.0-or-later
 */

declare( strict_types=1 );

namespace Twiggy;

use Twig\Environment;
use Twig\Loader\LoaderInterface;

class TwiggyService extends Environment {
	public function __construct(
		LoaderInterface $loader,
		array $allowedPhpFunctions,
		array $blacklistedPhpFunctions
	) {
		parent::__construct( $loader );

		$functionList = array_filter(
			array_unique( $allowedPhpFunctions ),
			fn ( $func ): bool => !in_array( $func, $blacklistedPhpFunctions )
		);

		$this->addExtension( new PhpFunctionExtension( $functionList ) );
	}

	/**
	 * Add a Template Location
	 */
	public function setTemplateLocation( string $namespace, string $directory ): void {
		$this->getLoader()->addPath( $directory, $namespace );
	}
}
