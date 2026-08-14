<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeType;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    public function index()
    {
        $feeTypes = FeeType::latest()->get();

        return view(
            'admin.fee-types.index',
            compact('feeTypes')
        );
    }

    public function create()
    {
        return view('admin.fee-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'fee_name' => 'required|unique:fee_types',

            'status' => 'required',

        ]);

        FeeType::create([

            'fee_name' => $request->fee_name,

            'description' => $request->description,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('fee-types.index')
            ->with(
                'success',
                'Fee Type Added Successfully.'
            );
    }

    public function edit(FeeType $feeType)
    {
        return view(
            'admin.fee-types.edit',
            compact('feeType')
        );
    }

    public function update(Request $request, FeeType $feeType)
    {
        $request->validate([

            'fee_name' => 'required|unique:fee_types,fee_name,' . $feeType->id,

            'status' => 'required',

        ]);

        $feeType->update([

            'fee_name' => $request->fee_name,

            'description' => $request->description,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('fee-types.index')
            ->with(
                'success',
                'Fee Type Updated Successfully.'
            );
    }
}