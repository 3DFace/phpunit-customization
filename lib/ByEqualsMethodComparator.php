<?php

namespace dface\PhpunitCustomization;

use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\ComparisonFailure;

class ByEqualsMethodComparator extends Comparator
{

	public function accepts($expected, $actual) : bool
	{
		return \is_object($expected) && \method_exists($expected, 'equals');
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
	 * @throws \JsonException
	 */
	public function assertEquals($expected, $actual, $delta = 0.0, $canonicalize = false, $ignoreCase = false) : void
	{
		if (!$expected->equals($actual)) {
			if ($expected instanceof \JsonSerializable && $actual instanceof \JsonSerializable) {
				$expected_arr = $expected->jsonSerialize();
				$actual_arr = $actual->jsonSerialize();

				if(\is_array($expected_arr) && \is_array($actual_arr)) {
					$expected_str = \json_encode($this->diff($expected_arr, $actual_arr), JSON_THROW_ON_ERROR);
					$actual_str = \json_encode($this->diff($actual_arr, $expected_arr), JSON_THROW_ON_ERROR);
				}else{
					$expected_str = $this->exporter->export($expected);
					$actual_str = $this->exporter->export($actual);
				}
			} else {
				$expected_str = $this->exporter->export($expected);
				$actual_str = $this->exporter->export($actual);
			}

			throw new ComparisonFailure(
				$expected,
				$actual,
				$this->exporter->export($expected),
				$this->exporter->export($actual),
				false,
				\sprintf(
					'Failed asserting that %s matches expected %s.',
					$actual_str,
					$expected_str
				)
			);
		}
	}

	private function diff($x1, $x2) : array
	{
		$result = [];
		foreach ($x1 as $k => $v1) {
			if (!\is_array($x2) || !\array_key_exists($k, $x2)) {
				$result[$k] = $v1;
			} else {
				$v2 = $x2[$k];
				if (\is_array($v1)) {
					if ($this->diff($v1, $v2)) {
						$result[$k] = $v1;
					}
				} /** @noinspection TypeUnsafeComparisonInspection */
				elseif ($v1 != $v2) {
					$result[$k] = $v1;
				}
			}
		}
		return $result;
	}

}
