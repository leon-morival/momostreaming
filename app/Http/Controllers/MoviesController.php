<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
class MoviesController extends Controller
{
  
public function index(){
    $genresJsonPath = resource_path('json/genres.json');
    $genres = json_decode(File::get($genresJsonPath), true);
    return view("movies", ["genres"=> $genres]);
}


}
