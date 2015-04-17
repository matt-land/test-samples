<?php namespace Samples;
/**
 * Created by IntelliJ IDEA.
 * User: mland
 * Date: 4/17/15
 * Time: 11:19 AM
 */

class Render {

    private $data;
    private $books;

    public function __construct($jsonString)
    {
        $this->data = json_decode($jsonString);
        $this->books = $this->data->books;
    }

    public function toHtml()
    {
        $html = '<h1>' . $this->data->category . '</h1>';
        foreach ($this->sortBooksByAuthor() as $book) {
            $html .=
            '<div id="' . $book->isbn . '" clas="book">' . PHP_EOL
                . '<ul>' . PHP_EOL
                    . '<li class="title">' . $book->title.'</li>' . PHP_EOL
                    . '<li>By ' . $book->author . '</li>' . PHP_EOL
                    . '<li>ISBN ' . $book->isbn . '</li>' . PHP_EOL
                    . '<li>Price $' . $book->price . '</li>' . PHP_EOL
                    . '<li>Publisher ' . $book->publisher . '</li>' . PHP_EOL
                . '</ul>' . PHP_EOL
            . '</div>' . PHP_EOL;
        }

        return $html;
    }

    private function sortBooksByAuthor()
    {
        $sortedBooks = $this->books;
        usort($sortedBooks, function($a, $b) {
            $authorA = explode(" ", trim($a->author));
            $authorB = explode(" ", trim($b->author));

            return strcmp($authorA[count($authorA)-1], $authorB[count($authorB)-1]);
        });
        return $sortedBooks;
    }

    private static function sortBooksByPrice($books)
    {
        //usort is going to modify $books by reference,
        //so lets copy it to prevent side effects
        $sortedBooks = $books;
        usort($sortedBooks, function($a, $b) {
            return $a->price >= $b->price;
        });
        return $sortedBooks;
    }

}