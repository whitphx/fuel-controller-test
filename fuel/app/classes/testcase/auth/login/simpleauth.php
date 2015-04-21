<?php
class Auth_Login_Simpleauth extends \Auth\Auth_Login_Simpleauth
{
	/**
	 * Check the user exists
	 *
	 * @return  bool
	 */
	public function validate_user($username_or_email = '', $password = '')
	{
		switch ($username_or_email)
		{
			case 'admin':
				return array(
					'id' => 1,
					'username' => 'admin',
					'email' => 'admin@example.com',
					'group' => 100,
				);
			break;
		
			case 'user':
				return array(
					'id' => 2,
					'username' => 'user',
					'email' => 'user@example.com',
					'group' => 1,
				);
			break;
		
			default:
				return false;
		}
	}
	
	
	/**
	 * Creates a temporary hash that will validate the current login
	 *
	 * @return  string
	 */
	public function create_login_hash()
	{
		if (empty($this->user))
		{
			throw new \SimpleUserUpdateException('User not logged in, can\'t create login hash.', 10);
		}

		$last_login = \Date::forge()->get_timestamp();
		$login_hash = sha1(\Config::get('simpleauth.login_hash_salt').$this->user['username'].$last_login);

		$this->user['login_hash'] = $login_hash;

		return $login_hash;
	}
}