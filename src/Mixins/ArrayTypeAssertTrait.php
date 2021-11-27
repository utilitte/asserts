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
