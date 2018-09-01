<?php

/*

Sunday School Plugin

The main class

*/

namespace SundaySchoolPlugin;


class Sunday_School {

  public function __construct() {
    add_shortcode('sunday_school', array($this, 'shortcode_start'));
  }

  /*
    The function checks user role
  */

  function is_user_in_role($role)
  {
    return in_array($role, (array) $this->user->roles);
  }

  /*
    Start function of the shortcode
    This function restrict an access to the list for users with low rights
  */

  public function shortcode_start($atts = [], $content = '', $tag = null) {
    $this->user = new \WP_User(get_current_user_id());
    if ($this->is_user_in_role("administrator") ||
        $this->is_user_in_role("head_teacher")
      ) {
        return $this->shortcode($atts, $content, $tag);
      }
    else {
      return "<p>Извините, Вам запрещено просматривать эту страницу!</p>";
    }
  }

  /*
    The function creates shortcode content
  */

  public function shortcode($atts = [], $content = '', $tag = null) {
    // handle shortcodes attributes
    $atts = array_change_key_case((array)$atts, CASE_LOWER);

    $res = '';

    // add pdf converter function via pdf-Plugin

    if (shortcode_exists('dkpdf-button')) {
      $res .= '<span class="pdf_invisible">' . do_shortcode('[dkpdf-button]') .'</span>';
    }

    // convert posts into group list
    $groups = $this->createGroups();

    // each group - one block on the page
    // $res .= print_r($groups, TRUE);
    foreach ($groups->getGroups() as $group) {
      $res .= ("<h2>" . $group->getName() . "</h2>");
      $res .= "<table width='100%'>";

      $res .= "<tr>
        <th>Имя ребенка</th>
        <th>Родитель</th>
        <th>Телефон</th>
        <th>E-mail</th>
      </tr>";

      // ... output a list of students
      foreach ($group->getStudents() as $student) {
        $res .= ( "<tr>
          <td>". $student->getChild() ."</td>
          <td>". $student->getName()  ."</td>
          <td>". $student->getPhone() ."</td>
          <td>". $student->getEmail() ."</td>
        </tr>" );
      }

      $res .= "</table>";
    }

    return $res;
  }

  /*
    The function retrives posts/email from the Flamingo db
    and creates a groups/students list
  */

  private function createGroups() {
    // Get posts about sunday school
    // retrive posts of the flamingo_inbound type into an array
    $args = array(
      'post_type' => 'flamingo_inbound',
      'posts_per_page' => -1,
      'numberposts' => -1,
    );

    $posts = get_posts($args);

    $groups = new Sunday_School_Groups();

    foreach ($posts as $post) {
      $id = $post->ID;
      $meta = get_post_meta($id);
      // if the post's meta contain necessary information
      if (isset($meta['_field_your-child']) &&
          isset($meta['_field_grade'])
      )  {
        // ...then we obtain this information
        $child = implode('', $meta['_field_your-child']);
        $grade = implode('', $meta['_field_grade']);
        $name  = (isset($meta['_field_your-name']) ? implode($meta['_field_your-name']) : "");
        $phone  = (isset($meta['_field_your-name']) ? implode($meta['_field_your-phone']) : "");
        $email  = (isset($meta['_field_your-name']) ? implode($meta['_field_your-email']) : "");
        // and try to create a new group or insret a student into the existing one
        $groups->insertIntoGroup($grade, new Sunday_School_Student($name, $child, $phone, $email));
      }
    }

    return $groups;
  }


}

?>
