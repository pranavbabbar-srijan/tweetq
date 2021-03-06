<?php
use Drupal\DrupalExtension\Context\RawDrupalContext;
use Drupal\DrupalExtension\Context\MinkContext;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Step\Given;
use Behat\Behat\Context\Step\Then;
use Behat\Behat\Context\Step\When;



/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawDrupalContext implements SnippetAcceptingContext {
var $originalWindowName = '';
  /**
   * Initializes context.
   *
   * Every scenario gets its own context instance.
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */

  public $validtext, $invalidtext, $Totaltweet, $notification,  $unixTimeStamp, $Valid,$Total,$Invalid,$Archived,$linktext, $newtweet, $tweeted;
  public function __construct() {
    $this->unixTimeStamp = time();
  }

/**
 * @Then I verified maximum two sliders can be added on
 */
public function maximumslider(){

    $session = $this->getSession();// get the mink session
    $element = $session->getPage()->find('xpath',"//ol[contains(@class,'flex-control-nav')]");
    

  //  $dom = new DOMDocument(); 
  //  $dom->loadHTML($string);
  //  echo "<pre>";
  //  $xpath = new DOMXPath($dom);
  //  $htmlString = $dom->saveHTML($xpath->item(0));
  //  $xpath_resultset =  $xpath->query("//div[@id='flexslider-1']/ol");
  //  $htmlString = $dom->saveHTML($xpath_resultset->item(0));
  // //  $res=$xpath->query($xpath);
  // //  print_r($res);
  // //  $text =$element ->getText();
  // //  echo $text,PHP_EOL;
  // // // //  print_r($text); die();
 
  // // // // $text=$text->getText();
  // //   $dom = new DOMDocument(); 
  // //   $dom->loadHTML($text); 
  // //   // print_r($dom);
  // //   $value = $dom->getElementsByTagName("li")->length;
  // //   // print_r($value);
  // //  var_dump($xpath);die;
   $count = substr_count($element->name,'<li>');
   echo $count;

  //  //echo ()gettype($text);
  


}
/**
 * @Then I test 
 */
public function test(){

  $dom = new DomDocument;
/* Load the HTML */
$dom->loadHTMLFile("http://testing-z6am3cq-na2rj6uui4vei.eu.platform.sh");
/* Create a new XPath object */
$xpath = new DomXPath($dom);
/* Query all <td> nodes containing specified class name */
$nodes = $xpath->query("//div[@id='flexslider-1']/ol");
/* Set HTTP response header to plain text for debugging output */
header("Content-type: text/plain");
/* Traverse the DOMNodeList object to output each DomNode's nodeValue */
foreach ($nodes as $i => $node) {
    echo "Node($i): ", $node->nodeValue, "\n";  $dom = new DomDocument;
/* Load the HTML */
$dom->loadHTMLFile("https://forums.eveonline.com");
/* Create a new XPath object */
$xpath = new DomXPath($dom);
/* Query all <td> nodes containing specified class name */
$nodes = $xpath->query("//td[@class='topicViews']");
/* Set HTTP response header to plain text for debugging output */
header("Content-type: text/plain");
/* Traverse the DOMNodeList object to output each DomNode's nodeValue */
foreach ($nodes as $i => $node) {
    echo "Node($i): ", $node->nodeValue, "\n";
}
}
}


  /**
     * Click on the element with the provided xpath query
     *
     * @When /^I click on the element with xpath "([^"]*)"$/
     */
    public function iClickOnTheElementWithXPath($xpath)
    {
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)
        ); // runs the actual query and returns the element
 
        // errors must not pass silently
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
        }
        
        // ok, let's click on it
        $element->click();
 
}

/**
 * @Then I fill in some unique text
 */
public function uniquetweet(){
  $this->getSession()->getPage()->fillField("edit-message", "tweet#".$this->unixTimeStamp);
}

/**
 * @Then I fill in invalid tweet
 */
public function invalidtweet(){
  $this->getSession()->getPage()->fillField("edit-message", "invalid tweet invalid tweet invalid tweet invalid tweet invalid tweet invalid tweet invalid tweet invalid tweet invalid tweet invalid tweet invalid".$this->unixTimeStamp);
}


