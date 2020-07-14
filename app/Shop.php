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
}
