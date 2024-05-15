<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RecipeController extends Controller
{
    //
    public function index(){
        try {
            // throw new Exception("Error Processing Request", 1);

            return Recipe::Filter(request(['category']))->paginate(6);
        } catch (Exception $e) {
           return response()->json(
            [
                'message' => $e->getMessage(),
                'status' =>  500
            ]
            , 500);
        }
    }

    public function show($id){
        try {
            // throw new Exception("Error Processing Request", 1);
            $recipe =Recipe::find($id);
            if(!$recipe){
                return response()->json([
                    'message' => 'Recipe Not Found',
                    'status' => '404'
                ],404);
            }
            return $recipe;
        } catch (Exception $e) {
           return response()->json(
            [
                'message' => $e->getMessage(),
                'status' =>  500
            ]
            , 500);
        }
    }


    public function destory($id){
        try {
            // throw new Exception("Error Processing Request", 1);
            $recipe =Recipe::find($id);
            if(!$recipe){
                return response()->json([
                    'message' => 'Recipe Not Found',
                    'status' => '404'
                ],404);
            }
            $recipe->delete();
            return $recipe;
        } catch (Exception $e) {
           return response()->json(
            [
                'message' => $e->getMessage(),
                'status' =>  500
            ]
            , 500);
        }
    }

    public function store(){
        try {
            // throw new Exception("Error Processing Request", 1);
            $validator = Validator::make(request()->all(),[
                'title' => 'required',
                'description' => 'required',
                'category_id' => ['required',Rule::exists('categories','id')],
                'photo' => 'required',
            ]);

            if($validator->fails()){
                $flatteredErrors = collect($validator->errors())->flatMap(function($e,$value){
                    return [$value => $e[0]];
                });
                return response()->json([
                    'error' => $flatteredErrors,
                    'status' => 400
                ]
                , 400);
            }
            $recipe =new Recipe();
            $recipe->title = request('title');
            $recipe->description = request('description');
            $recipe->category_id = request('category_id');
            $recipe->photo = request('photo');
            $recipe->save();

            return response()->json([
                $recipe
            ], 201);



        } catch (Exception $e) {
           return response()->json(
            [
                'message' => $e->getMessage(),
                'status' =>  500
            ]
            , 500);
        }
    }

    public function update($id){
        try {
            $recipe =Recipe::find($id);
            if(!$recipe){
                return response()->json([
                    'message' => 'Recipe Not Found',
                    'status' => '404'
                ],404);
            }
            // throw new Exception("Error Processing Request", 1);
            $validator = Validator::make(request()->all(),[
                'title' => 'required',
                'description' => 'required',
                'category_id' => ['required',Rule::exists('categories','id')],
                'photo' => 'required',
            ]);

            if($validator->fails()){
                $flatteredErrors = collect($validator->errors())->flatMap(function($e,$value){
                    return [$value => $e[0]];
                });
                return response()->json([
                    'error' => $flatteredErrors,
                    'status' => 400
                ]
                , 400);
            }
            $recipe->title = request('title');
            $recipe->description = request('description');
            $recipe->category_id = request('category_id');
            $recipe->photo = request('photo');
            $recipe->update();
            return response()->json([$recipe], 201);

        } catch (Exception $e) {
           return response()->json(
            [
                'message' => $e->getMessage(),
                'status' =>  500
            ]
            , 500);
        }
    }


    public function upload(){
        try {

            // throw new Exception("Error Processing Request", 1);
            $validator = Validator::make(request()->all(),[
                'photo' => 'required|image',
            ]);

            if($validator->fails()){
                $flatteredErrors = collect($validator->errors())->flatMap(function($e,$value){
                    return [$value => $e[0]];
                });
                return response()->json([
                    'error' => $flatteredErrors,
                    'status' => 400
                ]
                , 400);
            }
                $path='storage/'.request('photo')->store('/recipes');
            return response()->json([
                'path' => $path,
                'status' => 201
            ], 201);

        } catch (Exception $e) {
           return response()->json(
            [
                'message' => $e->getMessage(),
                'status' =>  500
            ]
            , 500);
        }
    }



}
