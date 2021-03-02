<?php

namespace dface\PhpunitCustomization;

use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\ComparisonFailure;

class StrictScalarComparator extends Comparator
{

	public function accepts($expected, $actual) : bool
	{
		return (\is_scalar($expected) || $expected === null) && (\is_scalar($actual) || $actual === null);
	}

	/**
	 * Asserts that two values are equal.
	 *
	 * @param mixed $expected First value to compare
	 * @param mixed $actual Second value to compare
	 * @param float $delta Allowed numerical distance between two values to consider them equal
	 * @param bool $canonicalize Arrays are sorted before comparison when set to true
	 * @param bool $ignoreCase Case is ignored when set to true
	 *
	 * @throws ComparisonFailure
	 */
	public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false) : void
	{
		if ($expected === $actual) {
			return;
		}

		if ($ignoreCase && \is_string($expected) && \is_string($actual) && (\strtolower($expected) === \strtolower($actual))) {
			return;
		}

		$str_expected = $this->exporter->export($expected);
		$str_actual = $this->exporter->export($actual);

		throw new ComparisonFailure(
			$expected,
			$actual,
			$str_expected,
			$str_actual,
			false,
			"Failed asserting that $str_actual matches expected $str_expected"
		);
	}
}
