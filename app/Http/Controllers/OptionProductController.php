<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

USE Carbon\Carbon;
use App\provider;
use App\product;
use App\option_product;
use App\attribute_product;
use App\buys_product;

class OptionProductController extends Controller
{

    public function __construct(){
        $this->middleware('can:option_products')->only('destroy', 'store', 'update');
        $this->middleware('can:option_products.index')->only('index');
    }

    public function index(Request $request){
        $now=Carbon::now();

        $products=product::all();
        $providers=provider::all();
        $sku_option_products=option_product::all();
        $option_products=option_product::all();
        $buys_products=buys_product::all();
       
        $attribute_products=attribute_product::all();
        $attribute_option_products=attribute_product::all();

        if($request){

            $sku_option_products=option_product::distinct('sku')->select('sku', 'id_vouchers')->get();
            $attribute_option_products=option_product::distinct('id_attribute_products')->select('id_attribute_products')->get();
            
            return view('option_product.index', ['attribute_products'=>$attribute_products, 'attribute_option_products'=>$attribute_option_products, 'option_products'=>$option_products, 'buys_products'=>$buys_products,
                'sku_option_products'=>$sku_option_products, 'products'=>$products, 'providers'=>$providers], ['now' => $now]); 
        }

    }

    public function inputSku(){
        $skuNuevo=option_product::orderBy('id', 'DESC')
        ->take(1)
        ->get();

        echo json_encode($skuNuevo);
    }


    public function destroy($sku){

        $option_products=option_product::all();
        $product=option_product::select('sku')
           ->where('sku',$sku)->firstOrFail();
        
        foreach ($option_products as $option_product){
            option_product::where("sku", $sku) 
            ->delete();
        }

        return back()->with('delete',"Se eliminó el producto SKU: $product->sku correctamente.");
    }

    public function acceder($id){
        $attribute_products=attribute_product::all();

        $array_attributes=array();
        $i=0;

        foreach ($attribute_products as $attribute_product){
            if ($attribute_product->id_products == $id){
                        
                $atributo=$attribute_product->atributo;

                $array_attributes[$i]=($atributo);
                $i++; 
            }
        }
        echo json_encode($array_attributes);
    }

    public function camposActualizar($sku){
        $campos=option_product::select('option_products.id_vouchers','option_products.id_attribute_products',
        'option_products.sku','option_products.opcion','attribute_products.atributo')
        ->where('sku',$sku)
        ->join('attribute_products','option_products.id_attribute_products','=','attribute_products.id')
        ->get();

        $voucher=option_product::select('id_vouchers')
           ->where('sku',$sku)->firstOrFail();

        $id_products=buys_product::select('id_products')
           ->where('id',$voucher->id_vouchers)->firstOrFail();
        
        $productos=attribute_product::where('id_products',$id_products->id_products)->select('atributo')->get();

        $array_3 = array();

        array_push($array_3, $campos);
        array_push($array_3, $productos);

        echo json_encode($array_3);    
    }
    
    public function update($sku, Request $request){
        
        $option_products=option_product::all();
        $attribute_products=attribute_product::all();

        $voucher=option_product::select('id_vouchers')
           ->where('sku',$sku)->firstOrFail();

        $id_prod=buys_product::select('id_products')
           ->where('id',$voucher->id_vouchers)->firstOrFail();

        foreach ($option_products as $option_product){
            option_product::where("sku", $sku) 
            ->delete();
        }

        foreach ($attribute_products as $attribute_product){
            if ($attribute_product->id_products == $id_prod->id_products){
                        
                $atributo=$attribute_product->atributo;
                $id_attribute=$attribute_product->id;
                
                if($atributo === 'valor'){
                    option_product::create([
                        'sku'=>$sku,
                        'id_attribute_products'=>$id_attribute,
                        'id_vouchers'=>$voucher->id_vouchers,
                        'opcion'=>$request->valorAct,
                    ]);
                }

                if($atributo === 'cantidad'){
                    option_product::create([
                        'sku'=>$sku,
                        'id_attribute_products'=>$id_attribute,
                        'id_vouchers'=>$voucher->id_vouchers,
                        'opcion'=>$request->cantidadAct,
                    ]);
                }

                if($atributo === 'modelo'){
                    option_product::create([
                        'sku'=>$sku,
                        'id_attribute_products'=>$id_attribute,
                        'id_vouchers'=>$voucher->id_vouchers,
                        'opcion'=>$request->modeloAct,
                    ]);
                }

                if($atributo === 'cementerio'){
                    option_product::create([
                        'sku'=>$sku,
                        'id_attribute_products'=>$id_attribute,
                        'id_vouchers'=>$voucher->id_vouchers,
                        'opcion'=>$request->cementerioAct,
                    ]);
                }

                if($atributo === 'sector'){
                    option_product::create([
                        'sku'=>$sku,
                        'id_attribute_products'=>$id_attribute,
                        'id_vouchers'=>$voucher->id_vouchers,
                        'opcion'=>$request->sectorAct,
                    ]);
                }

                if($atributo === 'nivel'){
                    option_product::create([
                        'sku'=>$sku,
                        'id_attribute_products'=>$id_attribute,
                        'id_vouchers'=>$voucher->id_vouchers,
                        'opcion'=>$request->nivelAct,
                    ]);
                }
            }
        }

        return back()->with('update',"Se actualizó el producto SKU: $option_product->sku correctamente.");
    }

