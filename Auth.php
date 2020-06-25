<?php

use sessnex\persistent\persistentTrait;


class Auth
{

	use persistentTrait;

	public static function user($username = null)
	{
		if (!$username) {
			if (isset($_SESSION[$this->sess_auth]) && $_SESSION[$this->sess_auth]) {
				return $_SESSION[$this->sess_username];
			}
		}else{
			if (isset($_SESSION[$this->sess_username]) && $_SESSION[$this->sess_username] === $username) {
					return isset($_SESSION[$this->sess_auth]) ? $_SESSION[$this->sess_auth] : null;
			}
		}
	}

	public static function login($username, $remember = false)
	{
		if (!isset($_SESSION[$this->sess_auth])) {
			$_SESSION[$this->sess_auth] = true;
			$_SESSION[$this->sess_username] = $username;
			if ($remember) {
				SessionManager::instance()->persistentLogin();
			}
		}
	}

	public static function logout()
	{
		if (isset($_SESSION[$this->sess_auth])) {	
			SessionManager::instance()->trashLoginCreadentials();
		}
	}
}