@extends('layouts.backend')

@section('content')

    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-primary text-white-all">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-tachometer-alt"></i> Accueil</a></li>
                            <li class="breadcrumb-item"><a href="#"><i class="far fa-file"></i> Detection</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i> Plagiat En Ligne</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <div id="wizard_horizontal">
                        <h2>Charger le Document</h2>
                        <section>
                            <div class="row">
                                <div class="col-3 d-flex flex-column py-5 justify-content-between">
                                    <form action="{{ route('uploadFile') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="file">Choisir le document</label>
                                            <input class="btn btn-primary" type="file" id="file" name="file" required>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn  btn-warning" type="submit" >
                                                Chargez le document
                                            </button>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-9">
                                    <div class="form-group row mb-4">
                                        <div class="col-sm-12 col-md-12 ml-3">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Source</label>
                                         @if (!Session::get('source'))
                                            <textarea class="summernote " style="max-height: 500px;overflow-y: auto;">
                                             @if ($source = Session::get('source'))
                                                    {{ $source }}
                                                @endif
                                            </textarea>
                                        @elseif ($path1 = Session::get('path'))
                                        <embed src="{{ asset("storage/$path1")}}" type="application/pdf" width="750" height="550" class="ml-5">
                                        @else
                                        <textarea class="summernote " style="max-height: 500px;overflow-y: auto;"></textarea>

                                        @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </section>
                        <h2>Lancer le Scan</h2>
                        <section>
                            @if($success = Session::get('success'))
                                <div class="d-flex justify-content-center">
                                    <span class="badge badge-success text-center my-3 mx-auto">
                                    Les résultats sont disponibles
                                </span>
                                </div>
                            @endif
                            <form action="{{route('plagiat.en_ligne.store')}}" method="post">
                                @csrf
                                <textarea class=" d-none" style="display: none !important;" hidden="hidden" name="text" >
                                             @if ($source = Session::get('source'))
                                        {{ $source }}
                                    @endif
                                </textarea>
                                <div class="d-flex justify-content-center align-items-center py-5">
                                    <button type="submit" class="btn btn-icon icon-left btn-primary"><i class="fas fa-arrow-right"></i> Lancer </button>
                                </div>
                            </form>
                        </section>
                        <h2>Resultats en Ligne</h2>
                        <section>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Resultats Plagiat en ligne</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table-1">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">
                                                            Sources
                                                        </th>
                                                        <th>Url</th>
                                                        <th>Titre</th>
                                                        <th>Score</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if ($resultats = Session::get('resultats') and $scores = Session::get('scores'))
                                                            @foreach($resultats->sources as $key => $resultat)
                                                                <tr>
                                                                    <td>{{$key + 1}}</td>
                                                                    <td>
                                                                        <a class="" target="_blank" href="{{$resultat->url}}">
                                                                            {{$resultat->url}}
                                                                        </a>
                                                                        </td>
                                                                    <td>{{$resultat->title}}</td>
                                                                    {{--<td>{{count($resultat->matches)}}</td>--}}

                                                                    <td>{{$scores[$key]+ $resultats->percentPlagiarism}}</td>

                                                                </tr>
                                                            @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



