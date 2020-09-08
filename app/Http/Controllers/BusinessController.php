<?php

namespace App\Http\Controllers;

use App\Movimiento;
use App\Notificacion;
use App\Prospecto;
use App\Transaccion;
use App\User;
use App\Mail\NotifyProspect;
use App\Mail\TransferenciaRealizada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Staudenmeir\LaravelCte\Query\Builder;

class BusinessController extends Controller
{
    private $subscription_value;

    public function __construct()
    {
        $configuration = \App\Configuration::where('key', 'valor_menos_business')->first();
        $this->subscription_value = $configuration->value;
    }

    public function pricing(Request $request)
    {
        $prospecto = $request->prospecto;

        return view('menos.unete.pricing', [
            'prospecto' => $prospecto,
            'subscription_value' => $this->subscription_value
        ]);
    }

    public function checkout(Request $request)
    {
        $cuenta = auth()->user()->cuentas()->first();
        $sponsor = null;

        if ($request->prospecto) {
            $prospecto = Prospecto::find($request->prospecto);

            $sponsor = $prospecto->sponsor;
        }

        if ($cuenta->saldo < $this->subscription_value) {
            return redirect('/shop/index')->with(['error' => 'No dispones de saldo suficiente para unirte a Menos Business.']);
        }

        return view('menos.unete.checkout', [
            'sponsor' => $sponsor,
            'subscription_value' => $this->subscription_value
        ]);
    }

    public function userMlmAfiliation(Request $request)
    {
        $user = auth()->user();
        if (!$request->telephone) {
            $sponsor = User::where('rut', config('menos.mlm_settings.mlm_top_user'))->first();
        } else {
            $sponsor = User::where('telephone', $request->telephone)->first();
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with(['error' => '¡PIN incorrecto!']);
        }

        $cuenta_cobro = $user->cuentas()->where('tipo_cuenta_id', 1)->first();
        $cuenta_abono_puntos = $user->cuentas()->where('tipo_cuenta_id', 3)->first();
        $cuenta_abono_comision = $sponsor->cuentas()->where('tipo_cuenta_id', 1)->first();

        $total = $this->subscription_value;
        $comision = round($total * 0.25);

        $transaccion = new Transaccion();

        $transaccion->tipo_transaccion_id = 2;
        $transaccion->glosa = "Compra Plan de Afiliado a Business";
        $transaccion->verified_at = date('Y-m-d H:i:s');
        $transaccion->save();

        $movimiento = new Movimiento();

        $movimiento->transaccion_id = $transaccion->id;
        $movimiento->glosa = $transaccion->glosa;
        $movimiento->cuenta_id = $cuenta_cobro->id;
        $movimiento->importe = $total * -1;
        $movimiento->saldo_cuenta = $cuenta_cobro->saldo - $total;
        $cuenta_cobro->saldo = $cuenta_cobro->saldo - $total;
        $movimiento->cargo_abono = 'cargo';

        $movimiento->save();
        $cuenta_cobro->save();

        $user->sponsor_id = $sponsor->id;
        if (!$user->hasRole('afiliate')) {
            $user->assignRole('afiliate');
            $user->save();
        }

        $transaccion_abono_puntos = new Transaccion();

        $transaccion_abono_puntos->tipo_transaccion_id = 8;
        $transaccion_abono_puntos->glosa = "Abono a cuenta de consumo";
        $transaccion_abono_puntos->verified_at = date('Y-m-d H:i:s');
        $transaccion_abono_puntos->save();

        $movimiento_abono_puntos = new Movimiento();

        $movimiento_abono_puntos->transaccion_id = $transaccion->id;
        $movimiento_abono_puntos->glosa = $transaccion->glosa;
        $movimiento_abono_puntos->cuenta_id = $cuenta_abono_puntos->id;
        $movimiento_abono_puntos->importe = $comision;
        $movimiento_abono_puntos->saldo_cuenta = $cuenta_abono_puntos->saldo + $comision;
        $cuenta_abono_puntos->saldo = $cuenta_abono_puntos->saldo + $comision;
        $movimiento_abono_puntos->cargo_abono = 'cargo';

        $movimiento_abono_puntos->save();
        $cuenta_abono_puntos->save();

        $transaccion_abono_comision = new Transaccion();

        $transaccion_abono_comision->tipo_transaccion_id = 8;
        $transaccion_abono_comision->glosa = "Abono a cuenta de consumo";
        $transaccion_abono_comision->verified_at = date('Y-m-d H:i:s');
        $transaccion_abono_comision->save();

        $movimiento_abono_comision = new Movimiento();

        $movimiento_abono_comision->transaccion_id = $transaccion->id;
        $movimiento_abono_comision->glosa = $transaccion->glosa;
        $movimiento_abono_comision->cuenta_id = $cuenta_abono_comision->id;
        $movimiento_abono_comision->importe = $comision;
        $movimiento_abono_comision->saldo_cuenta = $cuenta_abono_comision->saldo + $comision;
        $cuenta_abono_comision->saldo = $cuenta_abono_comision->saldo + $comision;
        $movimiento_abono_comision->cargo_abono = 'cargo';

        $movimiento_abono_comision->save();
        $cuenta_abono_comision->save();

        // $user->sponsor_id = $sponsor->id;
        // $user->assignRole('afiliate');
        // $user->save();


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
        $associates = auth()->user()->getSubTreeWithLevels();

        $niveles = $associates->groupBy('level');

        $resumen = array();

        for ($i = 1; $i <= count($niveles); $i++) {
            $resumen[$i] = [
                'level' => $i,
                'qty' => count($associates->where('level', $i)),
                'purchases' => $associates->where('level', $i)->sum('total_purchases')
            ];
        }

        return view('menos.office.index', [
            'resumen' => $resumen
        ]);
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

        if ($user) {
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

        

        if (count($children) > 0) {
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
}
