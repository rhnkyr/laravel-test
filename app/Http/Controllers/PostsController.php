<?php

    namespace App\Http\Controllers;

    use App\Post;
    use Illuminate\Http\Request;

    class PostsController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            //return app(Post::class)->select('id','title', 'content')->get();
            return app(Post::class)->all();
        }


        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function store(Request $request)
        {
            $post = app(Post::class)->create($request->all());

            return response()->json($post, 201);
        }

        /**
         * Display the specified resource.
         *
         * @param Post $post
         * @return \Illuminate\Http\JsonResponse
         */
        public function show(Post $post)
        {
            return response()->json($post);
        }


        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param Post $post
         * @return \Illuminate\Http\JsonResponse
         */
        public function update(Request $request, Post $post)
        {
            $post->update($request->all());

            return response()->json($post);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param Post $post
         * @return \Illuminate\Http\Response
         * @throws \Exception
         */
        public function destroy(Post $post)
        {
            $post->delete();

            return response()->json([], 204);
        }
    }
