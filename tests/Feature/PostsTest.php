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

            $data = [
                'title'   => $this->faker->sentence,
                'content' => $this->faker->paragraphs(5, true)
            ];

            $this->put(route('posts.update', $post->id), $data)
                ->assertStatus(200)
                ->assertJson($data);


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
