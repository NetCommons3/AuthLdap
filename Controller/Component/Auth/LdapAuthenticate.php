<?php
App::uses('BaseAuthenticate', 'Controller/Component/Auth');
/**
 * Auth Controller
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class LdapAuthenticate extends BaseAuthenticate {

/**
 * __construct
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @return   void
 **/
	public function __construct() {
		CakeLog::debug('ldap __construct()');
	}

/**
 * Checks the fields to ensure they are supplied.
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @param    CakeRequest $request The request that contains login information.
 * @param    string $model The model used for login verification.
 * @param    array $fields The fields to be checked.
 * @return   bool False if the fields have not been supplied. True if they exist.
 */
	protected function _checkFields(CakeRequest $request, $model, $fields) {
		if (empty($request->data[$model])) {
			return false;
		}
		foreach (array($fields['username'], $fields['password']) as $field) {
			$value = $request->data($model . '.' . $field);
			if (empty($value) || !is_string($value)) {
				return false;
			}
		}
		return true;
	}

/**
 * Authenticates the identity contained in a request. Will use the `settings.userModel`, and `settings.fields`
 * to find POST data that is used to find a matching record in the `settings.userModel`. Will return false if
 * there is no post data, either username or password is missing, or if the scope conditions have not been met.
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @param    CakeRequest $request The request that contains login information.
 * @param    CakeResponse $response Unused response object.
 * @return   mixed False on login failure. An array of User data on success.
 */
	public function authenticate(CakeRequest $request, CakeResponse $response) {
		CakeLog::debug('ldap authenticate()');

		$userModel = $this->settings['userModel'];
		list(, $model) = pluginSplit($userModel);

		$fields = $this->settings['fields'];
		if (!$this->_checkFields($request, $model, $fields)) {
			return false;
		}
		$con = ldap_connect('127.0.0.1');
		$search = ldap_search($con, 'dc=netcommons,dc=local', 'cn=user1');
		$result = ldap_get_entries($con, $search);
		CakeLog::debug('ldap search: ' . var_export($result, true));

		return false;
	}
}
