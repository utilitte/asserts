<?php declare(strict_types = 1);

use Tester\Assert;
use Utilitte\Asserts\ArrayTypeAssert;
use Utilitte\Asserts\TypeAssert;

require __DIR__ . '/_bootstrap.php';

$array = [
	['john', 'doe', 'nested' => 'nested'],
	'foo' => ['bar' => 'bar'],
	'first' => [
		'second' => [
			'third' => [],
		],
	],
];

Assert::same('bar', ArrayTypeAssert::string($array, 'foo.bar'));

Assert::exception(fn () => ArrayTypeAssert::string($array, 'fo'), \Utilitte\Asserts\Exceptions\OutOfBoundsException::class);

Assert::same('bar', ArrayTypeAssert::string([
	'foo' => ['bar' => 'bar'],
], 'foo.bar'));

Assert::exception(fn () => ArrayTypeAssert::string($array, 'foo.ba'), \Utilitte\Asserts\Exceptions\OutOfBoundsException::class);
Assert::exception(fn () => ArrayTypeAssert::string($array, '0.nested.xxx'), \Utilitte\Asserts\Exceptions\OutOfBoundsException::class);


Assert::same('nested', ArrayTypeAssert::string($array, '0.nested'));
