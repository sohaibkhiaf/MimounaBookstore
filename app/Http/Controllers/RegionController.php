<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/regions/index', ['regions' => Region::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Region $region)
    {
        return view('admin/regions/edit', ['region' => $region]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Region $region)
    {
        $data = $request->validate([
            'a_domicile' => 'required|integer',
            'stop_desk' => 'required|integer',
        ]);

        $region->update([
            'a_domicile' => $data['a_domicile'],
            'stop_desk' => $data['stop_desk'],
            'enabled' => ! $request->filled('status'),
        ]);

        return to_route('admin.regions')
            ->with('success', __('messages.success_region_updated', ['region_name' => $region->name]));
    }
}
