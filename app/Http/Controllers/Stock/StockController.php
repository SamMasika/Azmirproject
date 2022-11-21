<?php

namespace App\Http\Controllers\Stock;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class StockController extends Controller
{
   
    public function index()
    { 
       $URL  = baseUrl().'/stocks';
       
        try{
        
       $stocks  =  Http::withToken(token())->get($URL)->json();
        if ($stocks['success']==false)
        {
            Session::flash('error',''.$stocks['message']);
            $stocks =  ['stocks'=>array()];
        }
         $data  =  $stocks['stocks'];
         
         $URL_ITEM  = baseUrl().'/items';
         $items  =  Http::withToken(token())->get($URL_ITEM)->json();
        if ($items['success']==false)
        {
            Session::flash('error',''.$items['message']);
            $items =  ['items'=>array()];
        }
         $data_item  =  $items['data'];

        return view('stock.stock.index', compact('data','data_item'));
        
        }catch (Throwable $exception){

            Log::error('MAKUNDI WIZARA-ERROR',['MESSAGE'=>$exception]);

            Session::flash('error',' Server error ');

            return redirect('stock-list')->withInput();
        }
    }

  
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $URL  = baseUrl().'/stocks';
    
        // try{
           $result  =  Http::withToken(token())->post($URL,
                [
                    'current_stock'=>$request->current_stock,
                    'status'=>0,
                    'item_id'=>$request->item_id,
                    'price'=>$request->price,
                    // 'price'=>$request->price,
                ]
            );
            $result = json_decode($result);
         
            if (!$result->success=true){
                Session::flash('error',' '.$result['message']);
                return redirect('stock-list')->withInput();
            }

            Session::flash('success',' '.$result->message);
            return redirect('stock-list');
        // }catch (\Throwable $exception){

        //     Log::error('MAKUNDI WIZARA-ERROR',['MESSAGE'=>$exception]);

        //     Session::flash('error',' Server error ');

        //     return redirect('stock-list')->withInput();
        // }
    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

   
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

    public function destroy($id){
        $URL  = baseUrl().'/stocks';
        
        try{
            $result  =  Http::withToken(token())->post($URL,
        [
            'id'=>$id
        ]
        );
           $result = json_decode($result);

           
            // if (!$result->success == true){
            //     Session::flash('error',' '.$result->message);
            //     return redirect('stock-list')->withInput();
            // }

            Session::flash('success',' '.$result->message);
            return redirect('stock-list');
        }catch (\Throwable $exception){

            Log::error('Stock-error',['MESSAGE'=>$exception]);

            Session::flash('error',' Server error ');

            return redirect('stock-list')->withInput();
        }
    }


    public function storeStock($id)
    {
        $URL  = baseUrl().'/stocks/'.$id;
         $stock  =  Http::withToken(token())->get($URL)->json();
       $data=$stock['data'];
        $action      =  request()->input('action', 'add') == 'add' ? 'add' : 'remove';
        $stockAmount =  request()->input('stock', 1);
         $sign        = $action == 'add' ? '+' : '-';

        if ($stockAmount < 1) {
            return redirect()->with([
                'error' => 'No Sale was added/removed. Amount must be greater than 1.',
            ]);
        }

        $URL  = baseUrl().'/sales';
        try{
           $result  =  Http::withToken(token())->post($URL,
                [
                    'stock'    => $sign . $stockAmount,
                     'asset_id' => 1,
                     'user_id' => 2,
                     'item_id' => 1,
                    // 'price'=>$request->price,
                ]
            );
            if ($action == 'add') {
                $data->increment('current_stock', $stockAmount);
                $status = $stockAmount . ' Sale(-s) was added to stock.';
            }
    
            if ($action == 'remove') {
                if ($data->current_stock - $stockAmount < 0) {
                    return redirect('stock-list')->with([
                        'error' => 'Not enough Sales in stock.',
                    ]);
                }
    
                $data->decrement('current_stock', $stockAmount);
                $status = $stockAmount . ' Sale(-s) was removed from stock.';
            }
    
            return redirect('/stock-list')->with([
                'status' => $status,
            ]);
         
            if ($result['success']!=true){
                Session::flash('error',' '.$result['message']);
                return redirect('stock-list')->withInput();
            }

            Session::flash('success',' '.$result['message']);
            return redirect('stock-list');
        }catch (\Throwable $exception){

            Log::error('MAKUNDI WIZARA-ERROR',['MESSAGE'=>$exception]);

            Session::flash('error',' Server error ');

            return redirect('stock-list')->withInput();
        }
    }
}
