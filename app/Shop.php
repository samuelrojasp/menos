<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Taxon;
use Illuminate\Support\Facades\DB;
use \DateTime;

class Shop extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function taxon()
    {
        return $this->belongsTo('Vanilo\Category\Models\Taxon', 'slug', 'slug');
    }

    public function getVentasTotalesAttribute()
    {
        $taxon = Taxon::where('slug', $this->slug)->first();
        
        $order_items_ids = DB::table('model_taxons')
                                    ->select("model_id")
                                    ->whereRaw("model_type = 'App\\\OrderItem' and taxon_id = ?", [$taxon->id])
                                    ->get()
                                    ->pluck('model_id');
        
        $order_items_sum = DB::table('order_items')
                                ->whereIn('id', $order_items_ids)
                                ->sum('price');
 
        return $order_items_sum;
    }

    public function getTotalSalesByMonth(DateTime $date = null)
    {
        $period = $date ? $date->format('m-Y') : date('m-Y');

        $taxon = Taxon::where('slug', $this->slug)->first();
        
        $order_items_ids = DB::table('model_taxons')
                                    ->select("model_id")
                                    ->whereRaw("model_type = 'App\\\OrderItem' and taxon_id = ?", [$taxon->id])
                                    ->get()
                                    ->pluck('model_id');
        
        $order_items_sum = DB::table('order_items')
                                ->whereIn('id', $order_items_ids)
                                ->whereRaw("DATE_FORMAT(created_at, '%m-%Y') = ?", [$period])
                                ->sum('price');
 
        return $order_items_sum;
    }

    public function getTotalSalesByWeekday(DateTime $date = null)
    {
        $week = $date ? $date->format('W') : date('W');
        $year = $date ? $date->format('Y') : date('Y');

        $taxon = Taxon::where('slug', $this->slug)->first();
        
        $order_items_ids = DB::table('model_taxons')
                                    ->select("model_id")
                                    ->whereRaw("model_type = 'App\\\OrderItem' and taxon_id = ?", [$taxon->id])
                                    ->get()
                                    ->pluck('model_id');
        
        $order_items_by_weekday = DB::table('order_items')
                                    ->selectRaw('WEEKDAY(created_at) as day, sum(price) as total')
                                    ->whereIn('id', $order_items_ids)
                                    ->whereRaw("WEEKOFYEAR(created_at) = ?", [$week])
                                    ->whereRaw("DATE_FORMAT(created_at, '%Y') = ?", [$year])
                                    ->groupByRaw('day')
                                    ->get();
         
        $results_by_day = array();
        
        for($i = 0; $i <= 6; $i++){
            $value = $order_items_by_weekday->where('day', $i);
            
            $results_by_day[$i] = $value[0]->total ?? 0;
        }

        return $results_by_day;
    }

    public function getTotalSalesByMonthDay(DateTime $date = null)
    {
        $period = $date ? $date->format('Y-m') : date('Y-m');

        $days_of_month = date('Y-m') == $period ? date('d') : 
                            cal_days_in_month(CAL_GREGORIAN, $date->format('m'), $date->format('Y'));

        $taxon = Taxon::where('slug', $this->slug)->first();
        
        $order_items_ids = DB::table('model_taxons')
                                    ->select("model_id")
                                    ->whereRaw("model_type = 'App\\\OrderItem' and taxon_id = ?", [$taxon->id])
                                    ->get()
                                    ->pluck('model_id');
        
        $order_items_by_month_day = DB::table('order_items')
                                    ->selectRaw("DATE_FORMAT(created_at,'%d') as day, sum(price) as total")
                                    ->whereIn('id', $order_items_ids)
                                    ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$period])
                                    ->groupByRaw("DATE_FORMAT(created_at,'%d')")
                                    ->get();
        
        $results_by_day = array();
        $counter = 0;
        
        for($i = 1; $i <= $days_of_month; $i++){

            $value = $order_items_by_month_day->where('day', $i);

            if($value->count() > 0){
                $results_by_day[$i] = $value[$counter]->total;

                $counter++;
            }else{
                $results_by_day[$i] = 0;
            }
        }

        return $results_by_day;
    }

    public function getTotalSalesByYearMonths(DateTime $date = null)
    {
        $year = $date ? $date->format('Y') : date('Y');

        $months_of_year = date('Y') == $year ? date('Y') : date('n');

        $taxon = Taxon::where('slug', $this->slug)->first();
        
        $order_items_ids = DB::table('model_taxons')
                                    ->select("model_id")
                                    ->whereRaw("model_type = 'App\\\OrderItem' and taxon_id = ?", [$taxon->id])
                                    ->get()
                                    ->pluck('model_id');
        
        $order_items_by_year_month = DB::table('order_items')
                                    ->selectRaw("DATE_FORMAT(created_at,'%c') as month, sum(price) as total")
                                    ->whereIn('id', $order_items_ids)
                                    ->whereRaw("DATE_FORMAT(created_at, '%Y') = ?", [$year])
                                    ->groupByRaw("DATE_FORMAT(created_at,'%c')")
                                    ->get();

        $results_by_month = array();
        
        for($i = 1; $i <= 12; $i++){
            $value = $order_items_by_year_month->where('month', $i);
            
            $results_by_month[$i] = $value[0]->total ?? 0;
        }

        return $results_by_month;
    }
}
