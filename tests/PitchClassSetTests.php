<?php

use PHPUnit\Framework\TestCase;

class PitchClassSetTests extends TestCase {
	
	public function testGetElements() {
		$pcs1 = new PitchClassSet([0, 1, 4]);
		$this->assertEquals([0, 1, 4], $pcs1->getElements());
	}
	
	public function testGetSortedElements() {
		$pcs1 = new PitchClassSet([5, 6, 2]);
		$this->assertEquals([2, 5, 6], $pcs1->getSortedElements());
	}
	
	public function testGetPermutations() {
		$pcs1 = new PitchClassSet([0]);
		$permutations = $pcs1->getPermutations([0, 1, 2, 4]);
		$this->assertEquals([0, 1, 2, 4], $permutations[0]);
		$this->assertEquals([1, 2, 4, 0], $permutations[1]);
		$this->assertEquals([2, 4, 0, 1], $permutations[2]);
		$this->assertEquals([4, 0, 1, 2], $permutations[3]);
	}
	
	public function testGetInversion() {
		$pcs1 = new PitchClassSet([0]);
		$this->assertEquals([4, 8, 9, 10], $pcs1->getInversion([2, 3, 4, 8]));
	}
	
	public function testGetPrimeOrder() {
		$pcs1 = new PitchClassSet([3, 4, 11, 10, 5]);
		$this->assertEquals([0, 1, 2, 6, 7], $pcs1->getPrimeOrder());
		
		$pcs2 = new PitchClassSet([0, 1, 4, 9]);
		$this->assertEquals([0, 3, 4, 7], $pcs2->getPrimeOrder());
	}
	
}