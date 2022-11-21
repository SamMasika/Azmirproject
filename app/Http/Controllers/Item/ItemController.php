<?php

namespace App\Http\Controllers\Item;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
  
    public function index()
    { 
       $URL  = baseUrl().'/items';
       
        try{
        
        $items  =  Http::withToken(token())->get($URL)->json();
        if ($items['success']==false)
        {
            Session::flash('error',''.$items['message']);
            $items =  ['data'=>array()];
        }
       $items  =  $items['data'];

        return view('stock.items.index', compact('items'));
        
        }catch (Throwable $exception){

            Log::error('MAKUNDI WIZARA-ERROR',['MESSAGE'=>$exception]);

            Session::flash('error',' Server error ');

            return redirect('item-list')->withInput();
        }
    }

  
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $URL  = baseUrl().'/items';
        try{
            $result  =  Http::withToken(token())->post($URL,
                [
                    'name'=>$request->name,
                    'price'=>$request->price,
                    // 'price'=>$request->price,
                ]
            );

         
            if ($result['success']!=true){
                Session::flash('error',' '.$result['message']);
                return redirect('item-list')->withInput();
            }

            Session::flash('success',' '.$result['message']);
            return redirect('item-list');
        }catch (\Throwable $exception){

            Log::error('MAKUNDI WIZARA-ERROR',['MESSAGE'=>$exception]);

            Session::flash('error',' Server error ');

            return redirect('item-list')->withInput();
        }
    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $URL  = baseUrl().'/items/'.$id;

        try{
           return $result  =  Http::withToken(token())->post($URL,
                [
                    'name'=>$request->name,
                    'price'=>$request->price,
                    // 'price'=>$request->price,
                ]
            );

         
            if ($result['success']!=true){
                Session::flash('error',' '.$result['message']);
                return redirect('item-list')->withInput();
            }

            Session::flash('success',' '.$result['message']);
            return redirect('item-list');
        }catch (\Throwable $exception){

            Log::error('MAKUNDI WIZARA-ERROR',['MESSAGE'=>$exception]);

            Session::flash('error',' Server error ');

            return redirect('item-list')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
