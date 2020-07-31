<?php

namespace App\Http\Controllers;

use App\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{

    public function index()
    {
		$bundles = Bundle::all(['name', 'active', 'updated_at', 'created_at']);

        return view('admin/bundles/bundlesMain')->withBundles($bundles);
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
        //
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
