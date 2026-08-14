<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::latest()
            ->paginate(10);

        return view(
            'admin.notices.index',
            compact('notices')
        );
    }


    public function create()
    {
        return view('admin.notices.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'publish_date' => [
                'nullable',
                'date',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store(
                    'notices',
                    'public'
                );
        }


        Notice::create($validated);


        return redirect()
            ->route('notices.index')
            ->with(
                'success',
                'Notice created successfully.'
            );
    }


    public function show(Notice $notice)
    {
        return view(
            'admin.notices.show',
            compact('notice')
        );
    }


    public function edit(Notice $notice)
    {
        return view(
            'admin.notices.edit',
            compact('notice')
        );
    }


    public function update(
        Request $request,
        Notice $notice
    ) {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'publish_date' => [
                'nullable',
                'date',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        if ($request->hasFile('image')) {

            if (
                $notice->image &&
                Storage::disk('public')
                    ->exists($notice->image)
            ) {
                Storage::disk('public')
                    ->delete($notice->image);
            }


            $validated['image'] = $request
                ->file('image')
                ->store(
                    'notices',
                    'public'
                );
        }


        $notice->update($validated);


        return redirect()
            ->route('notices.index')
            ->with(
                'success',
                'Notice updated successfully.'
            );
    }


    public function destroy(Notice $notice)
    {
        if (
            $notice->image &&
            Storage::disk('public')
                ->exists($notice->image)
        ) {
            Storage::disk('public')
                ->delete($notice->image);
        }


        $notice->delete();


        return redirect()
            ->route('notices.index')
            ->with(
                'success',
                'Notice deleted successfully.'
            );
    }
}