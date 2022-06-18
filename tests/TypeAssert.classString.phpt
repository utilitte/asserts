<?php

use Tester\Assert;
use Utilitte\Asserts\Exceptions\AssertionFailedException;
use Utilitte\Asserts\TypeAssert;

require __DIR__ . '/_bootstrap.php';

class A {}

class B extends A {}

TypeAssert::classString(A::class);
TypeAssert::classStringOrNull(null);

Assert::exception(fn () => TypeAssert::classString('foo'), AssertionFailedException::class);

TypeAssert::classStringOf(A::class, A::class);
TypeAssert::classStringOfOrNull(null, A::class);

Assert::exception(fn () => TypeAssert::classStringOf(A::class, B::class), AssertionFailedException::class);
