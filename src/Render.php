<?php namespace Samples;
/**
 * Created by IntelliJ IDEA.
 * User: mland
 * Date: 4/17/15
 * Time: 11:19 AM
 */
/**
 * Class Render
 * @package Samples
 * A simple Decorator class
 */
class Render {

    private $pageDataForView;
    private $books;

    public function __construct($jsonString = '[]')
    {
        $this->pageDataForView = json_decode($jsonString);
        $this->books = isset($this->pageDataForView->books) ? $this->pageDataForView->books : null ;
    }

    /**
     * The first method I want to test
     */
    private function sortBooksByAuthor()
    {
        //usort is going to modify $books by reference,
        //so lets copy it to prevent side effects
        $sortedBooks = $this->books;
        usort($sortedBooks, function($a, $b) {
            /**
             * sort by author last name, so first get the last name
             * or last segment of the name. Will not work with JR/III suffixes
             */
            $authorA = explode(" ", trim($a->author));
            $authorB = explode(" ", trim($b->author));

            return strcmp($authorA[count($authorA)-1], $authorB[count($authorB)-1]);
        });

        return $sortedBooks;
    }

    /**
     * @param $books
     * @return mixed
     * The second method I want to test
     */
    private static function sortBooksByPrice($books)
    {
        //usort is going to modify $books by reference,
        //so lets copy it to prevent side effects
        $sortedBooks = $books;
        usort($sortedBooks, function($a, $b) {
            /**
             * compare decimal price
             */
            return $a->price >= $b->price;
        });

        return $sortedBooks;
    }

    /**
     * @param $books
     * @return mixed
     * The third method I want to test
     */
    public static function sortBooksByIsbn($books)
    {
        //usort is going to modify $books by reference,
        //so lets copy it to prevent side effects
        $sortedBooks = $books;
        usort($sortedBooks, function($a, $b) {
            /**
             * sort by ISBN string which might being with zero
             */
            return strcmp($a->isbn, $b->isbn);
        });

        return $sortedBooks;
    }

    public static function sortBooksByTitle($books)
    {
        //usort is going to modify $books by reference,
        //so lets copy it to prevent side effects
        $sortedBooks = $books;
        usort($sortedBooks, function($a, $b) {
            /**
             * remove articles and sort titles
             */
            return strcmp(
                str_ireplace(["a ", "an ", "the "], '', $a->title),
                str_ireplace(["a ", "an ", "the "], '', $b->title)
            );
        });

        return $sortedBooks;
    }

    /**
     * @param string $sortMethod
     * @return string
     * Returns the page as HTML (It does the decorating)
     */
    public function toHtml($sortMethod = 'title')
    {
        $html = '<h1>' . $this->pageDataForView->category . '</h1>';
        switch ($sortMethod) {
            case 'author':
                $sortedBooks = $this->sortBooksByAuthor(); break;
            case 'isbn':
                $sortedBooks = $this->sortBooksByIsbn($this->books); break;
            case 'price':
                $sortedBooks = $this->sortBooksByPrice($this->books); break;
            case 'title':
            default:
                $sortedBooks = $this->sortBooksByTitle($this->books);
        }

        foreach ($sortedBooks as $book) {
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
        $html .='
            <h3>Total Records: ' . $this->pageDataForView->records . '</h3>
            <a href="' . $this->pageDataForView->meta->prev . '">Prev</a>
            <a href="' . $this->pageDataForView->meta->next . '">Next</a>';

        return $html;
    }
}