<?php
namespace App\Http\Controllers\Pliagiat;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PlagiatEnLocalController extends Controller
{
    public function index()
    {
        return view('pages.plagiat_en_local.plagiat_en_local');
    }
}
