<?php
class PitchClassSet implements Iterator {
  protected $set = array();

  public function __construct($set) {
    $this->set = array_fill(0, 12, null);
    $this->add($set);
  }

  public function add($elements) {
    foreach ($elements as $element) {
      if (is_null($this->set[$element])) {
        $this->set[$element] = $element;
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

  public function current() {
  
  }
  
  public function key() {
  
  }
  
  public function next() {
  
  }
  
  public function rewind() {
  
  }
  
  public function valid() {
  
  }
}
?>
