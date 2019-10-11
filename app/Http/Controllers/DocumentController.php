<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(){
        $documents = Document::all();
        return response()->json(['message' => 'OK', 'data' => $documents], 200);
    }
}
