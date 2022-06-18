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
	 * @return class-string<T>
	 */
	public static function classStringOf(mixed $value, string $type): string
	{
		if (!is_string($value) || !class_exists($value) || !is_a($value, $type, true)) {
			throw new AssertionFailedException(self::createErrorMessage($value, sprintf('class-string<%s>', $type)));
		}

		return $value;
	}

	/**
	 * @template T of object
	 * @param class-string<T> $type
	 * @return class-string<T>|null
	 */
	public static function classStringOfOrNull(mixed $value, string $type): ?string
	{
		if ($value !== null && (!is_string($value) || !class_exists($value) || !is_a($value, $type, true))) {
			throw new AssertionFailedException(self::createErrorMessage($value, sprintf('class-string<%s>', $type)));
		}

		return $value;
	}

	/**
	 * @return class-string
	 */
	public static function classString(mixed $value): string
	{
		if (!is_string($value) || !class_exists($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'class-string'));
		}

		return $value;
	}

	/**
	 * @return class-string|null
	 */
	public static function classStringOrNull(mixed $value): ?string
	{
		if ($value !== null && (!is_string($value) || !class_exists($value))) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'class-string|null'));
		}

		return $value;
	}

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
