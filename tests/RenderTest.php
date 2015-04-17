<?php namespace SamplesTest;

/**
 * Created by IntelliJ IDEA.
 * User: mland
 * Date: 4/17/15
 * Time: 11:25 AM
 */

class RenderTest extends \PHPUnit_Framework_Testcase
{
    public function testRenderer()
    {
        $books = [
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
        ];
        $renderObj = new \Samples\Render(json_encode($books));
        $rendering = $renderObj->toHtml();
        //$this->fail($rendering);
    }

    /**
     * reflecting a method, where we have to set the value in the class first
     */
    public function testSortBooksByAuthor()
    {
        $books = [
            [
                'title' => 'Last Book' ,
                'author' => 'Adam Zeta ',
                'publisher' => '',
                'price' => '',
                'isbn' => ''
            ],
            [
                'title' => 'First Book' ,
                'author' => 'Ken Amos ',
                'publisher' => '',
                'price' => '',
                'isbn' => ''
            ],
            [
                'title' => 'Middle Book' ,
                'author' => 'Sam Meta',
                'publisher' => '',
                'price' => '',
                'isbn' => ''
            ],
        ];
        $realClass = new \Samples\Render(json_encode([]));

        $reflectedClass = new \ReflectionClass(
            $realClass
        );

        $reflectedClass->getProperty('books')
            ->setValue($realClass, json_encode($books));

        $sortBooksByAuthorMethod = $reflectedClass->getMethod('sortBooksByAuthor');
        $sortBooksByAuthorMethod->setAccessible(true);
        $sortedBooks = $sortBooksByAuthorMethod->invoke($realClass);
    }

    /**
     * this time written statically/no OO
     * Much easier
     */
    public function testSortBooksByPrice()
    {
        $books = [
            [
                'title' => 'Last Book' ,
                'author' => 'Adam Zeta ',
                'publisher' => '',
                'price' => '',
                'isbn' => ''
            ],
            [
                'title' => 'First Book' ,
                'author' => 'Ken Amos ',
                'publisher' => '',
                'price' => '',
                'isbn' => ''
            ],
            [
                'title' => 'Middle Book' ,
                'author' => 'Sam Meta',
                'publisher' => '',
                'price' => '',
                'isbn' => ''
            ],
        ];
        $realClass = new \Samples\Render(json_encode([]));
        $sortBooksByPriceMethod = new \ReflectionMethod($realClass, 'sortBooksByPrice');
        $sortBooksByPriceMethod->setAccessible(true);
        $sortedBooks = $sortBooksByPriceMethod->invoke($realClass, $books);
    }
}