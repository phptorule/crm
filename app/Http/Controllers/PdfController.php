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
use Dompdf\Dompdf;
use Dompdf\Options;


class PdfController extends Controller
{


    public function downloadPdf($post = []){

      $pdf = PDF::loadView('finances.pdf');
      $pdf->download('check.pdf');
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

      $pdf = new Dompdf();
      $pdf->loadHtml(view('pdf', compact('finances', 'team', 'products')));
      $pdf->setBasePath(public_path());
      $pdf->render();
      $pdf->setPaper('A4');
      $name = str_replace ( '/' , '-' , $finances['finances_number'] );
      $pdf->stream("Faktura pro forma Nr ".$name);

    }

}
