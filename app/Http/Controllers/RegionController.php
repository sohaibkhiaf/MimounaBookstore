<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // open regions view
        return view('admin/regions/index' , ['regions' => Region::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Region $region)
    {
        // open edit region view
        return view('admin/regions/edit' , ['region' => $region]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Region $region)
    {
        // validate data
        $data = request()->validate([
            'a_domicile' => 'required|integer',
            'stop_desk' => 'required|integer',
        ]);

        // update region settings
        $region->update([
            'a_domicile' => $data['a_domicile'],
            'stop_desk' => $data['stop_desk'],
            'enabled' => !request()->filled('status'),
        ]);

        if(app()->getLocale() === 'ar'){
            $region_name = $region->ar_name;
        }elseif(app()->getLocale() === 'fr'){
            $region_name = $region->fr_name;
        }else{
            $region_name = $region->en_name;
        }
        // open regions view
        return redirect()->route('admin.regions')
            ->with('success', __('messages.success_region_updated' , ['region_name' => $region_name ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
