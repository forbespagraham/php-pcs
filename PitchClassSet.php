<?php
class PitchClassSet implements Iterator {
  private $position = 0;
  protected $set = array();
  public $rotations = array();
  static $distance_place = null;
  static $rotations_copy = array();
  
  public function __construct($set) {
    $this->position = 0;
    $this->set = array_fill(0, 12, null);
    $this->add($set);
	$this->rotations = $this->get_rotations();
  }

  public function add($elements) {
    $key = 0;
    foreach ($elements as $element) {
      if (is_int($element)) {
        if (is_null($this->set[$element])) {
          $this->set[$element] = $element;
        }
      }
    }
  }

  public function remove($elements) {
    foreach ($elements as $element) {
      if (!is_null($this->set[$element])) {
        $this->set[$element] = null;
      }
    }
  }

  public function get_rotations() {
    $r = array();
    $members = $this->members();
    $count = count($members);
    $r[] = $members;
    for ($i = 1; $i < $count; $i++) {
      $e = array_shift($members);
      array_push($members, $e + 12);
      $r[] = $members;
    }
    return $r;
  }

  public function generate_rotations($members) {
	$r = array();
    $count = count($members);
    $r[] = $members;
    for ($i = 1; $i < $count; $i++) {
      $e = array_shift($members);
      array_push($members, $e + 12);
      $r[] = $members;
    }
    return $r;
  }

  public function members() {
    $m = iterator_to_array($this);
    return $m;
  }

  public function complement() {
    $c = array();
    $this->rewind();
    while ($this->valid()) {
      if (is_null($this->set[$this->position])) {
        $c[] = $this->position;
      }
      $this->position++;
    }
    $this->rewind();
    return $c;
  }

  public function inversion() {
    $members = $this->members();
    $i = $this->get_inversion($members);
    return $i;
  }

  private function get_inversion($members) {
	$i = array();
	foreach ($members as $element) {
      $i[] = (12 - $element) % 12;
    }
	return $i;
  }

  public function prime_form() {
	$rotations_local_copy = array();
    if (isset($this::$distance_place)) {
	  $distance_array = array();
	  foreach ($this::$rotations_copy as $rotation) {
	    $distance_array[] = $this->distance($rotation);	
	  }	  
	}
	else {
	  $this::$distance_place = count($this->members());
	  $this::$rotations_copy = $this->rotations;
	  foreach ($this->rotations as $rotation) {
        $distance_array[] = $this->distance($rotation);
	  }
	}
	if ($this->one_smallest($distance_array)) {
	  $packed_array = array();
	  $packed_smallest = 11;
	  $smallest = $this->rotations[$this->smallest($distance_array)];
	  $normal = $this->normalize($smallest);
	  $normal_inversion = $this->get_inversion($normal);
	  $normal_rotations = $this->generate_rotations($normal_inversion);
	  foreach ($normal_rotations as $key => $normal_rotation) { 
	    $packed_array[] = array_shift($normal_rotation);
	    $packed_array[] = array_shift($normal_rotation);
	    $packed_distance = $packed_array[1] - $packed_array[0];
	    if ($packed_distance < $packed_smallest) {
		  
	    }
	  }
	}
	else {
	  $this::$distance_place--;
	  foreach ($this::$rotations_copy as $rotation) {
	    array_pop($rotation);
	    $rotations_local_copy[] = $rotation;	
	  }
	  $this::$rotations_copy = $rotations_local_copy;
	  return $this->prime_form();
	}
  }

  private function packed($distance_array) {
	
  }

  private function normalize($set) {
    $normalized = array();
    $subtract_amt = array_shift($set);
    array_unshift($set, $subtract_amt);
    foreach ($set as $element) {
	  $normalized[] = $element - $subtract_amt;
    }
    return $normalized;	
  }

  private function smallest($distance_array) {
	$smallest_value = $distance_array[0];
	$smallest_key = 0;
	foreach ($distance_array as $key => $distance) {
	  if ($distance < $smallest_value) {
	    $smallest_value = $distance;
	    $smallest_key = $key;	
	  }
	}
	return $smallest_key;
  }

  private function one_smallest($distance_array) {
	$smallest = $distance_array[0];
	$smallest_count = 0;
    foreach ($distance_array as $key => $distance) {
	  if ($distance == $smallest) {
	    $smallest_count++;	
	  }
	  else {
	    if ($distance < $smallest) {
		  $smallest = $distance;
	    }	
	  }
    }
    if ($smallest_count > 1) {
	  return false;
    }
    return true;	
  }

  private function distance($set) {
    $least = array_shift($set);
    $greatest = array_pop($set);
    return $greatest - $least;
  }

  public function interval_vector() {
    
  }

  public function forte() {
    
  }

  public function current() {
    if (is_null($this->set[$this->position])) {
      $this->next();
    }
    return $this->set[$this->position];
  }
  
  public function key() {
    if ($this->set[$this->position]) {
      return $this->position;
    }
  }
  
  public function next() {
    do {
      $this->position++;
    } while (is_null($this->set[$this->position]) && $this->valid());
  }
  
  public function rewind() {
    $this->position = 0;
  }
  
  public function valid() {
    if ($this->position < 0 || $this->position >= 11) {
      return false;
    }
    else {
      return true;
    }
  }
}
?>
