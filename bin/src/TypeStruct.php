<?php declare(strict_types = 1);

namespace Generator;

final class TypeStruct
{

	private const SUBS = [
		'is_null' => '$value !== null',
	];

	/**
	 * @param string[] $asserts
	 * @param string[] $returns
	 * @param mixed[] $arguments
	 */
	public function __construct(
		public ?string $prolog,
		public ?string $epilog,
		public array $asserts,
		public array $returns,
		public array $arguments,
	)
	{
	}

	public static function combine(TypeStruct ... $structs): self
	{
		$prolog = '';
		$epilog = '';
		$asserts = [];
		$returns = [];
		$arguments = [];
		foreach ($structs as $struct) {
			$prolog .= $struct->prolog;
			if ($prolog) {
				$prolog .= "\n";
			}

			$epilog .= $struct->epilog;
			if ($epilog) {
				$epilog .= "\n";
			}

			$asserts = array_merge($asserts, $struct->asserts);
			$returns = array_merge($returns, $struct->returns);
			$arguments = array_merge($arguments, $struct->arguments);
		}

		$prolog = trim($prolog);
		$epilog = trim($epilog);

		return new self($prolog ?: null, $epilog ?: null, array_unique($asserts), array_unique($returns), $arguments);
	}

	public function getAssertion(): string
	{
		$asserts = [];
		foreach ($this->asserts as $assert) {
			if (isset(self::SUBS[$assert])) {
				$asserts[] = self::SUBS[$assert];

				continue;
			}
			if (!str_contains($assert, '$')) {
				$assert = $assert . '($value)';
			}

			$asserts[] = '!' . $assert;
		}

		return implode(' && ', $asserts);
	}

}
