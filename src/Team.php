<?php

namespace Xzito\Team;

class Team {
  private $taxonomy;
  private $post_type;

  public function __construct() {
    add_action('init', [$this, 'create_post_type'], 0);
    add_action('plugins_loaded', [$this, 'create_options_page']);
    add_action('acf/save_post', [$this, 'set_fields_on_save'], 20);
  }

  public function create_post_type() {
    new TeamPostType();
  }

  public function create_options_page() {
    if (function_exists('acf_add_options_sub_page')) {
      acf_add_options_sub_page([
        'page_title' => 'Team Page',
        'menu_title' => 'Team Page',
        'parent_slug' => 'edit.php?post_type=team_member',
      ]);
    }
  }

  public function set_fields_on_save($post_id) {
    if (!$this->will_set_on_save($post_id)) {
      return;
    }

    $team_member = new TeamMember($post_id);
    $post_name = $this->format_post_name($team_member->name());
    $post_title = $team_member->name();

    wp_update_post([
      'ID' => $post_id,
      'post_name' => $post_name,
      'post_title' => $post_title,
    ]);
  }

  private function will_set_on_save($id) {
    return (get_post_type($id) == 'team_member' ? true : false);
  }

  private function format_post_name($name) {
    $formatted_name = strtolower($name);
    $formatted_name = str_replace(' ', '-', $formatted_name);

    return $formatted_name;
  }

  public static function find($id = '') {
    return new TeamMember($id);
  }
}