    public function store(Request $request){
        $attribute_products=attribute_product::all();

        $array_attributes=array();
        $i=0;

        foreach ($attribute_products as $attribute_product){
            if ($attribute_product->id_products == $request->comprobante){
                        
                $atributo=$attribute_product->atributo;
                $id_attribute=$attribute_product->id;
                
                if($atributo === 'valor'){
                    option_product::create([
                        'sku'=>$request->sku,
                        'id_attribute_products'=>$id_attribute,
                        'id_vouchers'=>$request->comprobante,
                        
                        'opcion'=>$request->valor,
                    ]);
                }

                if($atributo === 'cantidad'){
                    option_product::create([
                        'sku'=>$request->sku,
                        'id_attribute_products'=>$id_attribute,
                        'id_vouchers'=>$request->comprobante,
                        
                        'opcion'=>$request->cantidad,
                    ]);
                }

                if($atributo === 'modelo'){
                    option_product::create([
                        'sku'=>$request->sku,
                        'id_attribute_products'=>$id_attribute,
                        'id_vouchers'=>$request->comprobante,
                        
                        'opcion'=>$request->modelo,
                    ]);
                }

                if($atributo === 'cementerio'){
                    option_product::create([
                        'sku'=>$request->sku,
                        'id_attribute_products'=>$id_attribute,
                        'id_vouchers'=>$request->comprobante,
                        
                        'opcion'=>$request->cementerio,
                    ]);
                }

                if($atributo === 'sector'){
                    option_product::create([
                        'sku'=>$request->sku,
                        'id_attribute_products'=>$id_attribute,
                        'id_vouchers'=>$request->comprobante,
                        
                        'opcion'=>$request->sector,
                    ]);
                }

                if($atributo === 'nivel'){
                    option_product::create([
                        'sku'=>$request->sku,
                        'id_attribute_products'=>$id_attribute,
                        'id_vouchers'=>$request->comprobante,
                        
                        'opcion'=>$request->nivel,
                    ]);
                }
            }
        }   
         
        return back()->with('create',"Se registró el producto SKU: $request->sku correctamente.");
    }


    public function create_buys(Request $request){

        $option_products=option_product::all();
        $attribute_products=attribute_product::all();

        buys_product::create([
            'id_products'=>$request->producto,
            'id_providers'=>$request->proveedor,
            'boletaFactura'=>$request->boletaFactura,
            'n_comprobante'=>$request->n_comprobante,
            'fecha_compra'=>$request->fecha_compra,
            'valor_total'=>$request->valorTotal,
            'total_articulos'=>$request->total_articulos,
            'descripcion'=>$request->descripcion,
            'estado'=>'registrada',
        ]);

        return redirect('/option_products'); 
    }

    public function cancel ($id){
        $buys_product=buys_product::findOrFail($id);

        $buys_product->update([
            'estado' => 'Anulada',
        ]);

        //return view('option_product.verCompras');
        return back();
    }


    public function pdf(){
        $buys_products = buys_product::latest()->orderby('id', 'asc')->get();
        $sku_option_products = option_product::distinct('sku')->select('sku','id_vouchers')->get();
        $option_products = option_product::latest()->orderby('id', 'asc')->get();
        $attribute_products = attribute_product::latest()->orderby('id', 'asc')->get();
        $products = product::latest()->orderby('id', 'asc')->get();
        $data = compact('sku_option_products', 'option_products', 'attribute_products', 'products', 'buys_products');

        $pdf = \PDF::loadView('option_product.pdf', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    public function buysproductPdf(){
        $products = product::latest()->orderby('id', 'asc')->get();
        $providers = provider::latest()->orderby('id', 'asc')->get();
        $buys_products = buys_product::latest()->orderby('id', 'asc')->get();

        $data = compact('buys_products', 'products', 'providers');

        $pdf = \PDF::loadView('option_product.buys_product_Pdf', $data);
        return $pdf->setPaper('a4', 'landscape')->stream();
    }

    public function viewBuysProducts(){

        $products=product::all();
        $providers=provider::all();
        $sku_option_products=option_product::all();
        $option_products=option_product::all();
        $buys_products=buys_product::all();
       
        $attribute_products=attribute_product::all();
        $attribute_option_products=attribute_product::all();


        $sku_option_products=option_product::distinct('sku')->select('sku', 'id_vouchers')->get();
        $attribute_option_products=option_product::distinct('id_attribute_products')->select('id_attribute_products')->get();
        
        return view('option_product.verCompras', ['attribute_products'=>$attribute_products, 'attribute_option_products'=>$attribute_option_products, 'option_products'=>$option_products, 'buys_products'=>$buys_products,
           'sku_option_products'=>$sku_option_products, 'products'=>$products, 'providers'=>$providers]); 

            //return back();
        //return view('option_product.verCompras');
    }
}