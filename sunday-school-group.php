<?php

/*

Sunday School Plugin

The class represents a single group and it's list of students

*/

namespace SundaySchoolPlugin;

class Sunday_School_Group {
  private $name = "";
  private $students = array();

  public function __construct($name) {
    $this->name = $name;
    $this->students = array();
  }

  public function getName() {
    return $this->name;
  }

  public function getStudents() {
    uasort($this->students, array($this, 'cmpStudents'));
    return $this->students;
  }

  public function insertStrudent(Sunday_School_Student $student) {
    array_push($this->students, $student);
  }

  private function cmpStudents(Sunday_School_Student $a, Sunday_School_Student $b) {
    return strcmp($a->getChild(), $b->getChild());
  }


}


?>
