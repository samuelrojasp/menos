<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaccion;
use App\Movimiento;
use App\Notificacion;
use Illuminate\Support\Facades\Hash;
use App\Mail\TransferenciaRealizada;
use Illuminate\Support\Facades\Mail;
use App\User;
use Illuminate\Support\Facades\DB;
use Staudenmeir\LaravelCte\Query\Builder;
use App\Prospecto;
use App\Mail\NotifyProspect;
use App\Shop;
use Illuminate\Support\Str;
use Vanilo\Category\Models\Taxonomy;
use Vanilo\Category\Models\Taxon;

class BusinessController extends Controller
{
    public function pricing(Request $request)
    {
        $prospecto = $request->prospecto;

        return view('menos.unete.pricing', [
            'prospecto' => $prospecto
        ]);
    }

    public function checkout(Request $request)
    {
        $cuenta = auth()->user()->cuentas()->first();
        $sponsor = null;

        if($request->prospecto){
            $prospecto = Prospecto::find($request->prospecto);

            $sponsor = $prospecto->sponsor;
        }

        if($cuenta->saldo < 290000){
            return redirect('/shop/index')->with(['error' => 'No dispones de saldo suficiente para unirte a Menos Business.']);
        }

        return view('menos.unete.checkout', [
            'sponsor' => $sponsor
        ]);
    }

    public function userMlmAfiliation(Request $request)
    {
        $user = auth()->user();
        if(!$request->telephone){
            $sponsor = User::where('rut', config('menos.mlm_settings.mlm_top_user'))->first();
        }else{
            $sponsor = User::where('telephone', $request->telephone)->first();
        }

        if(!Hash::check($request->password, $user->password)){
            return redirect()->back()->with(['error' => '¡PIN incorrecto!']);
        }

        $cuenta = $user->cuentas()->first();
        $total = 290000;

        $transaccion = new Transaccion();

        $transaccion->tipo_transaccion_id = 2;
        $transaccion->glosa = "Compra Plan de Afiliado a Business";
        $transaccion->save();

        $movimiento = new Movimiento();

        $movimiento->transaccion_id = $transaccion->id;
        $movimiento->glosa = $transaccion->glosa;
        $movimiento->cuenta_id = $cuenta->id;
        $movimiento->importe = $total * -1;
        $movimiento->saldo_cuenta = $cuenta->saldo - $total;
        $cuenta->saldo = $cuenta->saldo - $total;
        $movimiento->cargo_abono = 'cargo';

        $movimiento->save();
        $cuenta->save();

        $user->sponsor_id = $sponsor->id;
        $user->assignRole('afiliate');
        $user->save();

        $email_recipients = array($user->email);

        Notificacion::create([
            'text' => 'Compraste un plan de Afiliación Business',
            'leido' => 0,
            'user_id' => $user->id
        ]);

        Mail::to($email_recipients)->send(new TransferenciaRealizada($transaccion));

        return view('menos.unete.thankyou', [
            'user' => $user
        ]);
    }

    public function office()
    {
        return view('menos.office.index');
    }

    public function binary()
    {

        return view('menos.office.binaria');
    }

    public function sponsors()
    {

        return view('menos.office.sponsors');
    }

    public function prospects()
    {
        $afiliados = User::role('afiliate')->pluck('email');

        $prospectos = Prospecto::where('sponsor_id', auth()->user()->id)
                            ->whereNotIn('email', $afiliados)
                            ->get();

        return view('menos.office.prospects', [
            'prospectos' => $prospectos
        ]);
    }

    public function apiGetBinaryTreeAfiliates($id)
    {
        $query = DB::table('users')
            ->where('binary_parent_id', $id)
            ->unionAll(
                DB::table('users')
                    ->select('users.*')
                    ->join('tree', 'tree.id', '=', 'users.binary_parent_id')
            );

        $tree = DB::table('tree')
            ->withRecursiveExpression('tree', $query)
            ->pluck('id');
        
        $tree->push($id);
        
        $users_in_subtree = User::whereIn('id', $tree)
                                ->orderBy('binary_side')
                                ->get();

        return $users_in_subtree;
    }

    public function apiGetSponsorTreeAfiliates($id)
    {
        $query = DB::table('users')
            ->where('sponsor_id', $id)
            ->unionAll(
                DB::table('users')
                    ->select('users.*')
                    ->join('tree', 'tree.id', '=', 'users.sponsor_id')
            );

        $tree = DB::table('tree')
            ->withRecursiveExpression('tree', $query)
            ->pluck('id');
        
        $tree->push($id);
        
        $users_in_subtree = User::whereIn('id', $tree)->get();

        return $users_in_subtree;
    }

