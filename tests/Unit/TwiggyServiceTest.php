<?php
/**
 * Example Test
 *
 * @package Tests\Unit
 * @author  Samuel Hilson
 * @license GPL-2.0-or-later
 */

namespace Twiggy\tests;

use PHPUnit\Framework\TestCase;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twiggy\TwiggyService;

class TwiggyServiceTest extends TestCase {
	private string $tempDir;
	private TwiggyService $sut;

	protected function setUp(): void {
		parent::setUp();
		$this->tempDir = sys_get_temp_dir() . '/mw-phpunit-twiggy-' . random_int( 0, 999 );
		mkdir( $this->tempDir );

		$this->sut = new TwiggyService(
			new FilesystemLoader( $this->tempDir ),
			[ 'strtoupper' ],
			[ 'shell_exec' ]
		);
	}

	protected function tearDown(): void {
		parent::tearDown();
		if ( is_dir( $this->tempDir ) ) {
			rmdir( $this->tempDir );
		}
	}

	/**
	 * Test that template location is added correctly
	 *
	 * @covers TwiggyService::setTemplateLocation
	 *
	 * @return void
	 */
	public function testCanAddTemplateLocation(): void {
		$this->sut->setTemplateLocation( 'test', $this->tempDir );
		$loader = $this->sut->getLoader();
		$namespaces = $loader->getNamespaces();
		$paths = $loader->getPaths( 'test' );
		$this->assertArrayHasKey( 'test', array_flip( $namespaces ) );
		$this->assertArrayHasKey( $this->tempDir, array_flip( $paths ) );
	}

	public function testRenderTemplateWithAllowedFunctions(): void {
		$this->sut->setTemplateLocation( 'TestFixtures', __DIR__ . '/fixtures' );

		$output = $this->sut->render( '@TestFixtures/function_test.twig', [ 'arg' => 'test' ] );

		$this->assertSame( "<div class=\"twig-test\">TEST</div>\n", $output );
	}

	public function testDisallowBlockedFunctions(): void {
		$this->sut->setTemplateLocation( 'TestFixtures', __DIR__ . '/fixtures' );
		$this->expectException( SyntaxError::class );
		$this->expectExceptionMessage( 'Unknown "shell_exec" function.' );

		$this->sut->render( '@TestFixtures/dangerous.twig', [ 'arg' => 'sudo apt-get install malware' ] );
	}
}
