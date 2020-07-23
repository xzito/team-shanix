<?php

namespace Xzito\Team;

class TeamPage {
  private $banner;
  private $about;
  private $cta;

  public function __construct() {
    $this->set_banner();
    $this->set_about();
    $this->set_cta();
  }

  public function banner($image_size = 'full') {
    return wp_get_attachment_image_url($this->banner, $image_size);
  }

  public function about() {
    return $this->about;
  }

  public function cta($size = 'thumbnail') {
    $cta = $this->cta;

    $cta['image'] = wp_get_attachment_image_url($cta['image'], $size);

    return $cta;
  }

  private function set_banner() {
    $this->banner = get_field('team_page', 'options')['banner'];
  }

  private function set_about() {
    $this->about = get_field('team_page', 'options')['about'];
  }

  private function set_cta() {
    $this->cta = get_field('team_page', 'options')['cta'];
  }
}
