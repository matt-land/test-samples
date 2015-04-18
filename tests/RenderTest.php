<?php namespace SamplesTest;
use Samples\Render;
use ReflectionClass;
use ReflectionMethod;
/**
 * Created by IntelliJ IDEA.
 * User: mland
 * Date: 4/17/15
 * Time: 11:25 AM
 */

class RenderTest extends \PHPUnit_Framework_Testcase
{
    protected $jsonBody;

    /**
     * this is to simulate the json data we feed to the template
     */
    public function setUp()
    {
        $this->jsonBody = json_decode(json_encode([
            'category' => 'Young Adult',
            'records' => 5,
            'meta' => [
                'next' => '/whatever?q=345w5',
                'prev' => '/whatever?q=92342'
            ],
            'books' => [
                [
                    'title' => 'The Carnival at Bray' ,
                    'author' => 'Jessie Ann Foley',
                    'publisher' => 'Elephant Rock',
                    'price' => '12.95',
                    'isbn' => '97809895115597'
                ],
                [
                    'title' => 'The Crossover' ,
                    'author' => 'Kwame Alexander',
                    'publisher' => 'Houghton',
                    'price' => '16.99',
                    'isbn' => '9780544107717'
                ],
                [
                    'title' => 'The Gospel of Winter' ,
                    'author' => 'Brendan Kiely',
                    'publisher' => 'Simon & Schuster/Margaret K. McElderry',
                    'price' => '17.99',
                    'isbn' => '9781442484894'
                ],
                [
                    'title' => 'I’ll Give You the Sun' ,
                    'author' => 'Jandy Nelson',
                    'publisher' => 'Dial',
                    'price' => '17.99',
                    'isbn' => '9780803734968'
                ],
                [
                    'title' => 'Jackaby' ,
                    'author' => 'William Ritter',
                    'publisher' => 'William Ritter',
                    'price' => '16.95',
                    'isbn' => '9781616203535'
                ],
            ]
        ]));
    }

    public function _testRenderer()
    {
        $renderObj = new Render(json_encode($this->jsonBody));
        $rendering = $renderObj->toHtml();
        $this->fail('This is complex: ' . PHP_EOL . $rendering);
    }

    /**
     * reflecting a method, where we have to set the value in the class first
     */
    public function testSortBooksByAuthor()
    {
        $realClass = new Render();

        $reflectedClass = new ReflectionClass($realClass);

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