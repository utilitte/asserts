<?php declare(strict_types = 1);

namespace Utilitte\Asserts\Mixins;

use Utilitte\Asserts\Exceptions\AssertionFailedException;
use Utilitte\Asserts\Helper\TypeHelper;

/**
 * @internal
 */
trait TypeAssertTrait
{

	public static function array(mixed $value): array
	{
		if (!is_array($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'array'));
		}

		return $value;
	}

	public static function arrayOrNull(mixed $value): ?array
	{
		if (!is_array($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'array|null'));
		}

		return $value;
	}

	public static function object(mixed $value): object
	{
		if (!is_object($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'object'));
		}

		return $value;
	}

	public static function objectOrNull(mixed $value): ?object
	{
		if (!is_object($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'object|null'));
		}

		return $value;
	}

	public static function arrayOrObject(mixed $value): array|object
	{
		if (!is_array($value) && !is_object($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'array|object'));
		}

		return $value;
	}

	public static function arrayOrObjectOrNull(mixed $value): array|object|null
	{
		if (!is_array($value) && !is_object($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'array|object|null'));
		}

		return $value;
	}

	public static function string(mixed $value): string
	{
		if (!is_string($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'string'));
		}

		return $value;
	}

	public static function stringOrNull(mixed $value): ?string
	{
		if (!is_string($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'string|null'));
		}

		return $value;
	}

	public static function int(mixed $value): int
	{
		if (!is_int($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'int'));
		}

		return $value;
	}

	public static function intOrNull(mixed $value): ?int
	{
		if (!is_int($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'int|null'));
		}

		return $value;
	}

	public static function float(mixed $value): float
	{
		if (!is_float($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'float'));
		}

		return $value;
	}

	public static function floatOrNull(mixed $value): ?float
	{
		if (!is_float($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'float|null'));
		}

		return $value;
	}

	public static function intOrFloat(mixed $value): int|float
	{
		if (!is_int($value) && !is_float($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'int|float'));
		}

		return $value;
	}

	public static function intOrFloatOrNull(mixed $value): int|float|null
	{
		if (!is_int($value) && !is_float($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'int|float|null'));
		}

		return $value;
	}

	public static function bool(mixed $value): bool
	{
		if (!is_bool($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'bool'));
		}

		return $value;
	}

	public static function boolOrNull(mixed $value): ?bool
	{
		if (!is_bool($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'bool|null'));
		}

		return $value;
	}

	public static function callable(mixed $value): callable
	{
		if (!is_callable($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'callable'));
		}

		return $value;
	}

	public static function callableOrNull(mixed $value): ?callable
	{
		if (!is_callable($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'callable|null'));
		}

		return $value;
	}

	public static function iterable(mixed $value): iterable
	{
		if (!is_iterable($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'iterable'));
		}

		return $value;
	}

	public static function iterableOrNull(mixed $value): ?iterable
	{
		if (!is_iterable($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'iterable|null'));
		}

		return $value;
	}

	public static function scalar(mixed $value): int|float|string|bool
	{
		if (!is_scalar($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'scalar'));
		}

		return $value;
	}

	public static function scalarOrNull(mixed $value): int|float|string|bool|null
	{
		if (!is_scalar($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'scalar|null'));
		}

		return $value;
	}

	public static function numeric(mixed $value): float|int|string
	{
		$value = TypeHelper::tryToNumeric($value);

		if (!is_int($value) && !is_float($value) && !is_numeric($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'numeric'));
		}

		return $value;
	}

	public static function numericOrNull(mixed $value): float|int|string|null
	{
		$value = TypeHelper::tryToNumeric($value);

		if (!is_int($value) && !is_float($value) && !is_numeric($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'numeric|null'));
		}

		return $value;
	}

	public static function integerish(mixed $value): int
	{
		$value = TypeHelper::tryToInt($value);

		if (!is_int($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'integerish'));
		}

		return $value;
	}

	public static function integerishOrNull(mixed $value): ?int
	{
		$value = TypeHelper::tryToInt($value);

		if (!is_int($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'integerish|null'));
		}

		return $value;
	}

	public static function floatish(mixed $value): float
	{
		$value = TypeHelper::tryToFloat($value);

		if (!is_float($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'floatish'));
		}

		return $value;
	}

	public static function floatishOrNull(mixed $value): ?float
	{
		$value = TypeHelper::tryToFloat($value);

		if (!is_float($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'floatish|null'));
		}

		return $value;
	}

	public static function number(mixed $value): float|int
	{
		$value = TypeHelper::tryToNumber($value);

		if (!is_int($value) && !is_float($value)) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'number'));
		}

		return $value;
	}

	public static function numberOrNull(mixed $value): float|int|null
	{
		$value = TypeHelper::tryToNumber($value);

		if (!is_int($value) && !is_float($value) && $value !== null) {
			throw new AssertionFailedException(self::createErrorMessage($value, 'number|null'));
		}

		return $value;
	}

}