/**
 * @Then I fill in some unique email id
 */
public function uniqueemail(){
  $this->getSession()->getPage()->fillField("edit-email", "barbettest".$this->unixTimeStamp."@gmail.com");
}

  /**
   * Checks, that form element with specified label and type is visible on page.
   *
   * @Then /^(?:|I )should see an? "(?P<label>[^"]*)" (?P<type>[^"]*) form element$/
   */
  public function assertTypedFormElementOnPage($label, $type) {
    $container = $this->getSession()->getPage();
    $pattern = '/(^| )form-type-' . preg_quote($type). '($| )/';
    $label_nodes = $container->findAll('css', '.form-item label');
    foreach ($label_nodes as $label_node) {
      // Note: getText() will return an empty string when using Selenium2D. This
      // is ok since it will cause a failed step.
      if ($label_node->getText() === $label
        && preg_match($pattern, $label_node->getParent()->getAttribute('class'))
        && $label_node->isVisible()) {
        return;
      }
    }
    throw new \Behat\Mink\Exception\ElementNotFoundException($this->getSession(), $type . ' form item', 'label', $label);
  }


/**
 * @Then /^I fetch href for xpath "([^"]*)"$/
 */
public function fetchhref($xpath) {
        
   $session = $this->getSession(); // get the mink session
   $el= $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', $xpath));

   if ($el->hasAttribute('href')) {

    echo $el->getAttribute('href');
    } 
     else {
       echo 'This anchor is not a link. It does not have an href.';
}
     

    }



/**
 * @Then I fetch text for valid tweet
 */
public function fetchTextForXpathV() {
        
        global $validtext;
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[2]//span[2]") );
           $validtext = $element ->getText();
           echo 'Valid Tweet is : ' . $validtext,PHP_EOL;
         if (null === $validtext) {
        throw new \Exception('text not found');
    }

    }

  /**
 * @Then I fetch text for new tweet
 */
  public function fetchnewtweet(){

    global $newtweet;
    $session = $this->getSession(); 
    $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@class='valid-tweets-header']//a[1]") );
     $val = $element ->getText();
     $text=explode("(",$val);
    $newtweet=explode(")",$text[1]);
    echo 'The new tweet count is: ' .$newtweet[0];
   
  }
/**
* @Then I fetch text for tweeted tweet
*/
public function fetchtweeted(){
  global $tweeted;
  $session= $this->getSession();
  $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@class='valid-tweets-header']//a[2]") );
     $val = $element ->getText();
     $text=explode("(",$val);
    $tweeted=explode(")",$text[1]);
    echo 'The tweeted count is: ' .$tweeted[0];
}

/**
 * @Then tweeted decremented
 */
    
  public function tweeteddec()
  {
    global $tweeted;
    $session = $this->getSession(); 
    $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@class='valid-tweets-header']//a[2]") );
     $val = $element ->getText();
     $text=explode("(",$val);
    $text1=explode(")",$text[1]);
     $tweeted[0]--;
     echo 'The tweeted count after :' .$tweeted[0];
    if ($tweeted[0]==$text1[0])
      echo 'the tweeted moved to new tweets';
    else 
      echo 'invalid operation';
  }


/**
 * @Then new tweet incremented
 */
    
  public function newtweetinc()
  {
    global $newtweet;
    $session = $this->getSession(); 
    $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@class='valid-tweets-header']//a[1]") );
     $val = $element ->getText();
     $text=explode("(",$val);
    $text1=explode(")",$text[1]);
     $newtweet[0]++;
     echo 'The new tweet count after :' .$newtweet[0];
    if ($newtweet[0]==$text1[0])
      echo 'the tweet is moved to new tweet';
    else 
      echo 'invalid operation';
  }

  /**
 * @Then new tweet updated
 */
    
  public function newtweetupd()
  {
    global $newtweet;
    $session = $this->getSession(); 
    $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@class='valid-tweets-header']//a[1]") );
     $val = $element ->getText();
     $text=explode("(",$val);
    $text1=explode(")",$text[1]);
     $newtweet[0]=$newtweet[0]+5;
     echo "Updated tweet: " .$newtweet[0];
    if ($newtweet[0]==$text1[0])
      echo 'New tweet is updated';
    else 
      echo 'invalid operation';
  }
    /**
 * @Then I fetch text for total tweet
 */
