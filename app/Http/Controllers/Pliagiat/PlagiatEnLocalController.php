<?php

namespace App\Http\Controllers\Pliagiat;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Score;
use Caxy\HtmlDiff\HtmlDiff;
use Brian2694\Toastr\Facades\Toastr;


use Exception;
use Illuminate\Http\Request;

class PlagiatEnLocalController extends Controller
{
    public function index()
    {
        return view('pages.plagiat_en_local.plagiat_en_local');
    }

    public function uploadFile(Request $request)
    {
        $content = "";

        if (!$request->file) {
            Toastr::error('message', trans('libelle ou contenu ou type de requete non soumis'));
            return back();
        }

        try {
            if ($request->file) {
                $file = $request->file;

                /*extraction du texte*/
                $pdfParser = new \Smalot\PdfParser\Parser();
                $pdf = $pdfParser->parseFile($file->path());
                $content = $pdf->getText();

                //sauvegarde du doc en bd
                if ($request->hasFile('file')) {
                    $fileName = time() . '_' . $request->file->getClientOriginalName();
                    $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
                    $extension = $request->file('file')->getClientOriginalExtension();

                    $fileModal = new Media;

                    $fileModal->filePath = $filePath;
                    $fileModal->fileName = $fileName;
                    $fileModal->extension = $extension;

                    $fileModal->save();

                    Toastr::success('message', trans('Success : Soumission du document '));
                    return back()->with('source', $content)->with('path', $filePath);
                }
            }
        } catch (Exception $e) {
            Toastr::error('message', trans('error message.unable_to_save'));
            return back();
        }
    }

    public function traitementLocal(Request $request)
    {
        $seuil = Score::latest()?->first();
        $seuil = intval($seuil?->seuil_plagiat);
        try {
            $media = Media::all();
            //le soucument quon veux examiner est le dernier enregistrement de la bd
            $mediaSource = $media[$media->count() - 1]->filePath;

            $arrayPlagiat = ["path_cible" => "", "path_source" => "", "content" => "", "pourcentage" => 0, "diff" => "",];

            $arrayPath = array();
            //ce tableau contiendras tout les dossier avec le taux de plagiat le plus grand
            $arrayMaxPlagiat = array();

            //on recupere le path de tout les fichier uploader
            foreach ($media as $path) {
                array_push($arrayPath, $path->filePath);
            }


            //sil ya moins de 5 liens
            $pdfParser = new \Smalot\PdfParser\Parser();
            if (count($arrayPath) <= 5) {
                //debut du taitement du palgiat local
                foreach ($arrayPath as $path) {
                    //commencon pas calculer le pourcentage de plagiat
                    $pdf = $pdfParser->parseFile("storage/" . $path);
                    $content = $pdf->getText();
                    $arrayPlagiat["content"] = $content;

                    //recuperont le texte de difference entre le document soumis et ceux recuperer
                    $htmlDiff = new HtmlDiff($request->content, $content);
                    $htmlDiff->getConfig()->setMatchThreshold(80)->setInsertSpaceInReplace(true);
                    $arrayPlagiat["diff"] = $htmlDiff->build();
                    //comparaison entre les deux texte
                    $comparaison = new \Atomescrochus\StringSimilarities\Compare();
                    $score = $comparaison->similarText($request->content, $content);

                    $arrayPlagiat["pourcentage"] = $score;

                    //recuperation du path source
                    $arrayPlagiat["path_cible"] = $path;
                    //remplissage du path source
                    $arrayPlagiat["path_source"] = $mediaSource;

                    array_push($arrayMaxPlagiat, $arrayPlagiat);
                }

                Toastr::success('message', trans('Success : Résultats de la détection disponibles ! '));
                return back()->with('arrayMaxPlagiat', $arrayMaxPlagiat);

            } else {
                $pdfParser = new \Smalot\PdfParser\Parser();
                //debut du taitement du palgiat local
                foreach ($arrayPath as $key => $path) {

                    //commencon pas calculer le pourcentage de plagiat
                    $pdf = $pdfParser->parseFile("storage/" . $path);
                    $content = $pdf->getText();
                    $arrayPlagiat["content"] = $content;


                    //recuperont le texte de difference entre le document soumis et ceux recuperer
                    $htmlDiff = new HtmlDiff($request->content, $content);
                    $htmlDiff->getConfig()->setMatchThreshold(80)->setInsertSpaceInReplace(true);
                    $arrayPlagiat["diff"] = $htmlDiff->build();
                    //comparaison entre les deux texte
                    $comparaison = new \Atomescrochus\StringSimilarities\Compare();
                    $score = $comparaison->similarText($request->content, $content);

                    //dd($score);

                    $arrayPlagiat["pourcentage"] = $score;

                    //recuperation du path source
                    $arrayPlagiat["path_cible"] = $path;
                    //remplissage du path source
                    $arrayPlagiat["path_source"] = $mediaSource;

                    //taille du arraMaxPlagiat
                    //$taille = count($arrayMaxPlagiat);
                    array_push($arrayMaxPlagiat, $arrayPlagiat);
                   /* if (count($arrayMaxPlagiat) < 5) {
                        //array_push($arrayMaxPlagiat, $arrayPlagiat);
                    }*/

                    foreach ($arrayMaxPlagiat as $key => $element) {
                        if ($arrayPlagiat["pourcentage"] > $element["pourcentage"]) {
                            $arrayMaxPlagiat[$key] = $arrayPlagiat;
                            //print($key."\n");
                        }
                    }
                    $arrayMaxPlagiat = array_map("unserialize", array_unique(array_map("serialize", $arrayMaxPlagiat)));

                }

                Toastr::success('message', trans('Success : Résultats de la détection disponibles ! '));
                return back()->with('arrayMaxPlagiat', $arrayMaxPlagiat)->with('seuil',$seuil);

            }
        }catch (Exception $exception){
            Toastr::error('message', trans('Une erreur est survenue !'));
            return back();
        }
    }
}

//https://rapidapi.com/smodin/api/plagiarism-checker-and-auto-citation-generator-multi-lingual
