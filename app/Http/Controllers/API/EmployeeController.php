<?php

namespace App\Http\Controllers\API;

use App\Enums\Statuses;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Employee::select(['dob','city','user_id'])->with(['user' => function ($query) {
            $query->select(
                'id',
                'name',
                'email',
                'status',
                \Illuminate\Support\Facades\DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date')
            );
        },])->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'dob'   => ['required', 'date'],
            'city'   => ['required', 'string', 'min:4', 'max:8'],
            'user_id' => ['required']
        ]);

        if (!$validated->fails()) {
            Employee::create([
                'dob' => $request->input('dob'),
                'city' => $request->input('city'),
                'user_id' => $request->input('user_id'),
                'status' => Statuses::Active
            ]);
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'data' => $validated->getMessageBag()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return response()->json([
            'status' => 'success',
            'data' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'dob'   => ['required', 'date'],
            'city'   => ['required', 'string', 'min:4', 'max:8'],
            'user_id' => ['required']
        ]);

        if (!$validated->fails()) {
            Employee::where('id', $employee->id)->update([
                'dob' => $request->input('dob'),
                'city' => $request->input('city'),
                'user_id' => $request->input('user_id'),
            ]);
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'data' => $validated->getMessageBag()
        ]);
    }

    /**
     * Update the status in storage.
     */
    public function updateStatus(Request $request, Employee $employee)
    {
        $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'status'   => ['required', 'string'],
        ]);

        if (!$validated->fails()) {
            Employee::where('id', $employee->id)->update([
                'status' => $request->input('status') == 'active' ? Statuses::Active : Statuses::Inactive,
            ]);
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'data' => $validated->getMessageBag()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