    public function createProspects()
    {
        return view('menos.office.create_prospects');
    }

    public function storeProspects(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|unique:prospectos|max:255',
            'name' => 'required',
        ]);

        $prospecto = new Prospecto();
        $prospecto->name = $request->name;
        $prospecto->email = $request->email;
        $prospecto->sponsor_id = auth()->user()->id;
        $prospecto->save();

        $sponsor_name = auth()->user()->name;

        $user = User::where('email', $prospecto->email)->first();

        if($user){
            Notificacion::create([
                'text' => "Fuiste invitado por $sponsor_name para afiliarte a Menos Business",
                'leido' => 0,
                'user_id' => $user->id
            ]);
        }

        Mail::to($prospecto->email)->send(new NotifyProspect($prospecto));

        return redirect('/business/prospectos')->with(['success'=>'el usuario ha sido invitado mediante e-mail']);
    }

    public function setBinaryAfiliate()
    {
        $afiliados = User::where('sponsor_id', auth()->user()->id)
                            ->whereNull('binary_parent_id')
                            ->get();

        $query = DB::table('users')
            ->where('binary_parent_id', auth()->user()->id)
            ->unionAll(
                DB::table('users')
                    ->select('users.*')
                    ->join('tree', 'tree.id', '=', 'users.binary_parent_id')
            );

        $tree = DB::table('tree')
            ->withRecursiveExpression('tree', $query)
            ->pluck('id');

        $tree->push(auth()->user()->id);

        $binary_parents = User::whereIn('id', $tree)
                            ->has('binaryChildren', '<', '2')
                            ->get();

        return view('menos.office.set_binary_afiliate', [
            'afiliados' => $afiliados,
            'binary_parents' => $binary_parents
        ]);
    }

    public function apiGetAvailableSides($id)
    {
        $available_sides = array('izquierda', 'derecha');

        $parent = User::find($id);

        $children = $parent->binaryChildren;

        

        if(count($children) > 0){
            unset($available_sides[$children->first()->getRawOriginal('binary_side')]);      
        }
        
        return $available_sides;
    }

    public function updateBinaryAfiliate(Request $request)
    {
        $afiliado = User::find($request->id);
        $afiliado->binary_parent_id = $request->binary_parent_id;
        $afiliado->binary_side = $request->binary_side;
        $afiliado->save();

        Notificacion::create([
            'text' => "Ya puedes operar en menos Business",
            'leido' => 0,
            'user_id' => $afiliado->id
        ]);

        return redirect('/business/office')->with(['success' => 'El usuario ha sido correctamente agreagdo a la red binaria']);
    }

    public function apiPurchasesByUser($id)
    {
        $user = User::find($id);
        
        return $user;
    }


    public function shopIndex()
    {
        $shops = auth()->user()->shops;

        return view('menos.office.shops_index', [
            'shops' => $shops
        ]);
    }

    public function shopCreate()
    {
        return view('menos.office.shops_create');
    }
    
    public function shopStore(Request $request)
    {
        $shop = new Shop();
        $shop->name = $request->name;
        $shop->slug = $slug = Str::slug($request->name, '-');
        $shop->user_id = auth()->user()->id;
        $shop->status = 1;
        $shop->save();

        $taxonomy = Taxonomy::where('slug', 'tienda-afiliado')->first();

        $taxon = Taxon::create([
            'taxonomy_id' => $taxonomy->id,
            'name' => $shop->name,
            'slug' => $shop->slug
        ]);

        return redirect('/business/shop')->with(['success', "Has creado la tienda $shop->name"]);
    }
    
    public function shopEdit($id)
    {
        $shop = Shop::find($id);

        if($shop->user_id == auth()->user()->id){
            return view('menos.office.shops_edit', [
                'shop' => $shop
            ]);
        }else{
            return redirect('/business/shop')->with(['error' => 'No eres el dueño de esta tienda']);
        }
    }

    public function shopUpdate(Request $request, $id)
    {
        $shop = Shop::find($id);

        if($shop->user_id == auth()->user()->id){
            $shop->name = $request->name;
            $shop->status = $request->status;
            $shop->save();

            return redirect('/business/shop')->with(['success' => 'Se ha actualizado la tienda']);
        }else{
            return redirect('/business/shop')->with(['error' => 'Ocurrió un error!']);
        }
    }
}
