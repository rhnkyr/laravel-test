<?php

    namespace Tests\Feature;

    use App\Post;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithFaker;
    use Tests\TestCase;

    class PostsTest extends TestCase
    {

        use RefreshDatabase, WithFaker;

        /** @test */
        public function a_post_can_be_created()
        {

            $data = [
                'user_id' => 1,
                'title'   => $this->faker->sentence,
                'content' => $this->faker->paragraphs(5, true)
            ];

            $this->post(route('posts.store'), $data)
                ->assertStatus(201)
                ->assertJson($data);

        }

        /** @test */
        public function a_post_can_be_updated()
        {

            $post = factory(Post::class)->create();

            $title = $this->faker->sentence;
            $content = $this->faker->paragraphs(3, true);

            $data = [
                'user_id' => 2,
                'title'   => $title,
                'content' => $content
            ];

            $this->put(route('posts.update', $post->id), $data)
                ->assertStatus(200)
                ->assertJson($data);

            $this->assertCount(1, app(Post::class)->all());
            $this->assertEquals(2, app(Post::class)->first()->user_id);
            $this->assertEquals($title, app(Post::class)->first()->title);
            $this->assertEquals($content, app(Post::class)->first()->content);


        }

        /** @test */
        public function a_post_can_be_shown()
        {
            $post = factory(Post::class)->create();

            $this->get(route('posts.show', $post->id))
                ->assertStatus(200)
                ->assertJsonStructure(
                    ['id', 'title', 'content']
                );
        }

        /** @test */
        public function a_post_can_be_deleted()
        {
            $post = factory(Post::class)->create();

            $this->delete(route('posts.destroy', $post->id))
                ->assertStatus(204);
        }

        /** @test */
        public function posts_can_be_listed()
        {

            $posts = factory(Post::class, 2)->create()->map(
                function ($post) {
                    $post->only(['id', 'title', 'content']);
                });

            $this->get(route('posts.index'))
                ->assertStatus(200)
                //->assertJson($posts->toArray())
                ->assertJsonStructure(
                    [
                        '*' => ['id', 'title', 'content'],
                    ]);
        }
    }
