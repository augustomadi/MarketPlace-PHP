<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFormRequest;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct(private Store $store)
    {
       
    }
    
    public function index(){
        
        // $stores = Store::findOrFail(20);
        
        $stores = $this->store->paginate(10);
        return view('admin.stores.index', compact('stores'));
    }
    
    public function create()
    {
        return view('admin.stores.create');
    }
    
    public function store(StoreFormRequest $request){

        auth()->user->store()->create($request->all());

        return redirect()->route('admin.stores.index');


        // $store = new Store();
    
        // $store->name = 'Loja exemplo 2';
        // $store->description = 'Descriçao da Loja';
        // $store->about = 'Contexto da loja';
        // $store->phone = '+55985762654';
        // $store->whatsapp = '+55985762654';

        // $store->save();
        
        // dump($store);

        // $store = Store::findOrFail(7);
        // $store->name = 'Loja exemplo 2 editando...';
        // $store->description = 'Descriçao da Loja';
        // $store->about = 'Contexto da loja';
        // $store->phone = '+55985762654';
        // $store->whatsapp = '+55985762654';

        // $store->save();
        
        // dump($store);


        //Create: Mass Assignment


        // dump($store);

        // $store = Store::FindOrFail(7);
        // $store -> Store::create([    
        //     'name' => 'Loja exemplo 2 Editando...',
        // ]);
    
        // dump($store);


        // Delete 

        // $store = Store::findOrFail(9);
        // $store->delete();

        // dump($store);
    }

    public function edit(string $store)
    {
        $store = $this->store->findOrFail($store);

        return view('admin.stores.edit', compact('store'));
    }

    public function update(string $store, StoreFormRequest $request){
        $store = $this->store->findOrFail($store);

        $store->update($request->all());

        return redirect()->back();
    }

    public function destroy(string $store){
        $store = Store::findOrFail($store);
        $store->delete();

        return redirect()->back();
    }

}
