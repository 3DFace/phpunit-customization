<?php

namespace dface\PhpunitCustomization;

use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Exporter\Exporter;

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
	public function assertEquals($expected, $actual, float $delta = 0.0, bool $canonicalize = false, bool $ignoreCase = false) : void
	{
		if ($expected === $actual) {
			return;
		}

		if ($ignoreCase && \is_string($expected) && \is_string($actual) && (\strtolower($expected) === \strtolower($actual))) {
			return;
		}

		$exporter = new Exporter;
		$str_expected = $exporter->export($expected);
		$str_actual = $exporter->export($actual);

		throw new ComparisonFailure(
			$expected,
			$actual,
			$str_expected,
			$str_actual,
			"Failed asserting that $str_actual matches expected $str_expected"
		);
	}
}