public function fetchTextForXpathT() {
        
        global $Totaltweet;
        $session = $this->getSession(); // get the mink session
         $element1=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[1]//span[2]") );
           $Totaltweet=$element1 ->getText();
          echo 'Total tweet Before is : ' .$Totaltweet,PHP_EOL;
    if (null == $Totaltweet) {
        throw new \Exception('text not found');
    }

    }

     /**
 * @Then I fetch text for archived tweet
 */
public function fetchTextForXpathA() {
        
        global $Archived;
        $session = $this->getSession(); // get the mink session
         $element1=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[4]//span[2]") );
           $Archived=$element1 ->getText();
          echo 'Archived tweet Before is : ' .$Archived,PHP_EOL;
    if (null == $Archived) {
        throw new \Exception('text not found');
    }

    }


     /**
 * @Then /^tweet is invalid "([^"]*)"$/
 */
public function tweetsizeinvalid($xpath) {
        
        
    $session = $this->getSession(); // get the mink session
     $element1=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', $xpath));
           $element1=$element1 ->getText();
          echo "Element is:  ".$element1,PHP_EOL;
    if ($element1>= 140) {
       echo "Tweet is invalid tweet";
    }
else 
  echo "incorrect result";
   }

/**
 *@Then I fetch text for invalid tweet
 */
public function fetchTextForXpath1() {
        
        global $invalidtext;
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[3]//span[2]" ) );
      
        $invalidtext = $element ->getText();

    echo 'Invalid tweet before is : ' . $invalidtext,PHP_EOL;
    if (null === $invalidtext) {
        throw new \Exception('text not found');
    }

    }

/**
 *@Then I fetch text for notification count
 */
public function fetchnotify() {
        
        global $notification;
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='twitter-notification-count']//span[@class='count']" ));
    // $page = $this->getSession()->getPage();
    // $element = $page->find('xpath', $selector);
   
        $notification = $element ->getText();

    echo 'Value Before tweet is : ' . $notification,PHP_EOL;
    if (null === $invalidtext) {
        throw new \Exception('text not found');
    }

    }
/**
 * @Then total tweet gets decremented
 */
public function totaltweetdelete(){

  global $Totaltweet;
  $session = $this->getSession();
  $element=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-userstweetsstatisticsblock']//a[1]//span[2]"));
  $element=$element->getText();
  $Totaltweet--;
  if($Totaltweet==$element)
    { 
    echo "Tweet after deletion is  ".$Totaltweet;
    }
else
  echo "incorrect result";
}

/**
 * @Then total tweet after deletion
 */
public function deletiontotaltweet(){

  global $Totaltweet;
  $session = $this->getSession();
  $element=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-userstweetsstatisticsblock']//a[1]//span[2]"));
  $element=$element->getText();
  $Totaltweet= $Totaltweet - 3;
  if($Totaltweet==$element)
    { 
    echo "Tweet after deletion is  ".$Totaltweet;
    }
else throw new \Exception('incorect result');
}

/**
 * @Then all tweets on a page is deleted
 */
public function alltweetdelete(){

  global $Totaltweet;
  $session = $this->getSession();
  $element=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-userstweetsstatisticsblock']//a[1]//span[2]"));
  $element=$element->getText();
  $Totaltweet= $Totaltweet - 10;
  if($Totaltweet==$element)
    { 
    echo "Tweet after deletion is  ".$Totaltweet;
    }
else throw new \Exception('incorect result');


}

/**
 * @Then archived tweet gets decremented
 */
public function archivedtweetdelete(){

  global $Archived;
  $session = $this->getSession();
  $element=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-userstweetsstatisticsblock']//a[4]//span[2]"));
  $element=$element->getText();
  $Archived--;
  if($Archived==$element)
    { 
    echo "Tweet after deletion is  ".$Archived;
    }
else
  echo "incorrect result";
}

    /**
 * @Then valid tweet gets decremented
 */
