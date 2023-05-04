<?php

namespace App\Http\Controllers\Pliagiat;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Psr\Http\Client\ClientExceptionInterface;


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
        $resultats = $this->check_plagiat('Descriptions in words aren re the best we can do in text. A graphics file illustrating the character set should be available');
        dd($resultats);
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
                'X-RapidAPI-Key' => '941fda43f1msh261969b320772a8p14ff81jsn42829015de4a',
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
