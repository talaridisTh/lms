<?php

namespace App\Http\Controllers\Ajax;

use App\DataTables\SimpleMaterialsDataTable;
use App\DataTables\SimpleCoursesDataTable;
use App\DataTables\SimpleBundlesDataTable;
use App\Http\Controllers\Controller;
use App\Utility;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
	public function simpleMaterialsDatatable(SimpleMaterialsDataTable $datatable) {
		return $datatable->render('simple.materials.datatable');
	}

	public function simpleCoursesDatatable(SimpleCoursesDataTable $datatable) {
		return $datatable->render('simple.courses.datatable');
	}

	public function simpleBundlesDatatable(SimpleBundlesDataTable $datatable) {
		return $datatable->render('simple.bundles.datatable');
	}

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Utility  $utility
     * @return \Illuminate\Http\Response
     */
    public function show(Utility $utility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Utility  $utility
     * @return \Illuminate\Http\Response
     */
    public function edit(Utility $utility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Utility  $utility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Utility $utility)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Utility  $utility
     * @return \Illuminate\Http\Response
     */
    public function destroy(Utility $utility)
    {
        //
    }
}
