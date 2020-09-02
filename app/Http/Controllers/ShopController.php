<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use Vanilo\Category\Models\Taxonomy;
use Vanilo\Category\Models\Taxon;

class ShopController extends Controller
{
    public function index()
    {
        $shops = auth()->user()->shops;

        return view('menos.office.shops_index', [
            'shops' => $shops,
            'title' => 'Mis Tiendas',
            'url' => 'shop'
        ]);
    }

    public function create()
    {
        return view('menos.office.shops_create', [
            'title' => 'Nueva Tienda',
            'url' => 'shop'
        ]);
    }
    
    public function store(Request $request)
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
    
    public function edit($id)
    {
        $shop = Shop::find($id);

        if ($shop->user_id == auth()->user()->id) {
            return view('menos.office.shops_edit', [
                'shop' => $shop,
                'title' => 'Editar Tienda',
                'url' => 'shop'
            ]);
        } else {
            return redirect('/business/shop')->with(['error' => 'No eres el dueño de esta tienda']);
        }
    }

    public function update(Request $request, $id)
    {
        $shop = Shop::find($id);

        if ($shop->user_id == auth()->user()->id) {
            $shop->name = $request->name;
            $shop->status = $request->status;
            $shop->save();

            return redirect('/business/shop')->with(['success' => 'Se ha actualizado la tienda']);
        } else {
            return redirect('/business/shop')->with(['error' => 'Ocurrió un error!']);
        }
    }
}
