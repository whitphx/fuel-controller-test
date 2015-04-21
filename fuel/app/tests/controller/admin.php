<?php

/**
 * @group Controller
 */
class Test_Controller_Admin extends TestCase_Controller
{
	public function test_action_index_logged_in()
	{
		$this->emulate_logged_in('admin');
		$response = \Request::forge('admin/index')->execute()->response();
	}
	
	/**
	 * @expectedException TestRedirectException
	 * @expectedExceptionMessage /:location:302
	 */
	public function test_action_index_logged_in_invalid_auth()
	{
		$this->emulate_logged_in('user');
		$response = \Request::forge('admin/index')->execute()->response();
	}
	
	/**
	 * @expectedException TestRedirectException
	 * @expectedExceptionMessage admin/login:location:302
	 */
	public function test_action_index_logged_out()
	{
		$this->emulate_logged_out();
		$response = \Request::forge('admin/index')->execute()->response();
	}
}