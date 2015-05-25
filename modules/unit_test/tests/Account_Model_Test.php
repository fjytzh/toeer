<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Valid Helper Test.
 *
 * @package    Unit_Test
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Account_Model_Test extends Unit_Test_Case {

	// Disable this Test class?
	const DISABLED = FALSE;
	
	public function valid_checkOldPasswd_test()
	{
		session_start();
		$_SESSION['userName']='123123';
		$account	= new Account_Model();
		$this
			->assert_true_strict($account->checkOldPasswd('213123'))
			->assert_false_strict($account->checkOldPasswd('213123'));
	}
}
