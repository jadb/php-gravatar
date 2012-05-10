<?php

class Gravatar {
  protected $_http = 'http://www.gravatar.com/avatar/';
  protected $_https = 'https://secure.gravatar.com/avatar/';
  protected $_rating = 'pg';
  protected $_size = 80;
  protected $_default = 'mm';
  protected $_ssl = false;
  public function __construct($options = array()) {
    $options = array_merge(
        array(
          'rating' => 'pg',
          'size' => 80,
          'default' => 'mm',
          'ssl' => false,
        ), $options
    );
    foreach ($options as $option => $value) {
      $option = "_$option";
      $this->{$option} = $value;
    }
  }
  public function setDefault($default = 'mm') {
    $regex = '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})';
    $regex .= '(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:';
    $regex .= '\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(';
    $regex .= '?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1';
    $regex .= '}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(';
    $regex .= '?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS';

    if (in_array($default, array('404', 'mm', 'identicon', 'monsterid', 'wavatar', 'retro')) || preg_match($regex, $default)) {
      $this->_default = $default;
      return $this;
    }
    return false;
  }
  public function setEmail($email) {
    $regex = '/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9][-a-z0-9]';
    $regex .= '*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)$/i';
    if (preg_match($regex, $email)) {
      $this->_email = $email;
      return $this;
    }
    return false;
  }
  public function setRating($rating = 'pg') {
    if (in_array($rating, array('g', 'pg', 'r', 'x'))) {
      $this->_rating = $rating;
      return $this;
    }
    return false;
  }
  public function setSize($size = 80) {
    if ((int) $size > 1 && (int) $size <= 512) {
      $this->_size = $size;
      return $this;
    }
    return false;
  }
  public function setSsl($ssl = false) {
    if (is_bool($ssl)) {
      $this->_ssl = $ssl;
      return $this;
    }
    return false;
  }
  public function url() {
    $url = $this->_http;
    if ($this->_ssl) {
      $url = $this->_https;
    }
    return sprintf(
        '%s%s?r=%s&s=%s&d=%s',
        $url,
        md5(strtolower(trim($this->_email))),
        $this->_rating,
        $this->_size,
        urlencode(($this->_default))
    );
  }
}
