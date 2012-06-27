<?php

namespace AvatarsIo;

class Undefined_credentials extends \Exception {
  protected $message = 'You must provide your client id and access token.';
}

class Cant_access_file extends \Exception {
  protected $message = 'The file your provided couldn’t be used, please check path and permissions.';
}