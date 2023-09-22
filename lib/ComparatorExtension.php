<?php

namespace dface\PhpunitCustomization;

use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;
use SebastianBergmann\Comparator\Factory;

class ComparatorExtension implements Extension
{

	public function bootstrap(Configuration $configuration, Facade $facade, ParameterCollection $parameters) : void
	{
		$comparatorFactory = Factory::getInstance();
		$comparatorFactory->register(new ByEqualsMethodComparator());
		$comparatorFactory->register(new StrictScalarComparator());
	}

}