public function validtweetdelete(){

  global $validtext;
  $session = $this->getSession();
  $element=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-userstweetsstatisticsblock']//a[2]//span[2]"));
  $element=$element->getText();
  $validtext--;
  if($validtext==$element)
    { 
    echo "Tweet after deletion is  ".$validtext;
    }
else
  echo "incorrect result";
}

 /**
 * @Then invalid tweet gets decremented
 */
public function invalidtweetdelete(){

  global $invalidtext;
  $session = $this->getSession();
  $element=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-userstweetsstatisticsblock']//a[3]//span[2]"));
  $element=$element->getText();
  $invalidtext--;
  if($invalidtext==$element)
    { 
    echo "Tweet after deletion is  ".$invalidtext;
    }
else
  echo "incorrect result";
}

/**
 * @Then invalid tweet can be saved if characters are removed
 */
public function invalidtweetedit(){
  global $invalidtext,$validtext;
  $session=$this->getSession();
  $element=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//textarea[@id='edit-message']"));
  $element=$element->getText();
  echo("current text - ".$element);
  $element->fillField("edit-message", "tweet#".$this->unixTimeStamp);
  #$element.click();
  #$newelement=str_replace($element, "this tweet is valid now", $element);
  $element->setValue("NEw alue");
  #echo $newelement;
}
  /**
 * @Then tweet is edited
 */
public function editinvalidtweet(){
  
  $session=$this->getSession();
  $element=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//textarea[@id='edit-message']"));
  $element=$element->getText();
  $session->getPage()->fillField("edit-message", $element."test");
  echo "$element"."test";


}

/** 
*@Then /^Size of Tweet "([^"]*)"$/
**/
public function sizetweet($xpath){
  $session=$this->getSession();
  $tweetval =$xpath."/li[1]";
  $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',$tweetval));
  $element=$element->getText();
  echo $element,PHP_EOL;
  $TweetSize=strlen($element);
  $sizeval= $xpath."/li[2]";
  echo "The Tweet is: ". $element ,PHP_EOL;
  echo "The size is: " . $TweetSize;PHP_EOL;
  $element1=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',$sizeval));
  $size=$element1->getText();
  if($size==$TweetSize)
  {
    echo "Tweet Size matches :".$TweetSize,PHP_EOL;
  }

else echo "incorrect Result";
}

 
    /**
 * @Then I fetch text for no tweet found
 */
public function newtweets() {
 
 $session = $this->getSession(); // get the mink session
   $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-usersvalidtweetsblock']//div[@class='valid-tweets-header']//a[1] ") );
   $element=$element ->getText();
   $text=explode("(",$element);
$text1=explode(")",$text[1]);
 $element1=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-usersvalidtweetsblock']//div[@class='no-tweet-label']"));
  $element2=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-usersvalidtweetsblock']//a[@class='create-tweet']"));
  $element3=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-usersvalidtweetsblock']//a[@class='import-tweet']") );
  $element1=$element1->getText();
  $element2=$element2->getText();
  $element3=$element3->getText();
 if ( $text1[0]==0)
 {
  echo "Then I should see :" ,PHP_EOL;
  echo "Text:" .$element1,PHP_EOL;
  echo "Buttons: " .$element2 ."  &  " .$element3;

 }
else
{
  echo "incorrect result";
}
}

 /**
 * @Then sum of new tweets and tweeted equivalent to valid tweets
 */
public function validnewtweeted(){
$session = $this->getSession();
$val = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[@class='valid_tweets active']//span[@class='value']") );
 $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-usersvalidtweetsblock']//div[@class='valid-tweets-header']//a[1] ") );
   $element=$element ->getText();
    $text=explode("(",$element);
$text1=explode(")",$text[1]);
     $element1 = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-usersvalidtweetsblock']//div[@class='valid-tweets-header']//a[2] ") );
   $element1=$element1 ->getText();
   $val=$val->getText();
   $text2=explode("(",$element1);
   $text3=explode(")",$text2[1]);
   // echo $text1[0],PHP_EOL;
   // echo $text3[0];PHP_EOL;

   $sum=$text1[0]+$text3[0];
   // echo $val;
   if ($sum==$val)
   {
    echo "sum of new tweets and tweeted equivalent to valid tweets";
   }
   else {
    echo "incorrect result";
   }
}


    /**
 * @Then I fetch new valid and invalid tweet
 */
