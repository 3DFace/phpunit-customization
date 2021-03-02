<?php

namespace dface\PhpunitCustomization;

trait TearDownCleaner
{

	protected function cleanUpPropertiesOnTearDown() : void
	{
		$ref = new \ReflectionObject($this);
		foreach ($ref->getProperties() as $prop) {
			if(!$prop->isStatic()) {
				$type = $prop->getType();
				$nullable = $type === null || $type->allowsNull();
				if ($nullable && $prop->getDeclaringClass()->isSubclassOf(self::class)) {
					$prop->setAccessible(true);
					/** @noinspection PhpRedundantOptionalArgumentInspection */
					$prop->setValue($this, null);
				}
			}
		}
	}

}
