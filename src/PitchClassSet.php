<?php
class PitchClassSet {
	
	private $_elements = [];
	private $_sortedElements = [];
	private $_invertedElements = [];
	
	public function __construct(array $set) {
		if (empty($set)) {
			throw Exception('Please provide integer elements');
		}

		$this->addElements($set);
	}
		
	protected function addElements($set) {
		foreach ($set as $element) {
			if (is_int($element)) {
				$this->_elements[] = $element % 12;
			}
		}
	}
	
	public function getElements() {
		return $this->_elements;
	}
	
	public function getSortedElements() {
		if (empty($this->_sortedElements)) {
			$elements = $this->getElements();
			sort($elements);
			$this->_sortedElements = $elements;
		}		
		return $this->_sortedElements;
	}
	
	public function getPermutations($set) {
		$permutations = [];
		$permutations[] = $set;
		for ($i = 1; $i < count($set); $i++) {
			$permutations[] = array_merge(array_slice($permutations[$i - 1], 1, count($set) - 1), array_slice($permutations[$i - 1], 0, 1));
		}
		return $permutations;
	}
	
	protected function modifySet($set, $amount, $range) {
		for ($i = $range[0]; $i <= $range[1]; $i++) {
			$set[$i] = $set[$i] + $amount;
		}
		return $set;
	}
	
	protected function getAdjustedPermutations($permutations, $amount) {
		$adjustedPermutations = [];
		$adjustedPermutations[] = $permutations[0];
		for ($i = 1; $i < count($permutations); $i++) {
			$adjustedPermutations[] = $this->modifySet($permutations[$i], 12, [count($permutations) - $i, count($permutations) - 1]);
		}
		return $adjustedPermutations;
	}
	
	public function getBestNormalOrder($set) {
		$minDistanceIndex = 0;
		$minDistance = 11;
		$permutations = $this->getPermutations($set);
		$adjustedPermutations = $this->getAdjustedPermutations($permutations, 12);
		foreach ($adjustedPermutations as $index => $adjustedPermutation) {
			/*$closest = $this->closest($adjustedPermutations[$index], $adjustedPermutations[$minDistanceIndex]);
			if ($closest == $adjustedPermutations[$index]) {
				$minDistanceIndex = $index;
			}*/
			$distance = $adjustedPermutation[count($adjustedPermutation) - 1] - $adjustedPermutation[0];
			if ($distance < $minDistance) {
				$minDistanceIndex = $index;
				$minDistance = $distance;
			}
			if ($distance == $minDistance) {
				$closest = $this->closest($adjustedPermutations[$index], $adjustedPermutations[$minDistanceIndex]);
				if ($closest == $adjustedPermutations[$index]) {
					$minDistanceIndex = $index;
				}
			}
		}
		return $adjustedPermutations[$minDistanceIndex];
	}
	
	public function getInversion($set) {
		if (empty($this->_invertedElements)) {
			$inversion = [];
			foreach ($set as $element) {
				$inversion[] = (12 - $element) % 12;
			}
			sort($inversion);
			$this->_invertedElements = $inversion;
		}
		
		return $this->_invertedElements; 
	}
	 
	public function getPrimeOrder() {
		$bestNormalOrder = $this->getBestNormalOrder($this->getSortedElements());
		if ($bestNormalOrder[0] == 0) {
			$order = $bestNormalOrder;
		} else {
			$order = $this->modifySet($bestNormalOrder, $bestNormalOrder[0] * -1, [0, count($bestNormalOrder) - 1]);
		}		
		$invertedBestNormalOrder = $this->getInversion($order);
		$bestInvertedBestNormalOrder = $this->getBestNormalOrder($invertedBestNormalOrder);
		if ($bestInvertedBestNormalOrder[0] != 0) {
			$order2 = $this->modifySet($bestInvertedBestNormalOrder, $bestInvertedBestNormalOrder[0] * -1, [0, count($bestInvertedBestNormalOrder) - 1]);
		} else {
			$order2 = $bestInvertedBestNormalOrder;
		}
		$prime = $this->closest($order, $order2);
		return $prime;
	}
	
	protected function closest($set1, $set2) {
		for ($i = 0; $i < count($set1) - 1; $i++) {
			$distance1 = $set1[($i + 1)] - $set1[$i];
			$distance2 = $set2[($i + 1)] - $set2[$i];
			if ($distance1 < $distance2) {
				return $set1;
			}
			if ($distance2 < $distance1) {
				return $set2;
			}
		}
		return $set1;
	}
}


