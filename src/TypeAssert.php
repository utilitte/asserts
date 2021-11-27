<?php declare(strict_types = 1);

namespace Utilitte\Asserts;

use Utilitte\Asserts\Mixins;
use Utilitte\Asserts\Traits;

final class TypeAssert
{

	use Mixins\TypeAssertTrait;
	use Traits\TypeAssertTrait;

	private static function createErrorMessage(mixed $value, string $type): string
	{
		return sprintf('Variable must be of the type %s, %s given.', $type, get_debug_type($value));
	}

}
