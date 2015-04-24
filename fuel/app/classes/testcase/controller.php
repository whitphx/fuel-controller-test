<?php
use AspectMock\Test as test;

class TestRedirectException extends \Exception
{}

class TestCase_Controller extends \TestCase
{
	protected function setup()
	{
		// Response::redirect()のexitを回避する．
		test::double('Fuel\Core\Response', array(
			'redirect' => function($url = '', $method = 'location', $code = 302){
				throw new TestRedirectException(sprintf('%s:%s:%s)', $url, $method, $code));
			}
		));
		
		// 本物のRequest::is_hmvc()は \Fuel::$is_cli and static::main() 条件があってcliから実行するtestだとtrueになってしまうので，その条件を外すために置き換える
		test::double('Fuel\\Core\\Request', array(
			'is_hmvc' => function() {
				return \Request::active() !== \Request::main();
			}
		));
		
		// Requestをリセットしないと\Request::$mainが残ったままになって２度目以降の\Request::forge()からの\Request::is_hmvc()で問題になる
		\Request::reset_request(true);
		
		// > テストから呼び出されるViewはなぜかAssetクラスが動いてくれないので、パス解決のエラー表示を無効にしておきます。 ( http://qiita.com/masahikoofjoyto/items/206e6f8d5b0aa7126678 )
		\Config::load('asset', true, false, true);
		\Config::set('asset.fail_silently', true);
	}
	
	protected function tearDown()
	{
		\Auth::logout();
		test::clean();
	}
	
	protected function emulate_logged_in($usertype = '')
	{
		switch ($usertype)
		{
			case 'admin':
				\Auth::login('admin');
				$user = \Model_User::forge(array(
					'id' => 1,
					'username' => 'admin',
					'email' => 'admin@example.com',
					'group' => 100,
				));
			break;
		
			case 'user':
				\Auth::login('user');
				$user = \Model_User::forge(array(
					'id' => 2,
					'username' => 'user',
					'email' => 'user@example.com',
					'group' => 1,
				));
			break;
		
			default:
				$user = null;
		}
		test::double('Model_User', array('find_by_username' => $user));
	}
	
	protected function emulate_logged_out()
	{
		\Auth::logout();
	}
}