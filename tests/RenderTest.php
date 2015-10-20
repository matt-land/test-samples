<?php namespace SamplesTest;
use Samples\Render;
use ReflectionClass;
use ReflectionMethod;
use PHPUnit_Framework_TestCase;
/**
 * Created by IntelliJ IDEA.
 * User: mland
 * Date: 4/17/15
 * Time: 11:25 AM
 */
date_default_timezone_set('America/Chicago');
class RenderTest extends PHPUnit_Framework_Testcase
{
    protected $jsonBody;

    /**
     * this is to simulate the json data we feed to the template
     */
    public function setUp()
    {
        $this->jsonBody = json_decode(file_get_contents(__DIR__ . '/pageDataForView.json'));
    }

    public function _testRenderer()
    {
        $renderObj = new Render(json_encode($this->jsonBody));
        $rendering = $renderObj->toHtml();
        $this->fail('This is complex: ' . PHP_EOL . $rendering . " Lets test the methods instead.");
    }

    /**
     * reflecting a method, where we have to set the value in the class first
     */
    public function testSortBooksByAuthor()
    {
        $reflectedClass = new ReflectionClass('\\Samples\\Render');
        $realClass = $reflectedClass->newInstance();

        $booksProperty = $reflectedClass->getProperty('books');                     // $realClass->books (private);
        $booksProperty->setAccessible(1);                                           // $realClass->books (public);
        $booksProperty->setValue($realClass, $this->jsonBody->books);               // $realClass->books = $this->jsonBody->books

        $sortBooksByAuthorMethod = $reflectedClass->getMethod('sortBooksByAuthor'); //$realClass->sortBooksByAuthor() (private)
        $sortBooksByAuthorMethod->setAccessible(true);                              //$realClass->sortBooksByAuthor() (public)
        $sortedBooks = $sortBooksByAuthorMethod->invoke($realClass);                //$realClass->sortBooksByAuthor() __call
        $this->assertEquals('Kwame Alexander', $sortedBooks[0]->author);
        $this->assertEquals('William Ritter', $sortedBooks[4]->author);
    }

    /**
     * this time written statically/no object oriented dependency
     * Much easier
     */
    public function testSortBooksByPrice()
    {
        $realClass = new Render();

        $sortBooksByPriceMethod = new ReflectionMethod($realClass, 'sortBooksByPrice');
        $sortBooksByPriceMethod->setAccessible(true);

        $sortedBooks = $sortBooksByPriceMethod->invoke($realClass, $this->jsonBody->books);

        $this->assertEquals(12.95, $sortedBooks[0]->price);
        $this->assertEquals(17.99, $sortedBooks[4]->price);
    }

    /**
     * the easiest yet. now that its static and public, we can just use it
     */
    public function testSortBooksByISBN()
    {
        $sortedBooks = Render::sortBooksByIsbn($this->jsonBody->books);
        $this->assertEquals('9780544107717', $sortedBooks[0]->isbn);
        $this->assertEquals('9781616203535', $sortedBooks[4]->isbn);
    }

    /**
     * just throw this one in too
     */
    public function testSortBooksByTitle()
    {
        $sortedBooks = Render::sortBooksByTitle($this->jsonBody->books);
        $this->assertEquals('The Carnival at Bray', $sortedBooks[0]->title);
        $this->assertEquals('Jackaby', $sortedBooks[4]->title);
    }
}