public function fetchnewvalidtweet() {
        
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-usersleftsidebarblock']//div[@class='valid_tweets']//span[2]/b") );
        $element1=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-usersleftsidebarblock']//div[@class='invalid_tweets']//span[2]/b") );
           $newvalid = $element ->getText();
           $newinvalid=$element1 ->getText();
        echo 'New Valid Tweet : ' . $newvalid,PHP_EOL;
        echo 'New Invalid Tweet : ' .$newinvalid;
    if (null === $newinvalid and null == $newinvalid) {
        throw new \Exception('text not found');
    }

    }



/**
 * @Then Valid Tweet incremented
 */
public function validincrementTweet()
{   
  global $validtext;
  global $Totaltweet;
    #$page = $this->getMink()->getSession()->getPage();
       $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[2]//span[2]") );
          $textnew = $element ->getText();
          $validtext++;
           echo 'Valid Tweet after is : '.$textnew,PHP_EOL;
       if ($textnew==$validtext)
      echo 'valid tweet incremented';
    else {
        throw new \Exception('incorrect result');
    }
}

/**
 * @Then Total Tweet incremented
 */
public function totalincrementTweet()

{   
    global $Totaltweet;
          $session = $this->getSession(); // get the mink session
        $element=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[1]//span[2]") );
        $textnew = $element ->getText();
        $Totaltweet++;
      echo 'Total Tweet after is : '.$textnew,PHP_EOL;
    if ($textnew==$Totaltweet)
      echo 'total tweet incremented';
    else {
        throw new \Exception('incorrect result');
    }
}

/**
 * @Then Invalid Tweet incremented
 */
public function invalidincrementTweet()

{   
  global $invalidtext;
  $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[3]//span[2]") );
           $textnew = $element ->getText();
        $invalidtext++;
    echo 'Value after tweet is : '.$textnew ,PHP_EOL;
           if ($textnew==$invalidtext)
      echo 'invalid tweet incremented';
    else {
        throw new \Exception('incorrect result');
    }
}

/**
 * @Then Archived Tweet incremented
 */
public function archivedincrementTweet()

{   
  global $Archived;
  $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[4]//span[2]") );
           $textnew = $element ->getText();
        $Archived++;
    echo 'Value after tweet is : '.$textnew ,PHP_EOL;
           if ($textnew==$Archived)
      echo 'archived tweet incremented';
    else {
        throw new \Exception('incorrect result');
    }
}


/**
 * @Then tweets should get updated after import
 */
public function importvalidTweet()
{   
  global $validtext;
  global $Totaltweet;
  global $invalidtext;
    #$page = $this->getMink()->getSession()->getPage();
       $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[@class='valid_tweets in-active']//span[@class='value']") );
        $element1=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[@class='total_tweets in-active']//span[@class='value']") );
        $element2=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-userstweetsstatisticsblock']//a[@class='invalid_tweets in-active']//span[@class='value']"));
        $textnew = $element ->getText();
        $textnew1= $element1 ->getText();
        $textnew2= $element2->getText();
        $validtext=$validtext+5;
        $Totaltweet=$Totaltweet+7;
        $invalidtext=$invalidtext+2;
    echo 'Valid Tweet after is : '.$textnew,PHP_EOL;
    echo 'Total Tweet after is : '.$textnew1,PHP_EOL;
    echo 'Invalid Tweet after is : '.$textnew2,PHP_EOL;
    if ($textnew==$validtext && $textnew1==$Totaltweet && $textnew2==$invalidtext)
      echo 'tweet incremented';
    else {
        throw new \Exception('incorrect result');
    }
}


/**
* @When /^I should see element with css "([^"]*)"$/
*/
public function find($cssSelector)
{

  $session = $this->getSession(); // get the mink session
  $element = $session->getPage()->find('css', $cssSelector);

  if($element==null){
    throw new \Exception('CSS Element Not found');
  }

}

