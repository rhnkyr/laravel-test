<?php

    namespace Tests\Feature;

    use App\Post;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithFaker;
    use Tests\TestCase;

    class PostsJsonTest extends TestCase
    {

        use RefreshDatabase, WithFaker;

        /** @test */
        public function a_json_post_can_be_created()
        {

            $data = [
                'title'   => $this->faker->sentence,
                'content' => $this->faker->paragraphs(3, true)
            ];

            $this->json('POST', route('posts-json.store'), $data)
                ->assertStatus(201)
                ->assertExactJson(['created' => true]);

            $this->assertCount(1, app(Post::class)->all());

        }

        /** @test */
        public function a_json_post_can_be_updated()
        {

            $post = factory(Post::class)->create();

            $title = $this->faker->sentence;
            $content = $this->faker->paragraphs(3, true);

            $data = [
                'title'   => $title,
                'content' => $content
            ];

            $this->json('PATCH', route('posts-json.update', $post->id), $data)
                ->assertStatus(200)
                ->assertExactJson(['updated' => true]);

            $this->assertCount(1, app(Post::class)->all());
            $this->assertEquals($title, app(Post::class)->first()->title);
            $this->assertEquals($content, app(Post::class)->first()->content);

        }

        /** @test */
        public function a_json_post_can_be_shown()
        {
            $post = factory(Post::class)->create();

            $this->json('GET', route('posts-json.show', $post->id))
                ->assertStatus(200)
                ->assertJsonStructure(['id', 'title', 'content']);
        }

        /** @test */
        public function a_json_post_can_be_deleted()
        {

            $this->withoutExceptionHandling();

            $post = factory(Post::class)->create();

            $this->json('DELETE', route('posts-json.destroy', $post->id))
                ->assertExactJson(['deleted' => true]);

            $this->assertCount(0, app(Post::class)->all());
        }
    }
