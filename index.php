<?php
/**
 * Created by IntelliJ IDEA.
 * User: mland
 * Date: 4/17/15
 * Time: 4:33 PM
 */
require_once __DIR__ . '/vendor/autoload.php';
use Samples\Render;

$dsnBooks = json_encode([
    'category' => 'Young Adult',
    'records' => 5,
    'meta' => [
        'next' => '/whatever?q=345w5',
        'prev' => '/whatever?q=92342'
     ],
    'books' => [
        [
            'title' => 'The Crossover' ,
            'author' => 'Kwame Alexander',
            'publisher' => 'Houghton',
            'price' => '16.99',
            'isbn' => '9780544107717'
        ],
        [
            'title' => 'The Carnival at Bray' ,
            'author' => 'Jessie Ann Foley',
            'publisher' => 'Elephant Rock',
            'price' => '12.95',
            'isbn' => '97809895115597'
        ],
        [
            'title' => 'I\'ll Give You the Sun' ,
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
        [
            'title' => 'The Gospel of Winter' ,
            'author' => 'Brendan Kiely',
            'publisher' => 'Simon & Schuster/Margaret K. McElderry',
            'price' => '17.99',
            'isbn' => '9781442484894'
        ],
    ]
]);

$render = new Render($dsnBooks);
$sortOrder = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : null;
echo $render->toHtml($sortOrder);