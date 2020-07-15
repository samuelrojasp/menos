<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class ChartsController extends Controller
{
    public function shopSalesByWeekday($user_id, Request $request)
    {
        $user = User::find($user_id);
        $date = $request->query('date') ? \DateTime::createFromFormat('Y-m-d', $request->query('date')) :
                                                new \DateTime();

        return $user->getTotalSalesAllShopsByWeekday($date);
    }

    public function shopSalesByMonthDay($user_id, Request $request)
    {
        $user = User::find($user_id);
        $date = $request->query('period') ? \DateTime::createFromFormat('Y-m', $request->query('period')) :
                                                new \DateTime();

        return $user->getTotalSalesAllShopsByMonthDay($date);
    }

    public function shopSalesByYearMonths($user_id, Request $request)
    {
        $user = User::find($user_id);
        $date = $request->query('year') ? \DateTime::createFromFormat('Y', $request->query('year')) :
                                                new \DateTime();

        return $user->getTotalSalesAllShopsByYearMonths($date);
    }

    public function binaryPurchasesByWeekday($user_id, Request $request)
    {
        $user = User::find($user_id);
        $date = $request->query('date') ? \DateTime::createFromFormat('Y-m-d', $request->query('date')) : 
                                                new \DateTime();

        return $user->getDataByTerm($date, 'binary-descendants_purchases_by_weekday'); //relation_data_by_term
    }

    public function binaryPurchasesByMonthDays($user_id, Request $request)
    {
        $user = User::find($user_id);
        $date = $request->query('period') ? \DateTime::createFromFormat('Y-m', $request->query('period')) : 
                                                new \DateTime();                                              

        return $user->getDataByTerm($date, 'binary-descendants_purchases_by_month_days'); //relation_data_by_term
    }

    public function binaryPurchasesByYearMonths($user_id, Request $request)
    {
        $user = User::find($user_id);
        $date = $request->query('year') ? \DateTime::createFromFormat('Y', $request->query('year')) : 
                                                new \DateTime();

        return $user->getDataByTerm($date, 'binary-descendants_purchases_by_year_months'); //relation_data_by_term
    }

    public function binaryDataByTeam($user_id, Request $request)
    {
        $user = User::find($user_id);
        $left_team = null;
        $right_team = null;

        $left_child = $user->binaryChildren
                            ->where('sponsor_id', '!=', null)
                            ->where('binary_side', '=', 'izquierda')
                            ->first();
        
        $right_child = $user->binaryChildren
                            ->where('sponsor_id', '!=', null)
                            ->where('binary_side', '=', 'derecha')
                            ->first();

        $teams_stats = [
            'left' => [
                'member_count' => 0,
                'total_purchases' => 0,
            ],
            'right' => [
                'member_count' => 0,
                'total_purchases' => 0,
            ]
        ];

        if($left_child){
            $left_team = $left_child->apiGetBinaryTreeAfiliates();

            foreach($left_team as $team_member){
                $teams_stats['left']['member_count'] += 1;
                $teams_stats['left']['total_purchases'] += $team_member->total_purchases;
            }
        }

        if($right_child){
            $right_team = $right_child->apiGetBinaryTreeAfiliates();

            foreach($right_team as $team_member){
                $teams_stats['right']['member_count'] += 1;
                $teams_stats['right']['total_purchases'] += $team_member->total_purchases;
            }
        }

        return $teams_stats;
    }
}
