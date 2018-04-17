<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use App;
use Debugbar;
use Carbon\Carbon;
use App\Book;

class PracticeController extends Controller
{
    public function practice12()
    {
        #Delete the last two books added to the database.
        $books = Book::orderBy('id', 'decs')->get();
        $i = 0;
        if (!$books) {
            dump('No books found.');
        } else {
            foreach ($books as $book) {
                if ($i > 1) {
                    break;
                }
                $book->delete();
                $i++;
            }
            dump('Last two books added to the database deleted.');
        }

        #Get all books published after 1950
        $books = Book::where('published_year', '>', '1950')->orderBy('published_year')->get();
        if (!$books) {
            dump('No books found published after 1950.');
        } else {
            foreach ($books as $book) {
                dump($book->title . ' | Year: ' . $book->published_year);
            }
        }

        #Display all books in alphabetical order.
        $books = Book::orderBy('title')->get();
        if (!$books) {
            dump('No books found.');
        } else {
            foreach ($books as $book) {
                dump($book->title);
            }
        }

        #Display all books in order of descending published year
        $books = Book::orderBy('published_year', 'desc')->get();
        if (!$books) {
            dump('No books found.');
        } else {
            foreach ($books as $book) {
                dump($book->title . ' | Year: ' . $book->published_year);
            }
        }

        #Delete all books matching the author "J.K. Rowling".
        $books = Book::where('author', 'LIKE', 'J.K. Rowling')->get();
        if (!$books) {
            dump('No books found.');
        } else {
            foreach ($books as $book) {
                $book->delete();
            }
            dump('Deletion complete; check the database to see if it worked...');
        }
    }

    public function practice11()
    {
        $book = Book::where('author', '=', 'F. Scott Fitzgerald')->first();

        if (!$book) {
            dump('Did not delete- Book not found.');
        } else {
            $book->delete();
            dump('Deletion complete; check the database to see if it worked...');
        }
    }

    public function practice10()
    {
        $book = Book::where('author', '=', 'F. Scott Fitzgerald')->first();

        if (!$book) {
            dump("Book not found, can't update.");
        } else {
            $book->title = 'The Really Great Gatsby';
            $book->published_year = '2025';

            $book->save();

            dump('Update complete; check the database to confirm the update worked.');
        }
    }

    public function practice9()
    {
        $books = Book::where('title', 'LIKE', '%Harry Potter%')->get();

        if ($books->isEmpty()) {
            dump('No matches found');
        } else {
            foreach ($books as $book) {
                dump($book->title);
            }
        }
    }

    public function practice8()
    {
        $book = new Book();
        $books = $book->where('title', 'LIKE', '%Harry Potter%')->get();

        if ($books->isEmpty()) {
            dump('No matches found');
        } else {
            foreach ($books as $book) {
                dump($book->title);
            }
        }
    }

    public function practice7()
    {
        $book = new Book();
        $book->title = 'Harry Potter and the Sorcerer\'s Stone';
        $book->author = 'J.K. Rowling';
        $book->published_year = 1997;
        $book->cover_url = 'http://prodimage.images-bn.com/pimages/9780590353427_p0_v1_s484x700.jpg';
        $book->purchase_url = 'http://www.barnesandnoble.com/w/harry-potter-and-the-sorcerers-stone-j-k-rowling/1100036321?ean=9780590353427';
        $book->save();

        dump($book);
    }

    public function practice4()
    {
        $data = ['foo' => 'bar'];
        Debugbar::info($data);
        Debugbar::info('Current environment: '.App::environment());
        Debugbar::error('Error!');
        Debugbar::warning('Watch out…');
        Debugbar::addMessage('Another message', 'mylabel');

        return 'Demoing some of the features of Debugbar';
    }

    /**
     *
     */
     public function practice3()
     {
        echo Config::get('app.supportEmail');
        echo config('app.supportEmail');
        dump(config('database.connections.mysql'));
     }

    /**
     *
     */
    public function practice2()
    {
        dump(['a' => '123', 'b' => '456']);
    }

    /**
     *
     */
    public function practice1()
    {
        dump('This is the first example.');
    }
    /**
     * ANY (GET/POST/PUT/DELETE)
     * /practice/{n?}
     * This method accepts all requests to /practice/ and
     * invokes the appropriate method.
     * http://foobooks.loc/practice/1 => Invokes practice1
     * http://foobooks.loc/practice/5 => Invokes practice5
     * http://foobooks.loc/practice/999 => 404 not found
     */
    public function index($n = null)
    {
        $methods = [];
        # If no specific practice is specified, show index of all available methods
        if (is_null($n)) {
            foreach (get_class_methods($this) as $method) {
                if (strstr($method, 'practice')) {
                    $methods[] = $method;
                }
            }
            return view('practice')->with(['methods' => $methods]);
        } # Otherwise, load the requested method
        else {
            $method = 'practice' . $n;
            return (method_exists($this, $method)) ? $this->$method() : abort(404);
        }
    }
}