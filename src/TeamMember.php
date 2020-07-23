<?php

namespace Xzito\Team;

class TeamMember {
  private $id;
  private $name;
  private $email;
  private $order;
  private $photo;
  private $bio;
  private $position;

  public function __construct($team_member_id = '') {
    $this->id = $team_member_id;
    $this->set_name();
    $this->set_email();
    $this->set_order();
    $this->set_photo();
    $this->set_bio();
    $this->set_position();
  }

  public function name() {
    return $this->name;
  }

  public function email() {
    return $this->email;
  }

  public function order() {
    return $this->order;
  }

  public function photo($size = 'thumbnail') {
    return wp_get_attachment_image_url($this->photo, $size);
  }

  public function bio() {
    return $this->bio;
  }

  public function position() {
    return $this->position;
  }

  private function set_name() {
    $first = get_field('team_info', $this->id)['name']['first'];
    $last = get_field('team_info', $this->id)['name']['last'];
    $default = 'Unnamed Team Member';

    $this->name = ($first && $last ? "{$first} {$last}" : $default);
  }

  private function set_email() {
    $this->email = get_field('team_info', $this->id)['email'];
  }

  private function set_order() {
    $this->order = get_post($this->id)->menu_order;
  }

  private function set_photo() {
    $this->photo = get_field('team_info', $this->id)['photo'];
  }

  private function set_bio() {
    $this->bio = get_field('team_info', $this->id)['bio']['text'];
  }

  private function set_position() {
    $position = get_field('team_info', $this->id)['position'];

    $this->position = ($position ? $position->name : '');
  }
}
