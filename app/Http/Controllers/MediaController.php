<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Smalot\PdfParser\Parser;
use Caxy\HtmlDiff\HtmlDiff;
use Caxy\HtmlDiff\HtmlDiffConfig;
use PDF;
class MediaController extends Controller
{
    //
    /*ces variable contiendront le contenue des deux pdf soumis*/
    public $contenueFile1;
    public $contenueFile2;

    public function uploadFile(Request $request){

        $content = "";

        if($request->file){
            $file = $request->file;

            $validator = Validator::make($request->all(),[
                'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
            ]);

            /*etape neccesaire pour la recuperation du text dans un pdf*/
            $pdfParser = new \Smalot\PdfParser\Parser();
            $pdf = $pdfParser->parseFile($file->path());
            $content = $pdf->getText();

            $this->contenueFile1 = $content;

            $fileModal = new Media;

            if($request->file()){
                $fileName = time().'_'.$request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
                $extension = $request->file('file')->getClientOriginalExtension();

                $fileModal->filePath = $filePath;
                $fileModal->fileName = $fileName;
                $fileModal->extension = $extension;

                $fileModal->save();

                //apres recuperation du text et enregistrement du fichier 1 passons au 2

                if($request->file2){
                    $file2 = $request->file2;

                    $pdfParser2 = new \Smalot\PdfParser\Parser();
                    $pdf2 = $pdfParser2->parseFile($file2->path());
                    $content2 = $pdf2->getText();
                    $this->contenueFile2 = $content2;
                    return back()
                        ->with('source', $content)
                        ->with('source2', $content2);
                }else{
                    return back()
                        ->with('source', $content)
                        ->with('path', $filePath);
                    //dd("error file2");
                }
            }else{
                dd("Error");
            }
        }else{
            dd("contenue su second text area manquant");
        }
    }

    public function comparePlagiat(Request $request){

        $content1 = $request->source;
        $content2 = $request->source2;


        if(!isset($request->source) || !isset($request->source2)){
            dd('no');
            return back()->with('error','aucun ficher uploader');
        }

        $htmlDiff = new HtmlDiff($content1, $content2);
        $htmlDiff->getConfig()
            ->setMatchThreshold(80)
            ->setInsertSpaceInReplace(true);

        $similarcontent = $htmlDiff->build();

        $comparison = new \Atomescrochus\StringSimilarities\Compare();
        $similar = $comparison->similarText($content1, $content2);

        return back()

        
            ->with('source', $content1)
            ->with('source2', $content2)
            ->with('similarcontent', $similarcontent)
            ->with('score',$similar);

    }

    public function generationRapport(Request $request){
        if(isset($request->scorePlagiat)){

            $data = [
                "title" => "Rapport de plagiat",
                "content" => "ici seras le contenue du pdf",
                "scorePlagiat" => $request->scorePlagiat,
                "source" => $request->source,
                "cible" => $request->cible,
                "Comparaison" => $request->similarcontent
            ];

            $pdf = \PDF::loadView('user.contenueRapport', $data);
            return response($pdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="mon-fichier-pdf.pdf"');

        }else{
            return back()
                ->with('source', $request->source)
                ->with('source2', $request->cible);
        }

    }
}
