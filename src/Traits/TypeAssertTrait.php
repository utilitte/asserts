<?php declare(strict_types = 1);

namespace Utilitte\Asserts\Traits;

use LogicException;
use Nette\Utils\Type;
use Utilitte\Asserts\Exceptions\AssertionFailedException;

trait TypeAssertTrait
{

	/**
	 * @template T of object
	 * @param class-string<T> $type
	 * @return T
	 */
	public static function instance(mixed $value, string $type): object
	{
		self::checkInstanceStruct($typeStruct = Type::fromString($type));

		if (is_object($value)) {
			foreach ($typeStruct->getNames() as $singleType) {
				if ($value instanceof $singleType) {
					return $value;
				}
			}
		}

		throw new AssertionFailedException(self::createErrorMessage($value, $type));
	}

	/**
	 * @template T of object
	 * @param class-string<T> $type
	 * @return T|null
	 */
	public static function instanceOrNull(mixed $value, string $type): ?object
	{
		self::checkInstanceStruct($typeStruct = Type::fromString($type));

		if ($value === null) {
			return null;
		}

		if (is_object($value)) {
			foreach ($typeStruct->getNames() as $singleType) {
				if ($value instanceof $singleType) {
					return $value;
				}
			}
		}

		throw new AssertionFailedException(self::createErrorMessage($value, $type));
	}

	private static function checkInstanceStruct(Type $type): void
	{
		if ($type->isIntersection()) {
			throw new LogicException('Intersection type in instance is not supported.');
		}

		foreach ($type->getTypes() as $singleType) {
			if ($singleType->isBuiltin()) {
				throw new LogicException(sprintf('Invalid type "%s" in instance.', $singleType->getSingleName()));
			}
		}
	}

}
