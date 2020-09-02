<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Compensation;
use App\Notification;
use Illuminate\Support\Str;

class User extends \Konekt\AppShell\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'is_verified',
        'rut',
        'birthday',
        'address1',
        'address2',
        'city',
        'state',
        'countryid',
        'username'
    ];

    public static $rules = [
        'rut' => 'required|unique:users|cl_rut|max:9',
        'name' => 'required|alpha',
        'telephone' => 'required|alpha',
        'birthdate' => 'required|date',
        'address1' => 'required|alpha',
        'address2' => 'alpha',
        'city' => 'required|alpha',
        'state' => 'required|alpha',
        'countryid' => 'required|alpha',
        'email' => 'required|unique:users|email',
    ];

    public $appends = [
        'total_purchases',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute()
    {
        return avatar_image_url($this, 200);
        
    }

    public function cuentas()
    {
        return $this->hasMany('App\Cuenta');
    }

    public function routeNotificationForWhatsApp()
    {
        return $this->telephone;
    }

    public function addresses()
    {
        return $this->hasMany('App\UserAddress');
    }

    public function notificaciones()
    {
        return $this->hasMany('App\Notificacion');
    }

    public function identificacion()
    {
        return $this->hasMany('App\Identificacion');
    }

    public function getCountryAttribute()
    {
        $country = Country::where('id', $this->countryid)->first();

        return $country;
    }

    public function cuenta_bancaria()
    {
        return $this->hasMany('App\CuentaBancaria');
    }

    public function getFormattedRutAttribute()
    {
        return \Freshwork\ChileanBundle\Rut::parse($this->rut)->format();
    }

    public function sponsor()
    {
        return $this->hasOne('App\User', 'sponsor_id');
    }

    public function binaryParent()
    {
        return $this->hasOne('App\User', 'binary_parent_id');
    }

    public function getBinarySideAttribute($binary_side)
    {
        switch($binary_side){
            case 0:
                return 'izquierda';
            break;
            case 1:
                return 'derecha';
            break;
        }
    }

    public function binaryChildren()
    {
        return $this->hasMany(User::class, 'binary_parent_id');
    }

    public function binaryDescendants()
    {
        $query = DB::table('users')
            ->where('binary_parent_id', $this->id)
            ->unionAll(
                DB::table('users')
                    ->select('users.*')
                    ->join('tree', 'tree.id', '=', 'users.binary_parent_id')
            );

        $tree = DB::table('tree')
            ->withRecursiveExpression('tree', $query)
            ->pluck('id');
        
        
        
        return User::whereIn('id', $tree)
                                ->orderBy('binary_side')
                                ->get();
        
    }

    public function sponsorChildren()
    {
        return $this->hasMany(User::class, 'sponsor_id');
    }

    public function sponsorDescendants()
    {
        return $this->hasMany(User::class, 'sponsor_id')->with('sponsorChildren');
    }

    public function orders()
    {
        return $this->hasMany('Vanilo\Order\Models\Order');
    }

    public function items()
    {
        return $this->hasManyThrough('Vanilo\Order\Models\OrderItem', 'Vanilo\Order\Models\Order');
    }

    public function getTotalPurchasesAttribute()
    {
        return $this->items->where('created_at', '>=', $this->affiliated_at)->sum('price');
    }

    public function getBinarySubTreePurchasesAttribute()
    {
        $query = DB::table('users')
            ->where('binary_parent_id', $this->id)
            ->where('sponsor_id', '!=', null)
            ->unionAll(
                DB::table('users')
                    ->select('users.*')
                    ->join('tree', 'tree.id', '=', 'users.binary_parent_id')
            );

        $tree = DB::table('tree')
            ->withRecursiveExpression('tree', $query)
            ->pluck('id');

        $affiliates = User::whereIn('id', $tree)->get();

        $amount = 0;

        foreach($affiliates as $affiliate){
            $amount += $affiliate->total_purchases;
        }

        return $amount;
    }

    public function apiGetBinaryTreeAfiliates()
    {
        $query = DB::table('users')
            ->where('binary_parent_id', $this->id)
            ->unionAll(
                DB::table('users')
                    ->select('users.*')
                    ->join('tree', 'tree.id', '=', 'users.binary_parent_id')
            );

        $tree = DB::table('tree')
            ->withRecursiveExpression('tree', $query)
            ->pluck('id');
        
        $tree->push($this->id);
        
        $users_in_subtree = User::whereIn('id', $tree)
                                ->orderBy('binary_side')
                                ->get();

        return $users_in_subtree;
    }

    public function binarySubTreeUpToGeneration($level)
    {
        $query = DB::select("with recursive tree (id, lvl) as
                            (
                                (
                                    select id, 1 lvl 
                                    from `users`
                                    where `binary_parent_id` = :parent_id
                                    and `sponsor_id` != 'NULL'
                                ) 
                                union all (
                                    select users.id, tree.lvl + 1 
                                    from tree join `users` on tree.id = `users`.`binary_parent_id`
                                )
                            ) 
                            select id from tree
                            where lvl >= :level
                            order by lvl asc
                            ", [
                                'parent_id' => $this->id,
                                'level' => $level
                            ]);
        
        $results = array();

        foreach($query as $q){
            array_push($results, $q->id);
        }

        return $results;
    }

    public function getSubTreeWithLevels()
    {
        $query = DB::select("with recursive tree (id, lvl) as
                            (
                                (
                                    select id, 1 lvl 
                                    from `users`
                                    where `sponsor_id` = :parent_id
                                    and `sponsor_id` != 'NULL'
                                ) 
                                union all (
                                    select users.id, tree.lvl + 1 
                                    from tree join `users` on tree.id = `users`.`sponsor_id`
                                )
                            ) 
                            select id, lvl from tree
                            
                            order by lvl asc
                            ", [
                                'parent_id' => $this->id,
                            ]);
        
        $results = array();

        foreach($query as $q){
            array_push($results, $q->id);
        }

        $associates = User::whereIn('id', $results)->get();

        foreach($associates as $key => $associate){
            $associate->level = $query[$key]->lvl;
        }

        return $associates;
    }

    public function shops()
    {
        return $this->hasMany('App\Shop');
    }

    public function associatedShops()
    {
        return $this->hasMany('App\AssociatedShop');
    }

    public function iterateBinaryParentsTree(array $method)
    {
        
        if($this->binary_parent_id || $this->rut == config('menos.mlm_settings.mlm_top_user')){
            
            $parent = User::find($this->binary_parent_id);

            foreach($method as $m){
                call_user_func(array($this, $m));
            }
            
            if($this->binary_parent_id){
                $parent->iterateBinaryParentsTree($method);
            } 
        }
    }

    public function getPurchasesByMonth(\DateTime $date)
    {
        $first_datetime = $date->format('Y-m-01 00:00:00');
        $num_days = cal_days_in_month(CAL_GREGORIAN, $date->format('m'), $date->format('Y'));
        $last_datetime = $date->format('Y-m-'.$num_days.' 23:59:59');

        return $this->items
                ->whereBetween('created_at', [$first_datetime, $last_datetime])
                ->sum('price');
        
    }

    public function binaryDescendantsPurchasesByWeekday(\DateTime $date)
    {
        $week = $date ? $date->format('W') : date('W');
        $year = $date ? $date->format('Y') : date('Y');

        $query = DB::table('order_items')
                    ->selectRaw('WEEKDAY(order_items.created_at) as day, sum(order_items.price) as total')
                    ->rightJoin('orders', 'order_items.order_id', '=', 'orders.id')
                    ->rightJoin('users', 'orders.user_id',  '=', 'users.id')
                    ->where('users.id', $this->id)
                    ->whereRaw("WEEKOFYEAR(order_items.created_at) = ?", [$week])
                    ->whereRaw("DATE_FORMAT(order_items.created_at, '%Y') = ?", [$year])
                    ->groupBy('day')
                    ->get();

        $results_by_day = array();

        for($i = 0; $i <= 6; $i++){
            $value = $query->where('day', $i);
            
            $results_by_day[$i] = $value[0]->total ?? 0;
        }

        return $results_by_day;
    }

    public function binaryDescendantsPurchasesByMonthDays(\DateTime $date)
    {
        $period = $date ? $date->format('Y-m') : date('Y-m');

        $days_of_month = date('Y-m') == $period ? date('d') : 
                            cal_days_in_month(CAL_GREGORIAN, $date->format('m'), $date->format('Y'));

        $query = DB::table('order_items')
                    ->selectRaw("DATE_FORMAT(order_items.created_at,'%d') as day, sum(order_items.price) as total")
                    ->rightJoin('orders', 'order_items.order_id', '=', 'orders.id')
                    ->rightJoin('users', 'orders.user_id',  '=', 'users.id')
                    ->where('users.id', $this->id)
                    ->whereRaw("DATE_FORMAT(order_items.created_at, '%Y-%m') = ?", [$period])
                    ->groupBy('day')
                    ->get();
        

        $results_by_day = array();

        for($i = 0; $i <= $days_of_month; $i++){
            $value = $query->where('day', $i);
            
            $results_by_day[$i] = $value[0]->total ?? 0;
        }

        return $results_by_day;
    }

    public function binaryDescendantsPurchasesByYearMonths(\DateTime $date = null)
    {
        $year = $date ? $date->format('Y') : date('Y');

        $months_of_year = date('Y') == $year ? date('Y') : date('n');
        
        $query = DB::table('order_items')
                    ->selectRaw("DATE_FORMAT(order_items.created_at,'%c') as month, sum(order_items.price) as total")
                    ->rightJoin('orders', 'order_items.order_id', '=', 'orders.id')
                    ->rightJoin('users', 'orders.user_id',  '=', 'users.id')
                    ->where('users.id', $this->id)
                    ->whereRaw("DATE_FORMAT(order_items.created_at, '%Y') = ?", [$year])
                    ->groupBy('month')
                    ->get();

        $results = array();

        $counter = 0;        
        
        for($i = 1; $i <= 12; $i++){
            $value = $query->where('month', $i);

            if($value->count() > 0){
                $results[$i] = $value[$counter]->total;

                $counter++;
            }else{
                $results[$i] = 0;
            }
        }

        return $results;
    }



    public function checkCurrentRangeByMlmSales()
    {
        $rangos = config('menos.rangos');

        $rank = [];
        $tree_purchases = $this->binary_sub_tree_purchases;

        foreach($rangos as $rango)
        {
            if($tree_purchases >= $rango['mlm_purchases']){
                $rank = $rango;
            }
        }
        
        $rank = array_merge($rank, array('current_purchases' => $tree_purchases));

        if($rank['name'] != $this->rank){
            $this->updateMlmRank($rank);
        }
    }

    public function updateMlmRank(array $new_rank)
    {
        $this->rank = $new_rank['name'];
        $this->ranked_at = date('Y-m-d H:i');
        $this->save();

        if($this->checkForBonusQualification()){
            $compensacion = Compensation::create([
                'type' => 'bono_rango',
                'name' => $new_rank['name'],
                'user_id' => $this->id,
                'amount' => $new_rank['rank_bonus'],
            ]);

            Notificacion::create([
                'text' => "$this->name , has obtenido el Bono Rango",
                'leido' => 0,
                'user_id' => $this->id
            ]);
        }

        $this->getSuccessBonus();

        Notificacion::create([
            'text' => "$this->name , ya eres ".str_replace('_', ' ', $new_rank['name']),
            'leido' => 0,
            'user_id' => $this->id
        ]);
    }

    public function checkForBonusQualification()
    {
        $rango = config('menos.rangos.'.$this->rank);
        $afiliados = $this->sponsorChildren()->where('rank', $rango['qualify'])->count();

        $qualify = $afiliados >= 2;

        return $qualify;
    }

    public function getSuccessBonus()
    {
        if($this->rank == 'emprendedor' && $this->sponsor->checkForBonusQualification()){
            $compensacion = Compensation::create([
                'type' => 'bono_exito',
                'name' => 'exito',
                'user_id' => $this->sponsor_id,
                'amount' => config('menos.compensations.exito.amount'),
            ]);

            Notificacion::create([
                'text' => $this->sponsor->name." , has obtenido el Bono Éxito",
                'leido' => 0,
                'user_id' => $this->sponsor_id
            ]);
        }
    }

    public function getTeamBonus()
    {
        if(!$this->rank || $this->rank = 'asociado' || !$this->checkForBonusQualification()){
            return false;
        }

        $binary_team_purchases = $this->binary_sub_tree_purchases;
        $comision = $binary_team_purchases * config('menos.compensations.bono_equipo.amount');

        $compensacion = Compensation::create([
            'type' => 'bono_equipo',
            'name' => 'Bono por Equipo',
            'user_id' => $this->id,
            'amount' => $comision,
        ]);

        Notificacion::create([
            'text' => "$this->name , has obtenido el Bono Equipo",
            'leido' => 0,
            'user_id' => $this->id
        ]);

        return $compensacion;
    }

    public function getDirectSalesBonus(\DateTime $date)
    {
        if(!$this->rank || !$this->checkForBonusQualification()){
            return false;
        }

        $monthly_sales = $this->getTotalSalesAllShopsByMonth($date);
        $comision = $monthly_sales * config('menos.compensations.venta_directa.amount');
        $periodo = $date->format('M/y');

        $compensacion = Compensation::create([
            'type' => 'venta_directa',
            'name' => 'Bono por Venta Directa',
            'user_id' => $this->id,
            'amount' => $comision,
        ]);

        Notificacion::create([
            'text' => "$this->name , has obtenido un bono de ".number_format($comision, 0, ',', '.')." por ventas directas en tus e-comerce durante el mes de ".$periodo,
            'leido' => 0,
            'user_id' => $this->id
        ]);

        return $compensacion;
    }

    public function getLeadershipBonus(\DateTime $date)
    {
        if(!$this->rank && !$this->checkForBonusQualification()){
            return false;
        }

        $rank = $this->rank;
        $generation_limit = config("menos.rangos.$rank.leadership_gen");

        $children = User::whereIn('id', $this->binarySubTreeUpToGeneration($generation_limit))
                                        ->get();

        $monthly_purchases = 0;
                                
        foreach($children as $child){
            $monthly_purchases += $child->getPurchasesByMonth($date);
        }

        $comision = $monthly_purchases * config("menos.rangos.$rank.leadership_percentage") / 100;

        $periodo = $date->format('M/y');

        $compensacion = Compensation::create([
            'type' => 'bono_liderazgo',
            'name' => 'Bono por Liderazgo',
            'user_id' => $this->id,
            'amount' => $comision,
        ]);

        Notificacion::create([
            'text' => "$this->name , has obtenido un bono de Liderazgo de $ ".number_format($comision, 0, ',', '.')." por consumo de tu red binaria ".$periodo,
            'leido' => 0,
            'user_id' => $this->id
        ]);

        return $compensacion;
    }

    public function getTotalSalesAllShopsByMonth(\DateTime $date = null)
    {
        $sales = 0;
        
        foreach($this->shops as $shop){
            $sales += $shop->getTotalSalesByMonth($date);
        }

        return $sales;
    }


    public function getTotalSalesAllShopsByWeekday(\DateTime $date = null)
    {
        $result = array(0, 0, 0, 0, 0, 0, 0);
        
        foreach($this->shops as $shop){
            $sales = $shop->getTotalSalesByWeekday($date);
            
            for($i = 0;$i <=6 ; $i++){
                $result[$i] += $sales[$i];
            }
        }

        return $result;
    }

    public function getDataByTerm(\DateTime $date = null, String $method)
    {
        $relations = Str::camel(explode('_', $method)[0]);
        $method = Str::camel($method);

        $result = array();

        

        foreach($this->$relations() as $relation){
            $data = $relation->{$method}($date);
            
            $result = array_map(function (...$arrays) {
                return array_sum($arrays);
            }, $result, $data);
        }

        return $result;
    }

    public function getTotalSalesAllShopsByMonthDay(\DateTime $date = null)
    {
        $result = array();
        
        foreach($this->shops as $shop){
            $sales = $shop->getTotalSalesByMonthDay($date);

            foreach($sales as $key => $val){
                if(isset($result[$key])){
                    $result[$key] = $result[$key] + $val;
                }else{
                    $result[$key] = $val;
                }
                
            }
        }

        return $result;
    }

    public function getTotalSalesAllShopsByYearMonths(\DateTime $date = null)
    {
        $result = array();
        
        foreach($this->shops as $shop){
            $sales = $shop->getTotalSalesByYearMonths($date);

            $result = array_map(function (...$arrays) {
                return array_sum($arrays);
            }, $result, $sales);
        }

        return $result;
    }

    public function compensations()
    {
        return $this->hasMany('App\Compensation');
    }

    public function checkActiveInMLM(\DateTime $date)
    {
        $min_purchases = config("menos.rangos.$this->rank.active");

        if($min_purchases > $this->getPurchasesByMonth($date)){
            dd("estas inactivo");
        }else{
            dd('estas activo');
        }
    }
}
