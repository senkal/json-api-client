<?php

namespace Art4\JsonApiClient\Tests;

use Art4\JsonApiClient\ErrorSource;
use Art4\JsonApiClient\Tests\Fixtures\JsonValueTrait;
use InvalidArgumentException;

class ErrorSourceTest extends \PHPUnit_Framework_TestCase
{
	use JsonValueTrait;

	/**
	 * @test only 'about' property' can exist
	 *
	 * source: an object containing references to the source of the error, optionally including any of the following members:
	 * - pointer: a JSON Pointer [RFC6901] to the associated entity in the request document [e.g. "/data" for a primary data object, or "/data/attributes/title" for a specific attribute].
	 * - parameter: a string indicating which query parameter caused the error.
	 */
	public function testOnlyPointerParameterPropertiesExists()
	{
		$object = new \stdClass();
		$object->pointer = '/pointer';
		$object->parameter = 'parameter';

		$source = new ErrorSource($object);

		$this->assertInstanceOf('Art4\JsonApiClient\ErrorSource', $source);

		$this->assertTrue($source->hasPointer());
		$this->assertSame($source->getPointer(), '/pointer');
		$this->assertTrue($source->hasParameter());
		$this->assertSame($source->getParameter(), 'parameter');
	}

	/**
	 * @dataProvider jsonValuesProvider
	 *
	 * pointer: a JSON Pointer [RFC6901] to the associated entity in the request document [e.g. "/data" for a primary data object, or "/data/attributes/title" for a specific attribute].
	 */
	public function testPointerMustBeAString($input)
	{
		// Input must be a string
		if ( gettype($input) === 'string' )
		{
			return;
		}

		$object = new \stdClass();
		$object->pointer = $input;

		$this->setExpectedException('InvalidArgumentException');

		$source = new ErrorSource($object);
	}

	/**
	 * @dataProvider jsonValuesProvider
	 *
	 * parameter: a string indicating which query parameter caused the error.
	 */
	public function testParameterMustBeAString($input)
	{
		// Input must be a string
		if ( gettype($input) === 'string' )
		{
			return;
		}

		$object = new \stdClass();
		$object->parameter = $input;

		$this->setExpectedException('InvalidArgumentException');

		$source = new ErrorSource($object);
	}
}