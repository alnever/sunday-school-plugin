<?php

/*

Sunday School Plugin

The class represents a single student

*/


namespace SundaySchoolPlugin;

class Sunday_School_Student {
  private $name = "";
  private $child = "";
  private $phone = "";
  private $email = "";

  public function __construct($name, $child, $phone, $email) {
    $this->name = $name;
    $this->child = $child;
    $this->phone = $phone;
    $this->email = $email;
  }

  public function getName() {
    return $this->name;
  }

  public function getChild() {
    return $this->child;
  }

  public function getPhone() {
    return $this->phone;
  }

  public function getEmail() {
    return $this->email;
  }
}

?>
