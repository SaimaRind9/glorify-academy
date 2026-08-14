<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::all();

        return view('admin.class_rooms.index', compact('classes'));
    }


    public function create()
    {
        return view('admin.class_rooms.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required',
            'description' => 'nullable'
        ]);


        ClassRoom::create([
            'class_name' => $request->class_name,
            'description' => $request->description
        ]);


        return redirect()->route('class-rooms.index')
        ->with('success','Class Added Successfully');
    }


    public function edit(ClassRoom $classRoom)
    {
        return view('admin.class_rooms.edit',
        compact('classRoom'));
    }


    public function update(Request $request, ClassRoom $classRoom)
    {
        $classRoom->update([
            'class_name'=>$request->class_name,
            'description'=>$request->description
        ]);

        return redirect()->route('class-rooms.index');
    }


    public function destroy(ClassRoom $classRoom)
    {
        $classRoom->delete();

        return redirect()->route('class-rooms.index');
    }
}