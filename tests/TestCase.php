<?php
/**
 * Test Base
 *
 * @package Tests
 * @author  Samuel Hilson
 * @license GPL-2.0-or-later
 */

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
	/**
	 * Setup the test case.
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();
	}

	/**
	 * Tear down the test case.
	 *
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();
	}
}
