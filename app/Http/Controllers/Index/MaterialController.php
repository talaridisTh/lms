<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{

    public function show(Material $materials)
    {



        return view("index.materials.material-index",compact("materials"));
    }
}
