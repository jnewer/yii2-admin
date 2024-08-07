<?php

namespace tests\codeception\backend\acceptance;

use tests\codeception\backend\AcceptanceTester;
use tests\codeception\common\_pages\LoginPage;

/** @var $scenario \Codeception\Scenario */

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure login page works');

$loginPage = LoginPage::openBy($I);

$I->amGoingTo('submit login form with no data');
$loginPage->login('', '');
if (method_exists($I, 'wait')) {
    $I->wait(3); // only for selenium
}
$I->expectTo('see validations errors');
$I->see('Username cannot be blank.', '.help-block');
$I->see('Password cannot be blank.', '.help-block');

$I->amGoingTo('try to login with wrong credentials');
$I->expectTo('see validations errors');
$loginPage->login('admin', 'wrong');
if (method_exists($I, 'wait')) {
    $I->wait(3); // only for selenium
}
$I->expectTo('see validations errors');
$I->see('Incorrect username or password.', '.help-block');

$I->amGoingTo('try to login with correct credentials');
$loginPage->login('erau', 'password_0');
if (method_exists($I, 'wait')) {
    $I->wait(3); // only for selenium
}
$I->expectTo('see that user is logged');
$I->see('Logout (erau)', 'form button[type=submit]');
$I->dontSeeLink('Login');
$I->dontSeeLink('Signup');
/** Uncomment if using WebDriver
 * $I->click('Logout (erau)');
 * $I->dontSeeLink('Logout (erau)');
 * $I->seeLink('Login');
 */
