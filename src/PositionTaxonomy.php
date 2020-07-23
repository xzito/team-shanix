<?php

namespace Xzito\Team;

use PostTypes\Taxonomy;

class PositionTaxonomy {
  private $taxonomy;
  private $name = 'position';

  public function __construct() {
    $this->taxonomy = new Taxonomy($this->name);
    $this->set_options();
    $this->taxonomy->register();

    add_action('admin_init', [$this, 'cast_taxonomy_terms'], PHP_INT_MAX);
  }

  public function get_name() {
    return $this->name;
  }

  public function cast_taxonomy_terms() {
    $terms = &$_POST['tax_input'][$this->name];

    if (isset($terms) && is_array($terms)) {
      $terms = array_map('intval', $terms);
    }
  }

  private function set_options() {
    $this->taxonomy->options([
      'publicly_queryable' => false,
      'show_ui' => true,
      'show_in_nav_menus' => false,
      'show_tagcloud' => false,
      'show_in_quick_edit' => false,
      'show_admin_column' => false,
      'hierarchical' => false,
      'meta_box_cb' => false,
    ]);
  }
}