/**
* @When /^I should see element with xpath "([^"]*)"$/
*/
public function findxpath($xpath)
{

  $session = $this->getSession(); // get the mink session
  $element = $session->getPage()->find('xpath', $xpath);

  if($element==null){
    throw new \Exception(' Element Not found');
  }

}

// /**
// * @When /^I should see 10 tweets with xpath "([^"]*)"$/
// */
// public function maxtweet($xpath)
// {

//   $session = $this->getSession(); // get the mink session
//   $element = $session->getPage()->find('xpath', $xpath);

//   if($element==null){
//     throw new \Exception(' element is on next page');
//   }

// }

/**
* @When /^I should see pagination on css "([^"]*)"$/
*/
public function paginate($el)
{ global $Totaltweet;
  $session = $this->getSession(); // get the mink session
  $element = $session->getPage()->find('css', $el);
 if (($Totaltweet>10)&&($element!=null))
 {
  echo "the pagination is found ";
 }
  else
    throw new \Exception(' Element Not found');
  
  
}


/**
* @When /^element is readonly "([^"]*)"$/
*/
public function readonly($xpath)
{

  $session = $this->getSession(); // get the mink session
  $element = $session->getPage()->find('xpath', $xpath);
  $element=$element->getAttribute('readonly');
   if($element==null)  {
    
    throw new \Exception('Not found');
  }
return $element;
}

// /**
// * @When /^I should see change in colour to red "([^"]*)"$/
// */
// public function colorchange($cssSelector)
// {

//   $session = $this->getSession(); // get the mink session
//   $element = $session->getPage()->find('css', $cssSelector);
//   $element=$element->getAttribute('em');
//   echo $element;
//    if($element==null)  {
    
//     throw new \Exception('Not found');
//   }
// return $element;
// }


/**
 * @Then Total tweet matches with sum of other tweets
 */
public function fetchtweet() {
        
        global $Valid,$Total,$Archived;
        global $Invalid;
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[@class='valid_tweets in-active']//span[@class='value']") );
        $element1=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[@class='total_tweets in-active']//span[@class='value']") );
        $element2=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[@class='invalid_tweets in-active']//span[@class='value']") );
        $element3=$session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', "//div[@id='block-userstweetsstatisticsblock']//a[@class='archived_tweets in-active']//span[@class='value']") );
           $Valid = $element ->getText();
           $Total=$element1 ->getText();
           $Invalid=$element2 ->getText();
           $Archived=$element3 ->getText();
        echo 'Valid Tweet : ' . $Valid,PHP_EOL;
        echo 'Total tweet : ' .$Total,PHP_EOL;
        echo 'Invalid Tweet:' .$Invalid,PHP_EOL;
        echo 'Archived Tweet' .$Archived,PHP_EOL;
        $sum = $Valid+$Invalid+$Archived;
      if($sum==$Total)
        echo 'Total Tweet matched with sum of other tweets';
      else {
        throw new \Exception('not matched');
    }

    }


/**
 * @Then latest created date for Total Tweet is on top
 */
 public function latesttotaltweet(){
$session=$this->getSession();
$elements = array();
for ($i=1;$i<=10;$i++)
{
$element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-usersalltweetsblock']/div/div[2]/ul/li[$i]/div/ul/li[5]"));
$created_date = $element->getText();
// echo $created_date;
$date = date_parse_from_format('d-m-Y', $created_date);
//print_r(date_parse_from_format('d-m-Y', $created_date));
$elements[] = mktime(0, 0, 0, $date['year'], $date['month'], $date['day']);
 }
if($elements[1]==(max($elements)))
echo 'Latest tweet is on top';
else{
throw new \Exception('incorrect result');
}

}

