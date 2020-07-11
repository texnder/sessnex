<?php

use sessnex\persistent\persistentTrait;
use bootex\Middelware;
use sessnex\exception\ConfigurationException;

/**
 * its a middelware class which handler method execute before 
 * response delivery to client
 */
class Auth extends Middelware
{

	use persistentTrait;

	public function handler()
	{

		if (! $this->checkLoginStatus()) {
			if (defined("USER_LOGIN")) {
				return redirect(USER_LOGIN);
			}else
				throw new ConfigurationException("this page needs user authorization, login url not set in sessnex config file!");
		}
	}


}