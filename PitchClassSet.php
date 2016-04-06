<?php
class PitchClassSet implements Iterator {
  protected $set = array();

  public function __construct($set) {
    $this->set = array_fill(0, 12, null);
    foreach ($set as $element) {
      $this->set[$element] = $element;
    }
  }

  public function add($elements) {

  }

  public function remove($elements) {

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
