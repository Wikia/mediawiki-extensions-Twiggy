<?php

use MediaWiki\MediaWikiServices;
use Twig\Loader\FilesystemLoader;
use Twiggy\TwiggyService;

return [
	'TwiggyService' => static function ( MediaWikiServices $services ): TwiggyService {
		$config = $services->getMainConfig();
		return new TwiggyService(
			new FilesystemLoader( $config->get( 'ExtensionDirectory' ) ),
			$config->get( 'TwiggyAllowedPHPFunctions' ),
			$config->get( 'TwiggyBlacklistedPHPFunctions' )
		);
	},
];
