<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Category\Models\Taxonomy;
use App\AssociatedShop;
use Vanilo\Category\Models\Taxon;
use Illuminate\Support\Str;

class AssociatedShopController extends Controller
{
    public function index()
    {
        $shops = auth()->user()->associatedShops;

        return view('menos.office.shops_index', [
            'shops' => $shops,
            'title' => 'Mis Comercios Asociados',
            'url' => 'associated'
        ]);
    }

    public function create()
    {
        return view('menos.office.shops_create', [
            'title' => 'Nuevo Comercio Asociado',
            'url' => 'associated'
        ]);
    }
    
    public function store(Request $request)
    {
        $shop = new AssociatedShop();
        $shop->name = $request->name;
        $shop->slug = $slug = Str::slug($request->name, '-');
        $shop->user_id = auth()->user()->id;
        $shop->status = 1;
        $shop->save();

        $taxonomy = Taxonomy::where('slug', 'comercios-asociados')->first();

        $taxon = Taxon::create([
            'taxonomy_id' => $taxonomy->id,
            'name' => $shop->name,
            'slug' => $shop->slug
        ]);

        return redirect('/business/associated')->with(['success', "Has creado el comercio asociado $shop->name"]);
    }
    
    public function edit($id)
    {
        $shop = AssociatedShop::find($id);

        if($shop->user_id == auth()->user()->id){
            return view('menos.office.shops_edit', [
                'shop' => $shop,
                'title' => 'associated',
                'url' => 'associated'
            ]);
        }else{
            return redirect('/business/shop')->with(['error' => 'No eres el dueño de esta tienda']);
        }
    }

    public function update(Request $request, $id)
    {
        $shop = AssociatedShop::find($id);

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
