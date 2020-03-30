<?php

    namespace App\Http\Controllers;

    use App\Post;
    use Illuminate\Http\Request;

    class PostsJsonController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            //
        }


        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function store(Request $request)
        {
            app(Post::class)->create($request->all());

            return response()->json(['created' => true], 201);
        }

        /**
         * Display the specified resource.
         *
         * @param Post $posts_json
         * @return array
         */
        public function show(Post $posts_json)
        {
            return $posts_json->only('id', 'title', 'content');
        }


        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param Post $posts_json
         * @return \Illuminate\Http\JsonResponse
         */
        public function update(Request $request, Post $posts_json)
        {
            $returns = $posts_json->update($request->all());

            return response()->json(['updated' => $returns]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param Post $posts_json
         * @return \Illuminate\Http\JsonResponse
         * @throws \Exception
         */
        public function destroy(Post $posts_json)
        {

            $returns = $posts_json->delete();

            return response()->json(['deleted' => $returns]);
        }
    }