/**
 * @Then latest created date for Valid Tweet is on top
 */
 public function latestvalidtweet(){
  $session=$this->getSession();
  $elements = array();
  for ($i=1;$i<=10;$i++)
    {
    $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-userstweetedtweetsblock']/div/div[3]/ul/li[$i]/div/ul/li[5]"));
      
    $created_date = $element->getText();

 $date = date_parse_from_format('d-m-Y', $created_date);
 $elements[] = mktime(0, 0, 0, $date['year'], $date['month'], $date['day']);
  }
    if($elements[1]==(max($elements)))
 echo 'Latest tweet is on top';
 else{
  throw new \Exception('incorrect result');
 }
 }

 /**
 * @Then latest created date for Invalid Tweet is on top
 */
 public function latestinvalidtweet(){
  $session=$this->getSession();
  $elements = array();
  for ($i=1;$i<=10;$i++)
    {
    $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath',"//div[@id='block-usersinvalidtweetsblock']/div/div[2]/ul/li[1]/div/ul/li[5]"));
      
    $created_date = $element->getText();

 $date = date_parse_from_format('d-m-Y', $created_date);
 $elements[] = mktime(0, 0, 0, $date['year'], $date['month'], $date['day']);
  }
    if($elements[1]==(max($elements)))
 echo 'Latest tweet is on top';
 else{
  throw new \Exception('incorrect result');
 }
 }


/**
     * check for is disabled or not
     *
     * @Then /^I check button is disabled "([^"]*)"$/
     */
    public function isDisabled($xpath)
    {
        $session = $this->getSession();
        $element = $session->getPage()->find('xpath', $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath));

        $element = $element->getAttribute('disabled');    
        if($element==null)  {
          echo "Button is not disabled";}
            else{
              echo "Button is disabled";
            }
    
  
}
    

 /**
    * @When /^I hover over the element by Xpath "([^"]*)"$/
    **/
    public function iHoverOverTheElementbyXpath($xpath){
      $session = $this->getSession(); // get the mink session
      $element = $session->getPage()->find('xpath',$session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)); // runs the actual query and returns the element
      // errors must not pass silently
      if  (null === $element) {
      throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
      }
      // ok, let's hover it
      $element->mouseOver();
    }

    /**
     * Click on the element with the provided CSS Selector
     *
     * @When /^I click on the element with css selector "([^"]*)"$/
     */
    public function iClickOnTheElementWithCSSSelector($cssSelector)
    {
        $session = $this->getSession();
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('css', $cssSelector) // just changed xpath to css
        );
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate CSS Selector: "%s"', $cssSelector));
        }
 
        $element->click();
 
    }

    /** this works with selenium/javascript tags
   * @When /^I hover over the element "([^"]*)"$/
   */
  public function iHoverOverTheElement($locator) {
    $session = $this->getSession(); // get the mink session
    $element = $session->getPage()
      ->find('xpath', $locator); // runs the actual query and returns the element
    // errors must not pass silently
    if (NULL === $element) {
      throw new \InvalidArgumentException(sprintf('Could not evaluate xpath selector: "%s"', $locator));
    }
    // ok, let's hover it
    $element->mouseOver();
  }


  /**
    * @Given /^I set browser window size to "([^"]*)" x "([^"]*)"$/
    */
    public function iSetBrowserWindowSizeToX($width, $height) {
      $this->getSession()->resizeWindow((int)$width, (int)$height, 'current');
    }

/**
 * This works for Selenium and other real browsers that support screenshots.
 *
 * @Then /^show me a screenshot$/
 */
public function show_me_a_screenshot() {

    $image_data = $this->getSession()->getDriver()->getScreenshot();
    $file_and_path = 'D:\Behat\Screenshot\behat_screenshot.jpg';
    file_put_contents($file_and_path, $image_data);

    if (PHP_OS === "Darwin" && PHP_SAPI === "cli") {
        exec('open -a "Preview.app" ' . $file_and_path);
    }

}


/**
 * @Given /^I am logged in as "([^"]*)" with password "([^"]*)"$/
 */
public function iAmLoggedInAsWithPassword($email, $password)
{

  $this->getSession()->getPage()->fillField('edit-name', $email);
  $this->getSession()->getPage()->fillField('edit-pass', $password);
  #$this->getSession()->getPage()->pressButton('Log in');


}



/**
 * @Given I login with valid username and password
 */
public function iAmLoggedInAsuser()
{

  $this->getSession()->getPage()->fillField('edit-name', "nehasingh767@gmail.com");
  $this->getSession()->getPage()->fillField('edit-pass', "Srijan@123");
  $this->getSession()->getPage()->pressButton('Log in');


}



