<?php declare(strict_types = 1);

use Nette\Neon\Neon;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;
use Nette\Schema\Expect;
use Nette\Schema\Processor;
use Nette\Utils\FileSystem;
use Nette\Utils\Strings;
use Nette\Utils\Type;
use Utilitte\Asserts\Exceptions\AssertionFailedException;
use Utilitte\Asserts\TypeAssert;

require __DIR__ . '/vendor/autoload.php';

class DefaultPrinter extends Printer
{

	public function __construct()
	{
		parent::__construct();

		$this->linesBetweenMethods = 1;
		$this->linesBetweenProperties = 1;
	}

	public function printFile(PhpFile $file): string
	{
		$namespaces = [];
		foreach ($file->getNamespaces() as $namespace) {
			$namespaces[] = $this->printNamespace($namespace);
		}

		return Strings::normalize(
				"<?php"
				. ($file->hasStrictTypes() ? " declare(strict_types = 1);\n" : '')
				. ($file->getComment() ? "\n" . Helpers::formatDocComment($file->getComment() . "\n") : '')
				. "\n"
				. implode("\n\n", $namespaces)
			) . "\n";
	}

	public function printClass(ClassType $class, PhpNamespace $namespace = null): string
	{
		$lines = explode("\n", parent::printClass($class, $namespace));
		foreach ($lines as $i => $line) {
			if (preg_match('#^\s*(final|abstract)?\s*(class|interface|trait)#', $line)) {
				array_splice($lines, $i + 2, 0, '');

				break;
			}
		}

		array_splice($lines, -2, 0, '');

		return implode("\n", $lines);
	}

}

class TypeAssertionGenerator
{

	public function __construct(
		private string $arrayTypeAssertTraitName,
		private string $typeAssertTraitName,
		private string $typeAssertClassName,
		private string $typeAssertionException,
		private array $types,
	)
	{
	}

	public function runArray(array $types): string
	{
		$file = new PhpFile();
		$file->setStrictTypes();
		$namespace = $file->addNamespace(Helpers::extractNamespace($this->arrayTypeAssertTraitName));
		$namespace->addUse($this->typeAssertClassName);
		$class = $namespace->addTrait(Helpers::extractShortName($this->arrayTypeAssertTraitName));
		$class->addComment('@internal');

		foreach ($types as $type) {
			$type = Type::fromString($type);

			if ($type->isIntersection()) {
				throw new LogicException('Intersection is not supported.');
			}

			$this->generateArray($type, $class, $namespace);
		}

		return (new DefaultPrinter())->printFile($file);
	}

	public function run(array $types): string
	{
		$file = new PhpFile();
		$file->setStrictTypes();
		$namespace = $file->addNamespace(Helpers::extractNamespace($this->typeAssertTraitName));
		$namespace->addUse($this->typeAssertionException);
		$class = $namespace->addTrait(Helpers::extractShortName($this->typeAssertTraitName));
		$class->addComment('@internal');

		foreach ($types as $type) {
			$type = Type::fromString($type);

			if ($type->isIntersection()) {
				throw new LogicException('Intersection is not supported.');
			}

			$this->generate($type, $class, $namespace);
		}

		return (new DefaultPrinter())->printFile($file);
	}

	private function generateArray(Type $type, ClassType $class, PhpNamespace $namespace): void
	{
		$method = $class->addMethod($methodName = $this->generateName($type));
		$method->addParameter('array')
			->setType('mixed');
		$method->addParameter('key')
			->setType('int|string');
		$method->setReturnType($this->returnType($type))
			->setStatic();

		$method->addBody(sprintf('return %s::%s(self::get($array, $key));', $namespace->simplifyType($this->typeAssertClassName), $methodName));
	}

	private function generate(Type $type, ClassType $class, PhpNamespace $namespace): void
	{
		$method = $class->addMethod($this->generateName($type));
		$method->addParameter('value')
			->setType('mixed');
		$method->setReturnType($this->returnType($type))
			->setStatic();

		$expandedType = $this->typeToStringExpanded($type);

		$assertions = [];
		$epilogs = [];
		$prologs = [];
		foreach ($type->getTypes() as $singleType) {
			$struct = $this->types[$singleType->getSingleName()];
			$assertions = array_merge($assertions, $struct->assertions);
			if ($struct->prolog) {
				$prologs[] = $struct->prolog;
			}
			if ($struct->epilog) {
				$epilogs[] = $struct->epilogs;
			}
		}

		if ($prologs) {
			$method->addBody(implode("\n", $prologs));
			$method->addBody('');
		}

		$method->addBody(
			sprintf('if (%s) {', $this->generateCondition($assertions))
		);
		$method->addBody(
			sprintf(
				"\tthrow new %s(self::createErrorMessage(\$value, ?));",
				$namespace->simplifyName($this->typeAssertionException)
			),
			[$expandedType]
		);
		$method->addBody('}');

		if ($epilogs) {
			$method->addBody('');
			$method->addBody(implode("\n", $epilogs));
		}

		$method->addBody('');
		$method->addBody('return $value;');
	}

	private function typeToStringExpanded(Type $type): string
	{
		$types = [];
		foreach ($type->getTypes() as $type) {
			$types[] = $type->getSingleName();
		}

		return implode('|', $types);
	}

	private function generateName(Type $type): string
	{
		$methodName = '';
		foreach ($type->getNames() as $name) {
			$methodName .= ucfirst($name) . 'Or';
		}

		return lcfirst(substr($methodName, 0, -2));
	}

	private function generateCondition(array $validators): string
	{
		return implode(' && ', $validators);
	}

	private function returnType(Type $type): string
	{
		$returnType = '';
		foreach ($type->getTypes() as $type) {
			if ($type->isBuiltin()) {
				$returnType .= $type->getSingleName() . '|';
			} else {
				$struct = $this->types[$type->getSingleName()] ?? throw new LogicException(
					sprintf('Return type for type "%s" does not exist.', $type->getSingleName())
				);

				foreach ($struct->returns as $item) {
					$returnType .= $item . '|';
				}
			}
		}

		return (string) Type::fromString(substr($returnType, 0, -1));
	}

}

$data = (new Processor())->process(Expect::structure([
	'types' => Expect::arrayOf(Expect::structure([
		'assertions' => Expect::anyOf(Expect::string(), Expect::arrayOf('string'))->castTo('array')->default([]),
		'returns' => Expect::anyOf(Expect::string(), Expect::arrayOf('string'))->castTo('array')->default([]),
		'prolog' => Expect::string()->default(null),
		'epilog' => Expect::string()->default(null),
	])),
	'generate' => Expect::structure([
		'builtIn' => Expect::arrayOf(Expect::string()),
		'special' => Expect::arrayOf(Expect::string()),
	]),
]), Neon::decode(FileSystem::read(__DIR__ . '/methods.neon')));

$generator = new TypeAssertionGenerator(
	'Utilitte\Asserts\Mixins\ArrayTypeAssertTrait',
	'Utilitte\Asserts\Mixins\TypeAssertTrait',
	TypeAssert::class,
	AssertionFailedException::class,
	$data->types,
);

$generate = array_merge($data->generate->builtIn, $data->generate->special);
FileSystem::write(__DIR__ . '/../src/Mixins/TypeAssertTrait.php', $generator->run($generate));
FileSystem::write(__DIR__ . '/../src/Mixins/ArrayTypeAssertTrait.php', $generator->runArray($generate));
