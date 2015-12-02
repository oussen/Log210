<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookSearchTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFindBookUPC()
    {
        $user = factory(App\User::class)->Create();

        $this->actingAs($user)
            ->visit('/ajoutDeLivres')
            ->Type('085392246724', 'isbnText')
            ->press('UPC')
            ->assertViewHas('jsonUPC', array('valid'=>'true', 'number'=>'085392246724', 'itemname'=>'Harry Potter And The Sorcerer\'s Stone', 'alias'=>'DVD', 'description'=>'American director Chris Columbus (HOME ALONE) brings the magic of British author J.K. Rowling\'s beloved best-selling fantasy novel to life in HARRY POTTER AND THE SORCERER\'S STONE. Eleven-year-old orphan Harry Potter (Daniel Radcliffe) finds his world turned upside down when he discovers that, like his deceased parents, he is a wizard and has been accepted to Hogwarts School of Witchcraft and Wizardry. With fellow first-year students Hermione Granger (Emma Watson) and Ron Weasley (Rupert Grint) by his side, Harry\'s adventures begin in the rambling castle that is Hogwarts. Vivid special effects make Hogwarts\' magic a reality with paintings that come alive, staircases that move themselves, friendly ghosts, and fast-paced Quidditch (the school sport) matches in which students zoom around on their flying brooms. Mixed in with the miracles of Hogwarts are its dark hidden chambers and secrets, which Harry and his friends encounter as they embark on a quest to keep a treasured powerful object from falling into the wrong hands. Staying true to the book with this film adaptation, Columbus follows Rowling\'s story to the tiniest detail, making it a special treat for readers who were smitten with the novel. Radcliffe is especially engaging as Harry, infusing him with a believable sense of wonderment. The star-studded cast also includes Richard Harris, Maggie Smith, Alan Rickman, and Robbie Coltrane.', 'avg_price'=>'', 'rate_up'=>'0', 'rate_down'=>'0'));
    }

    public function testFindBookEmpty()
    {
        $user = factory(App\User::class)->Create();

        $this->actingAs($user)->visit('/ajoutDeLivres')->press('UPC')->assertViewHas('jsonUPC', array('valid'=>'false', 'reason'=>'No product code entered.'));
    }
}
