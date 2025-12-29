<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Project;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use DB;


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
}
