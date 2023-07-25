<?php

namespace App\Http\Controllers\Pliagiat;
use App\Http\Controllers\Controller;
use App\Models\Score;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $score_recent = Score::latest()->first();
        $score_recent = intval($score_recent->seuil_plagiat);
        return view('pages.settings.settings', compact(
            'score_recent'
        ));
    }

    public function store(Request $request)
    {
        $seuil_plagiat = $request->seuil_plagiat;
        if (!$seuil_plagiat){
            Toastr::error('message', trans("Une Erreur s'est produite !"));
            return back();
        }else{
            try {
                $score = new Score();
                $score->seuil_plagiat = intval($seuil_plagiat);
                $score->save();
                Toastr::success('message', trans('Success : Seuil de plagiat Configuré !'));
                return back();
            }catch (Exception $e){
                Toastr::error('message', trans("Une Erreur s'est produite !"));
                return back();
            }
        }
    }
}
