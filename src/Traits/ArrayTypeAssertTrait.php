<?php declare(strict_types = 1);

namespace Utilitte\Asserts\Traits;

use Utilitte\Asserts\TypeAssert;

trait ArrayTypeAssertTrait
{

	/**
	 * @template T of object
	 * @param mixed[] $array
	 * @param class-string<T> $type
	 * @return class-string<T>
	 */
	public static function classStringOf(array $array, string|int $key, string $type): string
	{
		return TypeAssert::classStringOf(self::get($array, $key), $type);
	}

	/**
	 * @template T of object
	 * @param mixed[] $array
	 * @param class-string<T> $type
	 * @return class-string<T>|null
	 */
	public static function classStringOfOrNull(array $array, string|int $key, string $type): ?string
	{
		return TypeAssert::classStringOfOrNull(self::get($array, $key), $type);
	}

	/**
	 * @param mixed[] $array
	 * @return class-string
	 */
	public static function classString(array $array, string|int $key): string
	{
		return TypeAssert::classString(self::get($array, $key));
	}

	/**
	 * @param mixed[] $array
	 * @return class-string|null
	 */
	public static function classStringOrNull(array $array, string|int $key): ?string
	{
		return TypeAssert::classStringOrNull(self::get($array, $key));
	}

	/**
	 * @template T of object
	 * @param mixed[] $array
	 * @param class-string<T> $type
	 * @return T
	 */
	public static function instance(array $array, string|int $key, string $type): object
	{
		return TypeAssert::instance(self::get($array, $key), $type);
	}

	/**
	 * @template T of object
	 * @param mixed[] $array
	 * @param class-string<T> $type
	 * @return T|null
	 */
	public static function instanceOrNull(array $array, string|int $key, string $type): ?object
	{
		return TypeAssert::instanceOrNull(self::get($array, $key), $type);
	}

}
