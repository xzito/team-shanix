<?php

namespace Xzito\Team;

use PostTypes\PostType;

class TeamPostType {
  private $cpt;
  private $taxonomy;
  private $icon = 'dashicons-groups';

  public function __construct() {
    $this->create_post_type();

    $this->set_options();
    $this->set_labels();
    $this->set_columns();

    $this->create_taxonomy();
    $this->set_taxonomy();

    $this->cpt->icon($this->icon);
    $this->cpt->register();
  }

  private function create_post_type() {
    $this->cpt = new PostType($this->names());
  }

  private function names() {
    return [
      'name' => 'team_member',
      'singular' => 'Team Member',
      'plural' => 'Team Members',
      'slug' => 'team'
    ];
  }

  private function set_options() {
    $this->cpt->options([
      'public' => true,
      'show_in_nav_menus' => false,
      'show_in_menu_bar' => false,
      'menu_position' => 21.1,
      'supports' => ['revisions', 'page-attributes'],
      'has_archive' => 'about/team',
      'rewrite' => ['slug' => 'team', 'with_front' => false],
    ]);
  }

  private function set_labels() {
    $this->cpt->labels([
      'search_items' => 'Team',
      'archives' => 'Team',
      'menu_name' => 'Team',
    ]);
  }

  private function set_columns() {
    $this->cpt->columns()->add([
      'photo' => 'Photo',
      'position' => 'Position',
    ]);

    $this->cpt->columns()->hide([
      'date',
    ]);

    $this->cpt->columns()->populate('photo', function ($column, $post_id) {
      $photo = get_field('team_info', $post_id)['photo'];

      echo wp_get_attachment_image($photo, 'thumbnail');
    });

    $this->cpt->columns()->populate('position', function ($column, $post_id) {
      $position = get_field('team_info', $post_id)['position'];

      if ($position) {
        $path = "edit.php?post_type=team_member&position={$position->slug}";
        $link = admin_url($path);

        echo "<a href=\"$link\">$position->name</a>";
      }
    });
  }

  private function create_taxonomy() {
    $this->taxonomy = new PositionTaxonomy();
  }

  private function set_taxonomy() {
    $this->cpt->taxonomy($this->taxonomy->get_name());
  }
}
