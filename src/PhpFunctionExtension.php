<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Saša Stamenković
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace Twiggy;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Twig extension that allows a subset of PHP functions to be callable directly from Twig templates.
 */
class PhpFunctionExtension extends AbstractExtension
{
	private $functions = [
		'uniqid',
		'floor',
		'ceil',
		'addslashes',
		'chr',
		'chunk_​split',
		'convert_​uudecode',
		'crc32',
		'crypt',
		'hex2bin',
		'md5',
		'sha1',
		'strpos',
		'strrpos',
		'ucwords',
		'wordwrap',
		'gettype',
	];

	public function __construct(array $functions = [])
	{
		if ($functions) {
			$this->allowFunctions($functions);
		}
	}

	public function getFunctions()
	{
		$twigFunctions = [];

		foreach ($this->functions as $function) {
			$twigFunctions[] = new TwigFunction($function, $function);
		}

		return $twigFunctions;
	}

	public function allowFunction($function)
	{
		$this->functions[] = $function;
	}

	public function allowFunctions(array $functions)
	{
		$this->functions = $functions;
	}
}
