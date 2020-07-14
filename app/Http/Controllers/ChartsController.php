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

        $date = $request->query('date') ? \DateTime::createFromFormat('Y-m-d', $request->query('date')) : new \DateTime();

        return $user->getTotalSalesAllShopsByWeekday($date);
    }

    public function shopSalesByMonthDay($user_id, Request $request)
    {
        $user = User::find($user_id);
        $date = $request->query('period') ? \DateTime::createFromFormat('Y-m', $request->query('period')) : new \DateTime();

        return $user->getTotalSalesAllShopsByMonthDay($date);
    }

    public function shopSalesByYearMonths($user_id, Request $request)
    {
        $user = User::find($user_id);
        $date = $request->query('year') ? \DateTime::createFromFormat('Y', $request->query('year')) :
                                                             new \DateTime();

        return $user->getTotalSalesAllShopsByYearMonths($date);
    }
}
