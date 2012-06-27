<?php

class Avatart_Tests extends PHPUnit_Framework_TestCase {

  protected function setUp()
  {
    $this->avatar = new \AvatarsIo\Avatar('xxxxx', 'xxxxx');
  }

  public function testUrl()
  {
	$url = $this->avatar->url('twitter', 'username');
      $this->assertEquals('http://avatars.io/twitter/username?size=default', $url);
  }

	public function testUploadAvatar()
	{
		$this->markTestIncomplete(
          'Tests are not isolated at the moment you must provide valid credentials.'
        );
		$this->assertNotNull($this->avatar->upload('./fixtures/finder.png'));
	}

	public function testUploadAvatarWithIdentifier()
	{
		$this->markTestIncomplete(
          'Tests are not isolated at the moment you must provide valid credentials.'
        );
		$this->assertNotNull($this->avatar->upload('./fixtures/finder.png', 'finder'));
	}

}