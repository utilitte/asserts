<?php declare(strict_types = 1);

namespace Utilitte\Asserts\Mixins;

use Utilitte\Asserts\TypeAssert;

/**
 * @internal
 */
trait ArrayTypeAssertTrait
{

	public static function array(mixed $array, int|string $key): array
	{
		return TypeAssert::array(self::get($array, $key));
	}

	public static function arrayOrNull(mixed $array, int|string $key): ?array
	{
		return TypeAssert::arrayOrNull(self::get($array, $key));
	}

	public static function object(mixed $array, int|string $key): object
	{
		return TypeAssert::object(self::get($array, $key));
	}

	public static function objectOrNull(mixed $array, int|string $key): ?object
	{
		return TypeAssert::objectOrNull(self::get($array, $key));
	}

	public static function arrayOrObject(mixed $array, int|string $key): array|object
	{
		return TypeAssert::arrayOrObject(self::get($array, $key));
	}

	public static function arrayOrObjectOrNull(mixed $array, int|string $key): array|object|null
	{
		return TypeAssert::arrayOrObjectOrNull(self::get($array, $key));
	}

	public static function string(mixed $array, int|string $key): string
	{
		return TypeAssert::string(self::get($array, $key));
	}

	public static function stringOrNull(mixed $array, int|string $key): ?string
	{
		return TypeAssert::stringOrNull(self::get($array, $key));
	}

	public static function int(mixed $array, int|string $key): int
	{
		return TypeAssert::int(self::get($array, $key));
	}

	public static function intOrNull(mixed $array, int|string $key): ?int
	{
		return TypeAssert::intOrNull(self::get($array, $key));
	}

	public static function float(mixed $array, int|string $key): float
	{
		return TypeAssert::float(self::get($array, $key));
	}

	public static function floatOrNull(mixed $array, int|string $key): ?float
	{
		return TypeAssert::floatOrNull(self::get($array, $key));
	}

	public static function intOrFloat(mixed $array, int|string $key): int|float
	{
		return TypeAssert::intOrFloat(self::get($array, $key));
	}

	public static function intOrFloatOrNull(mixed $array, int|string $key): int|float|null
	{
		return TypeAssert::intOrFloatOrNull(self::get($array, $key));
	}

	public static function bool(mixed $array, int|string $key): bool
	{
		return TypeAssert::bool(self::get($array, $key));
	}

	public static function boolOrNull(mixed $array, int|string $key): ?bool
	{
		return TypeAssert::boolOrNull(self::get($array, $key));
	}

	public static function callable(mixed $array, int|string $key): callable
	{
		return TypeAssert::callable(self::get($array, $key));
	}

	public static function callableOrNull(mixed $array, int|string $key): ?callable
	{
		return TypeAssert::callableOrNull(self::get($array, $key));
	}

	public static function iterable(mixed $array, int|string $key): iterable
	{
		return TypeAssert::iterable(self::get($array, $key));
	}

	public static function iterableOrNull(mixed $array, int|string $key): ?iterable
	{
		return TypeAssert::iterableOrNull(self::get($array, $key));
	}

	public static function scalar(mixed $array, int|string $key): int|float|string|bool
	{
		return TypeAssert::scalar(self::get($array, $key));
	}

	public static function scalarOrNull(mixed $array, int|string $key): int|float|string|bool|null
	{
		return TypeAssert::scalarOrNull(self::get($array, $key));
	}

	public static function numeric(mixed $array, int|string $key): float|int
	{
		return TypeAssert::numeric(self::get($array, $key));
	}

	public static function numericInt(mixed $array, int|string $key): int
	{
		return TypeAssert::numericInt(self::get($array, $key));
	}

	public static function numericIntOrNull(mixed $array, int|string $key): ?int
	{
		return TypeAssert::numericIntOrNull(self::get($array, $key));
	}

	public static function numericFloat(mixed $array, int|string $key): float
	{
		return TypeAssert::numericFloat(self::get($array, $key));
	}

	public static function numericFloatOrNull(mixed $array, int|string $key): ?float
	{
		return TypeAssert::numericFloatOrNull(self::get($array, $key));
	}

}
