<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use PDF;
use App\Finances;
use App\Teams;
use App\Products;
use App\Finances_products;
use App\Task;
use App\TaskList;

class PdfController extends Controller
{


    public function downloadPdf($post = []){
     // dd($post);
		//$post
    	//return $request->finances_id;

    	//return response()->json($post);

    	//return view('finances.pdf');



      //$finances = Finances::find($request->finances_id);

      //$pdf = PDF::loadView('finances.pdf', compact('finances'));
      $pdf = PDF::loadView('finances.pdf');
      //dd($pdf);
      $pdf->download('check.pdf');

      //return redirect()->action('App\Http\Controllers\PdfController@show');
      //return redirect();
      return '';

    }

    public function pdf($id){
      $finances = Finances::where('finances_id',$id)->first();
      $team = Teams::find(session('current_team'));
      $finances_products = Finances_products::where('finances_id', $id)->get();

      $products = [];

      foreach($finances_products as $finances_product){
        $product = Products::find($finances_product->products_id);
        array_push($products, $product);
      }

      echo view('pdf', compact('finances', 'team', 'products'));

      $pdf_url = 'http://crm.da4.info/pdf'.$id;

      $curlconnect = curl_init();
      curl_setopt($curlconnect, CURLOPT_URL, 'http://www.spurdoc.com/api/make?url='.urlencode($pdf_url));
      $result = curl_exec($curlconnect);
      echo $result;

    }

}
