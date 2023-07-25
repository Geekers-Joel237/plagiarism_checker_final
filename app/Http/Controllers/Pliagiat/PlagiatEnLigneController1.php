<?php

namespace App\Http\Controllers\Pliagiat;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Psr\Http\Client\ClientExceptionInterface;
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
        $texte = $this->supprimer_caracteres_speciaux($req->text);
        $texte = $this->couper_texte($texte);
        $text = $this->supprimer_caracteres_speciaux($req->text);

        /*
         * calculate rapport caracteres in text
         */
        $rapport = (2900 * 100) / strlen($text);

        $text = $this->extractSummary($text);
        $text = $this->couper_texte($text);

        $resultats = $this->check_plagiat($text);
        $resultScore = [];
        // $res1 = $resultats->sources;
        //  $res2 =$res1[0]->matches;
        // dd($res2[0]->score);

        // dd($resultats);


        $score = 0;
        $tmp = 0 ;
        foreach($resultats->sources as $resultat) {
            foreach($resultat->matches as $matche){
                $score += $matche->score;
            }
            $score = ($score*$rapport) / count($resultat->matches);

            array_push($resultScore, $score);
            //   print_r($tmp."\n");
            $score = 0;
            $tmp = 0;
        }

        for($i=0; $i<count($resultScore); $i++){
            $tmp = 0;
            if($resultScore[$i] > 100){
                $tmp = $resultScore[$i] - 100;
                print_r($tmp."\n");
                $resultScore[$i] = $resultScore[$i] - ( $tmp);
                $resultScore[$i] =$resultScore[$i] - ( $tmp);
            }
        }


        return back()
            ->with('resultats',$resultats)
            ->with('scores',$resultScore)
            ->with('success',true);
    }

    private function couper_texte($texte) {
        $nb_caracteres = strlen($texte);
        if ($nb_caracteres < 3000) {
            return $texte;
        } else {
            return substr($texte, 0, 2900);
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


    function extractSummary($text, $maxSentences = 1000) {
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

    public function check_plagiat(string $text)
    {
        //$text = $this->extractSummary($text);

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
