<?php declare(strict_types = 1);

namespace Utilitte\Asserts;

use Nette\Utils\Helpers;
use Utilitte\Asserts\Exceptions\OutOfBoundsException;
use Utilitte\Asserts\Mixins;
use Utilitte\Asserts\Traits;

final class ArrayTypeAssert
{

	use Mixins\ArrayTypeAssertTrait;
	use Traits\ArrayTypeAssertTrait;

	private static function createOutOfBoundsErrorMessage(mixed $array, int $position, int|string $currentKey, array $keys): string
	{
		$path = self::withPath(array_slice($keys, 0, $position));
		$isArray = is_array($array);

		return sprintf(
			'Undefined key "%s" in array%s%s%s.',
			$currentKey,
			$path,
			!$isArray ? sprintf(', because array%s is %s', $path, get_debug_type($array)) : '',
			$isArray ? self::didYouMean($array, $currentKey) : '',
		);
	}

	private static function get(array $array, string|int $key): mixed
	{
		if (is_string($key) && str_contains($key, '.')) {
			$key = explode('.', $key);
		} else {
			$key = (array) $key;
		}

		foreach ($key as $index => $k) {
			if (is_array($array) && array_key_exists($k, $array)) {
				$array = $array[$k];
			} else {
				throw new OutOfBoundsException(self::createOutOfBoundsErrorMessage($array, $index, $k, $key));
			}
		}

		return $array;
	}

	private static function didYouMean(array $array, string $key): string
	{
		$suggestion = Helpers::getSuggestion(array_filter(array_keys($array), 'is_string'), $key);
		if (!$suggestion) {
			return '';
		}

		return sprintf(', did you mean "%s"?', $suggestion);
	}

	private static function withPath(array $path): string
	{
		if (!$path) {
			return '';
		}

		return sprintf('[%s]', implode('][', $path));
	}

}
