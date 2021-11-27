<?php declare(strict_types = 1);

namespace Utilitte\Asserts\Traits;

use Utilitte\Asserts\TypeAssert;

trait ArrayTypeAssertTrait
{

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
