<?php

namespace App\Http\Controllers\Pliagiat;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;


class PlagiatEnLigneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.plagiat_en_ligne.plagiat_en_ligne');
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
    public function store(Request $req)
    {
        try {
            $texte = $this->supprimer_caracteres_speciaux($req->text);
            $texte = $this->couper_texte($texte);
            $taille_texte_epure = strlen($texte);
            $taille_texte_initial = strlen($req->text);
            $rapport = (($taille_texte_epure * 100) / $taille_texte_initial);
            $resultats = $this->check_plagiat($texte);

            //dd($resultats);
            $scores = [];

            if (!empty($resultats)){
                foreach ($resultats->sources as $resultat){
                    $score = 0;
                    foreach ($resultat->matches as $value ){
                        $score += $value->score;
                    }
                    $score /= count($resultat->matches);
                    $scores[] = $score;
                }
            }

            Toastr::success('message', trans('Success : Résultats de la détection disponibles !'));
            return back()
                ->with('resultats',$resultats)
                ->with('scores', $scores)
                ->with('success',true);
        }catch(Exception $exception){
            Toastr::error('message', trans('error message.unable_to_save'));
            return back();
        }

    }

    private function couper_texte($texte) {
        $nb_caracteres = strlen($texte);
        if ($nb_caracteres < 3000) {
            return $texte;
        } else {
            return substr($texte, 0, 2998);
        }
    }
    private function supprimer_caracteres_speciaux($texte) {
        // Remplace les caractères spéciaux par des espaces
        $texte = preg_replace('/[^A-Za-z0-9]/', ' ', $texte);
        // Enlève les espaces en début et fin de chaîne
        $texte = trim($texte);
        // Enlève les espaces en double
        $texte = preg_replace('/\s+/', ' ', $texte);
        return $texte;
    }

    function extractSummary($text, $maxSentences = 1000): string
    {
        // Tokenisez le texte en phrases
        $sentences = preg_split('/[.!?]/', $text, -1, PREG_SPLIT_NO_EMPTY);

        // Calculez la longueur de chaque phrase et stockez-la dans un tableau associatif
        $sentenceLengths = array();
        foreach ($sentences as $sentence) {
            $sentenceLengths[$sentence] = strlen($sentence);
        }

        // Triez les phrases en fonction de leur longueur (du plus court au plus long)
        asort($sentenceLengths);

        // Sélectionnez les $maxSentences phrases les plus courtes pour former le résumé
        $summarySentences = array_slice(array_keys($sentenceLengths), 0, $maxSentences);

        return implode(' ', $summarySentences);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function check_plagiat(string $text)
    {
        try {
            $client = new Client();
            $headers = [
                'Content-Type' => 'application/json',
                'X-RapidAPI-Key' => 'f82b2fb840msh9015b1cee3e8062p10fb33jsn840fc5311bce',
                'X-RapidAPI-Host' => 'plagiarism-checker-and-auto-citation-generator-multi-lingual.p.rapidapi.com'
            ];
            $body = '{
              "text": "'.$text.'",
              "language": "en",
              "includeCitations": false,
              "scrapeSources": false
            }';
            $request = new \GuzzleHttp\Psr7\Request('POST', 'https://plagiarism-checker-and-auto-citation-generator-multi-lingual.p.rapidapi.com/plagiarism', $headers, $body);
            $res = $client->sendAsync($request)->wait();
            return json_decode($res->getBody());


        } catch (Exception $e) {
            return $e;
        }
    }
}
