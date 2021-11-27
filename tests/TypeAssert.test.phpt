<?php declare(strict_types = 1);

use Nette\Neon\Neon;
use Nette\Utils\Arrays;
use Nette\Utils\FileSystem;
use Nette\Utils\Type;
use Tester\Assert;
use Utilitte\Asserts\Exceptions\AssertionFailedException;
use Utilitte\Asserts\TypeAssert;

require __DIR__ . '/_bootstrap.php';

function hasType(array $array, string $type): bool
{
	return Arrays::some($array, fn (string $name) => $name === $type);
}

function type(mixed $value, bool $callable) {
	static $converts = [
		'boolean' => 'bool',
		'integer' => 'int',
		'double' => 'float',
		'string' => 'string',
		'object' => 'object',
		'array' => 'array',
		'NULL' => 'null',
		'resource' => 'resource',
		'resource (closed)' => 'resource',
	];

	if ($callable && is_callable($value)) {
		return 'callable';
	}

	return $converts[gettype($value)];
}

function testVariants(callable $callback, string $type) {
	$values = [
		'string',
		1,
		1.2,
		true,
		null,
		[],
		function (): void { },
		new stdClass(),
	];

	$type = Type::fromString($type);

	foreach ($values as $value) {
		$valueType = type($value, hasType($type->getNames(), 'callable'));
		if (!$type->allows($valueType)) {
			Assert::exception(fn () => $callback($value), AssertionFailedException::class);
		} else {
			Assert::same($value, $callback($value));
		}
	}
}

$data = Neon::decode(FileSystem::read(__DIR__ . '/../bin/methods.neon'));

foreach ($data['generate']['builtIn'] as $type) {
	$methodName = lcfirst(implode('Or', array_map('ucfirst', explode('|', $type))));

	testVariants([TypeAssert::class, $methodName], $type);
}
