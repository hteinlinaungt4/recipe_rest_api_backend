<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(){
        try {
            // throw new Exception("Error Processing Request", 1);
            return Category::all();
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
