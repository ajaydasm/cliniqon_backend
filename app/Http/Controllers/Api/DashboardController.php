<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Project;
use App\Models\Schedule;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function summary(Request $request)
    {
        try {

            $userId = $request->user()->id;

            $data = [
                'total_earnings' => Earning::where('user_id', $userId)->sum('amount'),
                'withdraw_amount' => Withdrawal::where('user_id', $userId)->sum('amount'),
                'total_projects' => Project::where('user_id', $userId)->count(),
                'ongoing_projects' => Project::where('user_id', $userId)->where('status', 'ongoing')->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function monthlyEarnings(Request $request)
    {
        try {

            $userId = $request->user()->id;

            $earnings = Earning::where('user_id', $userId)
                ->select(
                    DB::raw('MONTH(earned_at) as month'),
                    DB::raw('YEAR(earned_at) as year'),
                    DB::raw('SUM(amount) as total')
                )
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            $formatted = $earnings->map(function ($item) {
                return [
                    'month' => date('F', mktime(0, 0, 0, $item->month, 1)),
                    'year' => $item->year,
                    'total' => $item->total,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formatted
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function projects(Request $request)
    {
        try {
            $userId = $request->user()->id;

            $status  = $request->query('status', 'all');
            $perPage = $request->query('per_page', 10);

            $query = Project::where('user_id', $userId)
                ->select(
                    'id',
                    'name',
                    'client',
                    'role',
                    'start_date',
                    'status'
                )
                ->orderBy('start_date', 'desc');

            if ($status !== 'all') {
                $query->where('status', $status);
            }

            $projects = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $projects,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getBalanceChartData(Request $request)
    {
        try {
            $userId = $request->user()->id;

            $totalEarned = Earning::where('user_id', $userId)
                ->sum('amount');

            $totalWithdrawn = Withdrawal::where('user_id', $userId)
                ->sum('amount');

            $balance = $totalEarned - $totalWithdrawn;

            return response()->json([
                'success' => true,
                'data' => [
                    'total_earned' => $totalEarned,
                    'total_withdrawn' => $totalWithdrawn,
                    'balance' => $balance,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function dailySchedule(Request $request)
    {
        try {
            $userId = $request->user()->id;

            $date = $request->query(
                'date',
                Carbon::today()->toDateString()
            );

            $schedules = Schedule::where('user_id', $userId)
                ->whereDate('schedule_date', $date)
                ->orderBy('time')
                ->get([
                    'id',
                    'time',
                    'title',
                    'description',
                    'type'
                ]);

            $schedules = collect([
                [
                    'id' => 1,
                    'time' => '09:00:00',
                    'title' => 'Client Meeting',
                    'description' => 'Design talk client meeting to review the final design',
                    'type' => 'meeting',
                ],
                [
                    'id' => 2,
                    'time' => '10:00:00',
                    'title' => 'Check List',
                    'description' => 'Complete the tasks in the check list',
                    'type' => 'task',
                ],
                [
                    'id' => 3,
                    'time' => '11:30:00',
                    'title' => 'Team Standup',
                    'description' => 'Daily scrum meeting with team',
                    'type' => 'meeting',
                ],
                [
                    'id' => 4,
                    'time' => '12:30:00',
                    'title' => 'Course',
                    'description' => 'Complete the coding design course',
                    'type' => 'reminder',
                ],
            ]);


            return response()->json([
                'success' => true,
                'date' => $date,
                'data' => $schedules
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
