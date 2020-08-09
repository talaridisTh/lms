<?php

namespace App\Http\Controllers;

use App\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{

    public function index()
    {
        return view('admin/bundles/bundlesMain');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show(Bundle $bundle)
    {
        return view("admin/bundles/bundle")->withBundle($bundle);
    }


    public function edit(Bundle $bundle)
    {
        //
    }


    public function update(Request $request, Bundle $bundle)
    {
        //
    }


    public function destroy(Bundle $bundle)
    {
        //
    }
}
