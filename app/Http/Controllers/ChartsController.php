<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class ChartsController extends Controller
{
    public function processDate(Request $request)
    {
        $date = $request->query('date') ? \DateTime::createFromFormat('Y-m-d', $request->query('date')) :
                                                new \DateTime();
        
        $last_year = \DateTime::createFromFormat('Y-m-d', $date->format('Y-m-d'))
                                ->sub(new \DateInterval('P1Y'));
        
        $result = array(
            'this_year' => $date,
            'last_year' => $last_year,
        );
        
        return $result;
    }

    public function shopSalesByWeekday($user_id, Request $request)
    {
        $user = User::find($user_id);
        $periods = $this->processDate($request);
        
        $result = array(
            'this_year' => $user->getTotalSalesAllShopsByWeekday($periods['this_year']),
            'last_year' => $user->getTotalSalesAllShopsByWeekday($periods['last_year']),
        );

        return $result;
    }

    public function shopSalesByMonthDay($user_id, Request $request)
    {
        $user = User::find($user_id);
        $periods = $this->processDate($request);

        $result = array(
            'this_year' => $user->getTotalSalesAllShopsByMonthDay($periods['this_year']),
            'last_year' => $user->getTotalSalesAllShopsByMonthDay($periods['last_year']),
        );
        
        return $result;
    }

    public function shopSalesByYearMonths($user_id, Request $request)
    {
        $user = User::find($user_id);
        $periods = $this->processDate($request);

        $result = array(
            'this_year' => $user->getTotalSalesAllShopsByYearMonths($periods['this_year']),
            'last_year' => $user->getTotalSalesAllShopsByYearMonths($periods['last_year']),
        );

        return $result;
    }

    public function binaryPurchasesByWeekday($user_id, Request $request)
    {
        $user = User::find($user_id);
        $periods = $this->processDate($request);

        $result = array(
            'this_year' => $user->getDataByTerm($periods['this_year'], 'binary-descendants_purchases_by_weekday'),
            'last_year' => $user->getDataByTerm($periods['last_year'], 'binary-descendants_purchases_by_weekday'),
        );

        return $result;
    }

    public function binaryPurchasesByMonthDays($user_id, Request $request)
    {
        $user = User::find($user_id);
        $periods = $this->processDate($request);

        $result = array(
            'this_year' => $user->getDataByTerm($periods['this_year'], 'binary-descendants_purchases_by_month_days'),
            'last_year' => $user->getDataByTerm($periods['last_year'], 'binary-descendants_purchases_by_month_days')
        );

        return $result;
    }

    public function binaryPurchasesByYearMonths($user_id, Request $request)
    {
        $user = User::find($user_id);
        $periods = $this->processDate($request);

        $result = array(
            'this_year' => $user->getDataByTerm($periods['this_year'], 'binary-descendants_purchases_by_year_months'),
            'last_year' => $user->getDataByTerm($periods['last_year'], 'binary-descendants_purchases_by_year_months'),
        );

        return $result; //relation_data_by_term
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

        if ($left_child) {
            $left_team = $left_child->apiGetBinaryTreeAfiliates();

            foreach ($left_team as $team_member) {
                $teams_stats['left']['member_count'] += 1;
                $teams_stats['left']['total_purchases'] += $team_member->total_purchases;
            }
        }

        if ($right_child) {
            $right_team = $right_child->apiGetBinaryTreeAfiliates();

            foreach ($right_team as $team_member) {
                $teams_stats['right']['member_count'] += 1;
                $teams_stats['right']['total_purchases'] += $team_member->total_purchases;
            }
        }

        return $teams_stats;
    }
}
