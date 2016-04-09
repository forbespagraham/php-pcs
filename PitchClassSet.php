<?php
class PitchClassSet implements Iterator {
  private $position = 0;
  protected $set = array();
  static $rotation_place;

  public function __construct($set) {
    $this->position = 0;
    $this->set = array_fill(0, 12, null);
    $this->add($set);
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

  public function rotations() {
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
    $i = array();
    $members = $this->members();
    foreach ($members as $element) {
      $i[] = (12 - $element) % 12;
    }
    return $i;
  }

  public function prime_form() {
    $rotations = $this->rotations();
    $count = 0;
    $distance_array = array();
    $primes = array();
    $greatest_distance = 0;
    foreach ($rotations as $rotation) {
      $distance_array[] = $this->distance($rotation);
    }
    foreach ($distance_array as $key => $distance) {
      if ($distance > $greatest_distance) {
        $greatest_distance = $distance;
        
      }
    }
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
