<?php

namespace App\Http\Controllers;

use App\PaymentBill;
use PDF;
use Illuminate\Http\Request;


class PDFController extends Controller
{
    //
    public function generatePDF($type, $id)
    {
        if($type === "service"){
            try{
                $bill = PaymentBill::findOrFail($id);
            } catch (\Exception $e){

            }

        }

//        $data = ['title' => 'Welcome to HDTuto.com'];
////        $pdf = PDF::loadView('pdf.service_bill', $data);
////
////        return $pdf->download('itsolutionstuff.pdf');
    return view('pdf.service_bill');
    }
}
