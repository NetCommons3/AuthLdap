<?php

App::uses('AuthController', 'Auth.Controller');

class AuthLdapAppController extends AuthController {

/**
 * Return authentication adapter name
 *
 * @return string Authentication adapter name
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 **/
	protected static function _getAuthenticator() {
		return implode('.', array(
			strtr(__CLASS__, array('AppController' => '')),
			'Ldap'));
	}
}
