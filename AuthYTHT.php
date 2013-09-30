<?php
// This program is free software: you can redistribute it and/or modify it
// under the terms of the GNU General Public License as published by the Free
// Software Foundation, either version 3 of the License, or (at your option)
// any later version.
//
// This program is distributed in the hope that it will be useful, but WITHOUT
// ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
// FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
// more details.
//
// You should have received a copy of the GNU General Public License along with
// this program.  If not, see <http://www.gnu.org/licenses/>.
//
// Copyright 2013 IronBlood, based on Auth_imap by Rusty Burchfield
 
// Add these two lines to the bottom of your LocalSettings.php
// require_once('extensions/AuthYTHT/AuthYTHT.php');
// $wgAuth = new AuthYTHT();
 
// The AuthYTHT class is an AuthPlugin so make sure we have this included.

require_once('AuthPlugin.php');

class AuthYTHT extends AuthPlugin {

	function AuthYTHT() {

	}

	/**
	 * Disallow password change.
	 *
	 * @return bool
	 */
	function allowPasswordChange() {
		return false;
	}

	/**
	 * Always fail.
	 *
	 * @param @user User object.
	 * @param @password String: password.
	 * @return bool
	 */
	function setPassword($user, $password) {
		return false;
	}

	/**
	 * We don't support this but we have to return true for preferences to save.
	 *
	 * @param $user User object.
	 * @return bool
	 * @public
	 */
	function updateExternalDB($user) {
		return true;
	}
 
	/**
	 * We can't create external accounts so return false.
	 *
	 * @return bool
	 * @public
	 */
	function canCreateAccounts() {
		return false;
	}
 
	/**
	 * We don't support adding users to whatever service provides REMOTE_USER, so
	 * fail by always returning false.
	 *
	 * @param $user User 
	 * @param $password String: password 
	 * @return bool
	 * @public
	 */
	function addUser($user, $password) {
		return false;
	}
 
 
	/**
	 * Pretend all users exist.  This is checked by authenticateUserData to
	 * determine if a user exists in our 'db'.  By returning true we tell it that
	 * it can create a local wiki user automatically.
	 *
	 * @param $username String: username.
	 * @return bool
	 * @public
	 */
	function userExists($username) {
		return true;
	}


	/**
	 * Attempt to autenticate the user from YTHT system.
	 * @param $username String: username.
	 * @param $password String: password.
	 * @return bool
	 * @public
	 */
	function authenticate($username, $password) {
		// todo
	}

	/**
	 * Check to see if the specific domain is a valid domain.
	 * @param $domain String: authentication doamin.
	 * @return bool
	 * @public
	 */
	function validDomain($domain) {
		return true;
	}

	/**
	 * When a user logs in, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external user database.
	 *
	 * The User object is passed by reference so it can be modified; don't
	 * forget the & on your function declaration.
	 *
	 * @param User $user
	 * @public
	 */
	function updateUser(&$user) {
		// We only set this stuff when accounts are created.
		return true;
	}

	/**
	 * Return true because the wiki should create a new local account
	 * automatically when asked to login a user who doesn't exist locally but
	 * does in the external auth database.
	 *
	 * @return bool
	 * @public
	 */
	function autoCreate() {
		return true;
	}
 
	/**
	 * Return true to prevent logins that don't authenticate here from being
	 * checked against the local database's password fields.
	 *
	 * @return bool
	 * @public
	 */
	function strict() {
		return false;
	}
 
	/**
	 * When creating a user account, optionally fill in preferences and such.
	 * For instance, you might pull the email address or real name from the
	 * external user database.
	 *
	 * @param $user User object.
	 * @public
	 */
	function initUser(&$user) {
		global $_SERVER;
		$username = $_REQUEST['wpName'];
 
		// Using your own methods put the users real name here.
		// $user->setRealName('');
		// Using your own methods put the users email here.
		// $user->setEmail("$username@$maildomain");
 
		// $user->mEmailAuthenticated = wfTimestampNow();
		// $user->setToken();
 
		//turn on e-mail notifications by default
		// $user->setOption('enotifwatchlistpages', 1);
		// $user->setOption('enotifusertalkpages', 1);
		// $user->setOption('enotifminoredits', 1);
		// $user->setOption('enotifrevealaddr', 1);
 
		$user->saveSettings();
	}
 
	/**
	 * Modify options in the login template. This shouldn't be very important
	 * because no one should really be bothering with the login page.
	 *
	 * @param $template UserLoginTemplate object.
	 * @public
	 */
	function modifyUITemplate(&$template) {
		//disable the mail new password box
		$template->set('useemail', false);
		$template->set('create', false);
		$template->set('domain', false);
		$template->set('usedomain', false);
	}
 
	/**
	 * Normalize user names to the mediawiki standard to prevent duplicate
	 * accounts.
	 *
	 * @param $username String: username.
	 * @return string
	 * @public
	 */
	function getCanonicalName($username) {
		// lowercase the username
		$username = strtolower($username);
		// uppercase first letter to make mediawiki happy
		$username[0] = strtoupper($username[0]);
		return $username;
	}
}
