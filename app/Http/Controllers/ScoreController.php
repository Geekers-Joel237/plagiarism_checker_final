<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Mockery\Exception;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function show(Score $score)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function edit(Score $score)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Score $score)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Score  $score
     * @return \Illuminate\Http\Response
     */
    public function destroy(Score $score)
    {
        //
    }
}
