<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        //return response('hello, world!');
        $chirps = Chirp::with('user')->latest()->get();
        return view('chirps.index',compact('chirps'));
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
        $validation = $request->validate([
            'message' => 'required|string|max:255'
        ]);
        $request->user()->chirp()->create($validation);

        return redirect(route('chirps.index'))->with('success','Chrips has been Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        $chirp = Chirp::findOrFail($chirp->id);
        return view('chirps.edit',compact('chirp'));
    }
//->
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $validation = $request->validate([
            'message' => 'required|string|max:255'
        ]);
        $chirp->update($validation);
        return redirect(route('chirps.index'))->with('success', 'Chirp with ' . $chirp->id . ' has been Updated Successfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $chirp->where('id','=',$chirp->id)->delete();
        //$chirp->delete();
        return redirect(route('chirps.index'))->with('success','Chirp has been Deleted Successfully');
    }
}
