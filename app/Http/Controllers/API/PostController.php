<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    public function index()
    {
        $post = Post::all();
        $data = [
            'post' => $post,
        ];


        return $this->sendResponse($post, 'All Post Data');
    }

    public function store(Request $request)
    {

        $validateUser = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg,gif',
            ]
        );

        if ($validateUser->fails()) {
            // return response()->json([
            //     'status' => false,
            //     'message' => 'Validation Error',
            //     'errors' => $validateUser->errors()
            // ], 401);

            return $this->sendError('Validation Error', $validateUser->errors()->all());
        }

        $img = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imagName = time() . '' . $ext;
        $img->move(public_path() . '/uploads', $imagName);

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagName,
        ]);

        $data = [
            'post' => $post
        ];

        return $this->sendResponse($post, 'Post created successfully');
    }

    public function show(string $id)
    {
        $post = Post::select('id', 'title', 'description', 'image')->where(['id' => $id])->get();

        $data = [
            'post' => $post
        ];

        return $this->sendResponse($post, 'your single data');
    }


    public function update(Request $request, string $id)
    {

        $validateUser = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg,gif',
            ]
        );

        if ($validateUser->fails()) {
            return $this->sendError('Validation Error', $validateUser->errors()->all());
        }

        $postImage = Post::select('id', 'image')->where('id', $id)->first();

        if ($request->image != '') {
            $path = public_path() . '/uploads';
            if ($postImage->image != '' && $postImage->image != null) {
                $old_file = $path . $postImage->image;
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }
            $img = $request->image;
            $ext = $img->getClientOriginalExtension();
            $imagName = time() . '' . $ext;
            $img->move(public_path() . '/uploads', $imagName);
        } else {
            $imagName = $postImage->image;
        }



        $post = Post::where(['id' => $id])->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagName,
        ]);

        $data = [
            'post' => $post
        ];

        return $this->sendResponse($post, 'Post Updated Successfully');
    }


    public function destroy(string $id)
    {

        $imagPath = Post::select('image')->where('id', $id)->get();
        $filePath = public_path() . '/uploads/' . $imagPath[0]['image'];


        $post = Post::where('id', $id)->delete();


        unlink($filePath);

        return $this->sendResponse($post, 'Post Delete Successfully');
    }
}
