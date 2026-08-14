<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\ClassRoom;
use App\Models\FeeChallan;
use App\Models\FeePayment;
use App\Models\Shift;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeReportController extends Controller
{
    public function index(Request $request)
    {
        $query = FeeChallan::with([
            'student.classRoom',
            'student.shift',
            'academicSession',
            'payments'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        if ($request->academic_session_id) {
            $query->where(
                'academic_session_id',
                $request->academic_session_id
            );
        }

        if ($request->month) {
            $query->where(
                'month',
                $request->month
            );
        }

        if ($request->year) {
            $query->where(
                'year',
                $request->year
            );
        }

        if ($request->status) {
            $query->where(
                'status',
                $request->status
            );
        }

        if ($request->class_room_id) {
            $query->whereHas(
                'student',
                function ($q) use ($request) {
                    $q->where(
                        'class_room_id',
                        $request->class_room_id
                    );
                }
            );
        }

        if ($request->shift_id) {
            $query->whereHas(
                'student',
                function ($q) use ($request) {
                    $q->where(
                        'shift_id',
                        $request->shift_id
                    );
                }
            );
        }

        if ($request->student_id) {
            $query->where(
                'student_id',
                $request->student_id
            );
        }

        $challans = $query
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Summary Cards
        |--------------------------------------------------------------------------
        */

        $totalChallans = $challans->count();

        $totalFee = $challans->sum(
            'total_amount'
        );

        $totalPaid = $challans->sum(
            'paid_amount'
        );

        $totalPending =
            $totalFee - $totalPaid;


        $paidCount = $challans
            ->where(
                'status',
                'Paid'
            )
            ->count();

        $partialCount = $challans
            ->where(
                'status',
                'Partial'
            )
            ->count();

        $pendingCount = $challans
            ->where(
                'status',
                'Pending'
            )
            ->count();

        $cancelledCount = $challans
            ->where(
                'status',
                'Cancelled'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Filter Data
        |--------------------------------------------------------------------------
        */

        $academicSessions =
            AcademicSession::orderByDesc('start_date')
                ->get();

        $classes =
            ClassRoom::orderBy('class_name')
                ->get();

        $shifts =
            Shift::orderBy('name')
                ->get();

        $students =
            Student::orderBy('name')
                ->get();


        return view(
            'admin.fee-reports.index',
            compact(
                'challans',
                'totalChallans',
                'totalFee',
                'totalPaid',
                'totalPending',
                'paidCount',
                'partialCount',
                'pendingCount',
                'cancelledCount',
                'academicSessions',
                'classes',
                'shifts',
                'students'
            )
        );
    }


    public function studentHistory(Student $student)
    {
        $student->load([
            'classRoom',
            'shift'
        ]);

        $challans = FeeChallan::with([
            'academicSession',
            'items',
            'payments'
        ])
        ->where(
            'student_id',
            $student->id
        )
        ->orderByDesc('year')
        ->orderByDesc('month')
        ->get();


        $totalFee = $challans->sum(
            'total_amount'
        );

        $totalPaid = $challans->sum(
            'paid_amount'
        );

        $totalPending =
            $totalFee - $totalPaid;


        return view(
            'admin.fee-reports.student-history',
            compact(
                'student',
                'challans',
                'totalFee',
                'totalPaid',
                'totalPending'
            )
        );
    }
}