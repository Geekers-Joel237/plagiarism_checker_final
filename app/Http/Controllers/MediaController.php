<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Score;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Smalot\PdfParser\Parser;
use Caxy\HtmlDiff\HtmlDiff;
use Caxy\HtmlDiff\HtmlDiffConfig;
use PDF;
use Brian2694\Toastr\Facades\Toastr;

class MediaController extends Controller
{
    //
    /*ces variable contiendront le contenue des deux pdf soumis*/
    public $contenueFile1;
    public $contenueFile2;

    public function uploadFile(Request $request)
    {

        $content = "";

        if ($request->file) {
            $file = $request->file;

            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048',
            ]);

            /*etape neccesaire pour la recuperation du text dans un pdf*/
            $pdfParser = new \Smalot\PdfParser\Parser();
            $pdf = $pdfParser->parseFile($file->path());
            $content = $pdf->getText();

            $this->contenueFile1 = $content;

            $fileModal = new Media;

            if ($request->file()) {
                $fileName = time() . '_' . $request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
                $extension = $request->file('file')->getClientOriginalExtension();

                $fileModal->filePath = $filePath;
                $fileModal->fileName = $fileName;
                $fileModal->extension = $extension;

                $fileModal->save();

                //apres recuperation du text et enregistrement du fichier 1 passons au 2

                if ($request->file2) {
                    $file2 = $request->file2;

                    $fileName = time() . '_' . $request->file2->getClientOriginalName();
                    $filePath2 = $request->file('file')->storeAs('uploads', $fileName, 'public');
                    $extension = $request->file('file')->getClientOriginalExtension();

                    $fileModal->filePath = $filePath2;
                    $fileModal->fileName = $fileName;
                    $fileModal->extension = $extension;

                    $fileModal->save();

                    $pdfParser2 = new \Smalot\PdfParser\Parser();
                    $pdf2 = $pdfParser2->parseFile($file2->path());
                    $content2 = $pdf2->getText();
                    $this->contenueFile2 = $content2;
                    return back()
                        ->with('source', $content)
                        ->with('source2', $content2)
                        ->with('path1', $filePath)
                        ->with('path2', $filePath2);

                } else {
                    return back()
                        ->with('source', $content)
                        ->with('path', $filePath);
                    //dd("error file2");
                }
            } else {
                dd("Error");
            }
        } else {
            dd("contenue su second text area manquant");
        }
    }

    public function comparePlagiat(Request $request)
    {
        $seuil = Score::latest()?->first();
        $seuil = intval($seuil?->seuil_plagiat);
        try {
            $content1 = $request->source;
            $content2 = $request->source2;


            if (!isset($request->source) || !isset($request->source2)) {
                Toastr::error('message', trans('Aucun ficher uploader !'));
                return back();
            }

            $htmlDiff = new HtmlDiff($content1, $content2);
            $htmlDiff->getConfig()
                ->setMatchThreshold(80)
                ->setInsertSpaceInReplace(true);

            $similarcontent = $htmlDiff->build();

            $comparison = new \Atomescrochus\StringSimilarities\Compare();
            $similar = $comparison->similarText($content1, $content2);

            Toastr::success('message', trans('Success : Résultats de la détection disponibles ! '));
            return back()
                ->with('source', $content1)
                ->with('source2', $content2)
                ->with('similarcontent', $similarcontent)
                ->with('score', $similar)
                ->with('seuil',$seuil);
        } catch (Exception $e) {
            Toastr::error('message', trans('Une erreur est survenue !'));
            return back();
        }


    }

    public function generationRapport(Request $request)
    {
        try {
            if (isset($request->scorePlagiat)) {

                $data = [
                    "title" => "Rapport de plagiat",
                    "content" => "ici seras le contenue du pdf",
                    "scorePlagiat" => $request->scorePlagiat,
                    "source" => $request->source,
                    "cible" => $request->cible,
                    "Comparaison" => $request->similarcontent
                ];

                $pdf = \PDF::loadView('user.contenueRapport', $data);

                Toastr::success('message', trans('Success : Génération de rapports ! '));
                return response($pdf->output(), 200)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'inline; filename="mon-fichier-pdf.pdf"');

            } else {
                Toastr::success('message', trans('Success : Génération de rapports ! '));
                return back()
                    ->with('source', $request->source)
                    ->with('source2', $request->cible);
            }
        } catch (Exception $e) {
            Toastr::error('message', trans('Une erreur est survenue !'));
            return back();
        }


    }
}
