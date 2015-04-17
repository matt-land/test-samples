<?php namespace SamplesTest;
use Samples\Render;

/**
 * Created by IntelliJ IDEA.
 * User: mland
 * Date: 4/17/15
 * Time: 11:25 AM
 */

class RenderTest extends \PHPUnit_Framework_Testcase
{
    protected $jsonBody;

    public function setUp()
    {
        $this->jsonBody = json_decode(json_encode([
            'category' => 'Young Adult',
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

        $renderObj = new \Samples\Render(json_encode($this->jsonBody));
        $rendering = $renderObj->toHtml();
        //$this->fail($rendering);
    }

    /**
     * reflecting a method, where we have to set the value in the class first
     */
    public function testSortBooksByAuthor()
    {
        $realClass = new \Samples\Render(json_encode(['books'=>null]));

        $reflectedClass = new \ReflectionClass($realClass);

        $booksProperty = $reflectedClass->getProperty('books');
        $booksProperty->setAccessible(1); //make it public


        $booksProperty->setValue($realClass, $this->jsonBody->books);

        $sortBooksByAuthorMethod = $reflectedClass->getMethod('sortBooksByAuthor');
        $sortBooksByAuthorMethod->setAccessible(true);
        $sortedBooks = $sortBooksByAuthorMethod->invoke($realClass);
        $this->assertEquals('Kwame Alexander', $sortedBooks[0]->author);
        $this->assertEquals('William Ritter', $sortedBooks[4]->author);
    }

    /**
     * this time written statically/no OO
     * Much easier
     */
    public function testSortBooksByPrice()
    {
        $realClass = new Render(json_encode(['books'=>null]));
        $sortBooksByPriceMethod = new \ReflectionMethod($realClass, 'sortBooksByPrice');
        $sortBooksByPriceMethod->setAccessible(true);

        $sortedBooks = $sortBooksByPriceMethod->invoke($realClass, $this->jsonBody->books);

        $this->assertEquals(12.95, $sortedBooks[0]->price);
        $this->assertEquals(17.99, $sortedBooks[4]->price);
    }

    public function testSortBooksByISBN()
    {
        $sortedBooks = Render::sortBooksByIsbn($this->jsonBody->books);
        $this->assertEquals('9780544107717', $sortedBooks[0]->isbn);
        $this->assertEquals('9781616203535', $sortedBooks[4]->isbn);

    }
}