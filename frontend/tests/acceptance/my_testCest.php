<?php namespace frontend\tests\acceptance;
use frontend\tests\AcceptanceTester;

use yii\helpers\Url;

class my_testCest
{

    //Command line for terminal to launch Selenium with Google Chrome below
    //java  -Dwebdriver.chrome.driver=/Applications/MAMP/htdocs/yii2/chrome_driver/chromedriver -jar /Applications/MAMP/htdocs/yii2/chrome_driver/selenium-server-standalone-3.141.59.jar

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute(['/task/one', 'id' => 1]));
        $I->wait(1); // wait for page to be opened
        $I->see('My Application');
        $I->wait(1); // wait for page to be opened
        $I->canSee('description');
        $I->wait(1); // wait for page to be opened
        $I->dontSee('Form is filled incorrectly');
        $I->wait(1); // wait for page to be opened
        $I->fillField('Comments[comment]', 'new test comment');
        //$I->click('add_attachment');
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
    }
}
//http://front.yii2:8888/index-test.php?r=task%2Fone&id=1