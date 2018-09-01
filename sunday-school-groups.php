<?php

/*

Sunday School Plugin

The class represents various groups of pupils

*/

namespace SundaySchoolPlugin;

class Sunday_School_Groups {
  private $groups = array();

  public function __construct() {
    $this->groups = array();
  }

  public function createGroup($name) {
    $group = $this->getGroup($name);
    if ($group == null) {
      $group = new Sunday_School_Group($name);
      array_push($this->groups, $group);
    }
    return $group;
  }

  public function getGroup($name) {
    $res = null;

    foreach($this->groups as $group) {
      if ($group->getName() == $name) {
        $res = $group;
        break;
      }
    }

    return $res;
  }

  public function insertIntoGroup($group_name, Sunday_School_Student $student) {
    $group = $this->createGroup($group_name);
    if ($group != null) {
      $group->insertStrudent($student);
    }
  }

  public function getGroups() {
    return $this->groups;
  }
}

?>
