<?php
class PitchClassSet implements Iterator {
  private $position = 0;
  protected $set = array();

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

  public function complement() {
    
  }

  public function inversion() {

  }

  public function prime_form() {

  }

  public function interval_vector() {
    
  }

  public function forte() {
    
  }

  public function current() {
    return $this->set[$this->position];
  }
  
  public function key() {
    return $this->position;
  }
  
  public function next() {
    do {
      $this->position++;
    } while (is_null($this->set[$this->position]) && $this->valid());
    return $this->set[$this->position];
  }
  
  public function rewind() {
    $this->position = 0;
  }
  
  public function valid() {
    if ($this->position < 0 || $this->position > 11) {
      return false;
    }
    else {
      return true;
    }
  }
}
?>
