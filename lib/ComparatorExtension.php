<?php

namespace dface\PhpunitCustomization;

use PHPUnit\Runner\BeforeFirstTestHook;
use SebastianBergmann\Comparator\Factory;

class ComparatorExtension implements BeforeFirstTestHook
{

	public function executeBeforeFirstTest() : void
	{
		$comparatorFactory = Factory::getInstance();
		$comparatorFactory->register(new ByEqualsMethodComparator());
		$comparatorFactory->register(new StrictScalarComparator());
	}

}
