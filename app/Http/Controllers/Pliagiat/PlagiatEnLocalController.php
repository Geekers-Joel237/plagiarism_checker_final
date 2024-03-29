<?php
namespace App\Http\Controllers\Pliagiat;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Caxy\HtmlDiff\HtmlDiff;


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

                return back()->with('source', $content);


            }
        }
    }

    public function traitementLocal(Request $request)
    {

        $media = Media::all();
        //le soucument quon veux examiner est le dernier enregistrement de la bd
        $mediaSource = $media[$media->count() - 1]->filePath;

        $arrayPlagiat = [
            "path_cible" => "",
            "path_source" => "",
            "content" => "",
            "pourcentage" => 0,
            "diff" => "",
        ];

        $arrayPath = array();
        //ce tableau contiendras tout les dossier avec le taux de plagiat le plus grand
        $arrayMaxPlagiat = array();

        //on recupere le path de tout les fichier uploader 
        foreach ($media as $path) {
            array_push($arrayPath, $path->filePath);
        }

        $pdfParser = new \Smalot\PdfParser\Parser();
        //debut du taitement du palgiat local 
        foreach ($arrayPath as $path) {
            //commencon pas calculer le pourcentage de plagiat 
            $pdf = $pdfParser->parseFile("storage/" . $path);
            $content = $pdf->getText();
            $arrayPlagiat["content"] = $content;


            //recuperont le texte de difference entre le document soumis et ceux recuperer
            $htmlDiff = new HtmlDiff($request->content, $content);
            $htmlDiff->getConfig()
                ->setMatchThreshold(80)
                ->setInsertSpaceInReplace(true);
            $arrayPlagiat["diff"] = $htmlDiff->build();
            //comparaison entre les deux texte 
            $comparaison = new \Atomescrochus\StringSimilarities\Compare();
            $score = $comparaison->similarText($request->content, $content);

            $arrayPlagiat["pourcentage"] = $score;

            //recuperation du path source
            $arrayPlagiat["path_cible"] = $path;
            //remplissage du path source 
            $arrayPlagiat["path_source"] = $mediaSource;

            //taille du arraMaxPlagiat
            $taille = count($arrayMaxPlagiat);

           
            for ($i = 0; $i <= $taille; $i++) {
                //on suppose que les 5 premier element du tableaux ont le taux de plagiat le plus grand 
                if (count($arrayMaxPlagiat) < 5) {
                    array_push($arrayMaxPlagiat, $arrayPlagiat);
                } else {
                    foreach ($arrayMaxPlagiat as $key => $element) {
                        if ($arrayPlagiat["pourcentage"] > $element["pourcentage"]) {
                            // $element = $arrayPath;
                            $arrayMaxPlagiat[$key] = $arrayPlagiat;
                        }
                    }

                }
            }
        }

        return back()
            ->with('arrayMaxPlagiat', $arrayMaxPlagiat);
    }
}