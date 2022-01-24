<?php declare(strict_types = 1);

namespace Utilitte\Asserts\Helper;

final class TypeHelper
{

	public static function tryToNumeric(mixed $value): mixed
	{
		if (is_numeric($value)) {
			$value = trim($value);
		}

		return $value;
	}

	public static function tryToFloat(mixed $value): mixed
	{
		if (is_numeric($value)) {
			return (float) $value;
		}

		return $value;
	}

	public static function tryToInt(mixed $value): mixed
	{
		if (is_numeric($value)) {
			return (int) $value;
		}

		return $value;
	}

	public static function tryToNumber(mixed $value): mixed
	{
		if (is_string($value) && is_numeric($value)) {
			$value = preg_replace('#\\.0*$#D', '', $value);

			return str_contains($value, '.') ? (float) $value : (int) $value;
		}

		return $value;
	}

}