/**
  * @Then I fetch the href of form :FormName
  */
public function iFetchTheHrefOfForm($FormName)
{
  $actualhref = self::iFetchTheHrefOfFormName($FormName);
  echo "The href is: ". $actualhref;
}
/**
      * @Then I fetch the href of form :FormName in :region region
     */
public function iFetchTheHrefOfFormInRegion($FormName, $region)
{
$actualhref = self::iFetchTheHrefOfFormNameInRegion($FormName,$region);
echo "The href is: ". $actualhref;
}
/**
      * @Then I fetch the href of :FormName
      * this method is called to get the href of a particular form
     */
public function iFetchTheHrefOfFormName($FormName)
{ 
  $page = $this->getSession()->getPage();
$actuallink = $page->findLink($FormName);
if ($actuallink === null) {
    throw new Exception("The actuallink was not found!");
    }
return $actuallink->getAttribute('href');
}

public function iFetchTheHrefOfFormNameInRegion($FormName, $region)
{
   $regionObj = $this->getSession()->getPage()->find('region', $region);
   $actuallink = $regionObj->findLink($FormName);
if ($actuallink === null) {
    throw new Exception("The actuallink was not found!");
    }
return $actuallink->getAttribute('href');
}

/**
 * @Then I match the href :href of :FormName
 */
public function iMatchTheHrefOfForm($expectedhref,$FormName)
{    $actualhref = self::iFetchTheHrefOfFormName($FormName);
  //if ($actualhref $expectedhref);
      $pos = strcmp($actualhref, $expectedhref);
    if ($pos != 0) {
      throw new \Exception("Expected href {$expectedhref} not found");
    }
}

/**
 * @Then I match the href :href of form :FormName in :region region
 */
public function iMatchTheHrefOfFormInRegion($expectedhref,$FormName, $region)
{    $actualhref = self::iFetchTheHrefOfFormNameInRegion($FormName, $region);
  $pos = strcmp($actualhref, $expectedhref);
        if ($pos != 0) {
           throw new \Exception("Expected href {$expectedhref} not found");
}
}

// /**
// * @Then I attach the file :path in path :xpath
// */
// public function attachmultiplefile($xpath,$path)
// {
//   // $element = $this->fixStepArgument($element);
//   if ($this->getMinkParameter('files_path')) 
//   {
//         $fullPath = rtrim(realpath($this->getMinkParameter('files_path')), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$path;
//         if (is_file($fullPath)) {
//             $path = $fullPath;
//         }
//     }
  
//   $session = $this->getSession(); // get the mink session
//   $xpath = $session->getPage()->find('xpath', $xpath);
//   $xpath=$xpath->getText();
//   echo $xpath;
//     if (null==$xpath)
//   {
//      throw new Exception("File input is not found");
//   }
//         $xpath->attachFile($file);
// }

 /**
   * @Then I upload the file :path in path :xpath
   */
  public function iUploadTheImage($path,$xpath) {
    // Cannot use the build in MinkExtension function 
    // because the id of the file input field constantly changes and the input field is hidden
    if ($this->getMinkParameter('files_path')) {
      $fullPath = rtrim(realpath($this->getMinkParameter('files_path')), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$path;
      
      if (is_file($fullPath)) {
        $xpath = 'input[type="file"]';
        $field = $this->getSession()->getPage()->find('css', $xpath);

        if (null === $field) {
           throw new Exception("File input is not found");
        }
        $field->attachFile($fullPath);
      }
    }
    else throw new Exception("File is not found at the given location");      
  }


// /**
//  * @Then I check the checkbox with css :css
//  */
// public function RadioButtonWithIdShouldBeChecked($sId)
// {
//     $elementByCss = $this->getSession()->getPage()->find('css',.$sId);

//     $elementByCss->click();

//     if (!$elementByCss) {
//         throw new Exception('elemnent not found');
//     }
// }


/**                                     
 * @Then I wait for :time seconds      
 */                                    
public function iWaitForSeconds($time) 
{                                      
    sleep($time);      
}                                      

    

    }
