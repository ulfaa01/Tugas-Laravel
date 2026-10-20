<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Member;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Book;
use App\Models\Loan;

class RestApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_crud(): void
    {
        // 1. POST
        $createResponse = $this->postJson('/api/members', [
            'name' => 'Siti',
            'email' => 'siti@mail.com',
            'phone' => '081222333',
        ]);
        $createResponse->assertStatus(201)
            ->assertJsonFragment(['name' => 'Siti', 'email' => 'siti@mail.com']);
        $memberId = $createResponse->json('id');

        // 2. GET all
        $listResponse = $this->getJson('/api/members');
        $listResponse->assertStatus(200)
            ->assertJsonCount(1);

        // 3. GET single
        $showResponse = $this->getJson('/api/members/' . $memberId);
        $showResponse->assertStatus(200)
            ->assertJsonFragment(['name' => 'Siti']);

        // 4. PUT update
        $updateResponse = $this->putJson('/api/members/' . $memberId, [
            'name' => 'Siti Rahma',
            'email' => 'siti@mail.com',
            'phone' => '081999888',
        ]);
        $updateResponse->assertStatus(200)
            ->assertJsonFragment(['name' => 'Siti Rahma', 'phone' => '081999888']);

        // 5. DELETE
        $deleteResponse = $this->deleteJson('/api/members/' . $memberId);
        $deleteResponse->assertStatus(204);

        $this->assertDatabaseMissing('members', ['id' => $memberId]);
    }

    public function test_authors_crud(): void
    {
        // 1. POST
        $createResponse = $this->postJson('/api/authors', [
            'name' => 'Tere Liye',
        ]);
        $createResponse->assertStatus(201)
            ->assertJsonFragment(['name' => 'Tere Liye']);
        $authorId = $createResponse->json('id');

        // 2. GET all
        $listResponse = $this->getJson('/api/authors');
        $listResponse->assertStatus(200)
            ->assertJsonCount(1);

        // 3. GET single
        $showResponse = $this->getJson('/api/authors/' . $authorId);
        $showResponse->assertStatus(200)
            ->assertJsonFragment(['name' => 'Tere Liye']);

        // 4. PUT update
        $updateResponse = $this->putJson('/api/authors/' . $authorId, [
            'name' => 'Pramoedya Ananta Toer',
        ]);
        $updateResponse->assertStatus(200)
            ->assertJsonFragment(['name' => 'Pramoedya Ananta Toer']);

        // 5. DELETE
        $deleteResponse = $this->deleteJson('/api/authors/' . $authorId);
        $deleteResponse->assertStatus(204);

        $this->assertDatabaseMissing('authors', ['id' => $authorId]);
    }

    public function test_publishers_crud(): void
    {
        // 1. POST
        $createResponse = $this->postJson('/api/publishers', [
            'name' => 'Gramedia Pustaka Utama',
        ]);
        $createResponse->assertStatus(201)
            ->assertJsonFragment(['name' => 'Gramedia Pustaka Utama']);
        $publisherId = $createResponse->json('id');

        // 2. GET all
        $listResponse = $this->getJson('/api/publishers');
        $listResponse->assertStatus(200)
            ->assertJsonCount(1);

        // 3. GET single
        $showResponse = $this->getJson('/api/publishers/' . $publisherId);
        $showResponse->assertStatus(200)
            ->assertJsonFragment(['name' => 'Gramedia Pustaka Utama']);

        // 4. PUT update
        $updateResponse = $this->putJson('/api/publishers/' . $publisherId, [
            'name' => 'Mizan Publishing',
        ]);
        $updateResponse->assertStatus(200)
            ->assertJsonFragment(['name' => 'Mizan Publishing']);

        // 5. DELETE
        $deleteResponse = $this->deleteJson('/api/publishers/' . $publisherId);
        $deleteResponse->assertStatus(204);

        $this->assertDatabaseMissing('publishers', ['id' => $publisherId]);
    }

    public function test_books_crud(): void
    {
        $author = Author::create(['name' => 'Andrea Hirata']);
        $publisher = Publisher::create(['name' => 'Bentang Pustaka']);

        // 1. POST
        $createResponse = $this->postJson('/api/books', [
            'title' => 'Laskar Pelangi',
            'author_id' => $author->id,
            'publisher_id' => $publisher->id,
        ]);
        $createResponse->assertStatus(201)
            ->assertJsonFragment(['title' => 'Laskar Pelangi']);
        $bookId = $createResponse->json('id');

        // 2. GET all
        $listResponse = $this->getJson('/api/books');
        $listResponse->assertStatus(200)
            ->assertJsonCount(1);

        // 3. GET single
        $showResponse = $this->getJson('/api/books/' . $bookId);
        $showResponse->assertStatus(200)
            ->assertJsonFragment(['title' => 'Laskar Pelangi']);

        // 4. PUT update
        $updateResponse = $this->putJson('/api/books/' . $bookId, [
            'title' => 'Sang Pemimpi',
            'author_id' => $author->id,
            'publisher_id' => $publisher->id,
        ]);
        $updateResponse->assertStatus(200)
            ->assertJsonFragment(['title' => 'Sang Pemimpi']);

        // 5. DELETE
        $deleteResponse = $this->deleteJson('/api/books/' . $bookId);
        $deleteResponse->assertStatus(204);

        $this->assertDatabaseMissing('books', ['id' => $bookId]);
    }

    public function test_loans_crud(): void
    {
        $author = Author::create(['name' => 'Andrea Hirata']);
        $publisher = Publisher::create(['name' => 'Bentang Pustaka']);
        $book = Book::create([
            'title' => 'Laskar Pelangi',
            'author_id' => $author->id,
            'publisher_id' => $publisher->id,
        ]);
        $member = Member::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@mail.com',
            'phone' => '08123456789',
        ]);

        // 1. POST
        $createResponse = $this->postJson('/api/loans', [
            'member_id' => $member->id,
            'book_id' => $book->id,
            'loan_date' => '2026-10-20',
            'return_date' => '2026-10-27',
        ]);
        $createResponse->assertStatus(201)
            ->assertJsonFragment(['member_id' => $member->id, 'book_id' => $book->id]);
        $loanId = $createResponse->json('id');

        // 2. GET all
        $listResponse = $this->getJson('/api/loans');
        $listResponse->assertStatus(200)
            ->assertJsonCount(1);

        // 3. GET single
        $showResponse = $this->getJson('/api/loans/' . $loanId);
        $showResponse->assertStatus(200)
            ->assertJsonFragment(['id' => $loanId]);

        // 4. PUT update
        $updateResponse = $this->putJson('/api/loans/' . $loanId, [
            'member_id' => $member->id,
            'book_id' => $book->id,
            'loan_date' => '2026-10-20',
            'return_date' => '2026-10-30',
        ]);
        $updateResponse->assertStatus(200)
            ->assertJsonFragment(['return_date' => '2026-10-30T00:00:00.000000Z']);

        // 5. DELETE
        $deleteResponse = $this->deleteJson('/api/loans/' . $loanId);
        $deleteResponse->assertStatus(204);

        $this->assertDatabaseMissing('loans', ['id' => $loanId]);
    }
}
