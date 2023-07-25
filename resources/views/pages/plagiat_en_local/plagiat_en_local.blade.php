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
                            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i> Plagiat En Local</li>
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
                                    <div class="form-group ">

                                        {{---------formulaire de somission du fichier-------------}}
                                        <form action="{{route('plagiat.uploadFile')}}"  method="POST" enctype="multipart/form-data">
                                            @csrf
                                           <div class="form-group mr-3">
                                            <label for="file">Choisir le document</label>
                                            <input class="btn btn-primary" type="file" id="file" name="file" required>
                                           </div>
                                        {{----input pour charger le document ----------}}
                                           <div class="form-group">
                                               <button class="btn  btn-warning" type="submit" >
                                                   Chargez le document
                                               </button>
                                           </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group row mb-4 ml-4">
                                        <div class="col-sm-12 col-md-12">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Source</label>

                                            @if (!Session::get('source'))
                                            <textarea class="summernote" >
                                                @if ($source = Session::get('source'))
                                                 {{ $source }}
                                                @endif
                                            </textarea>
                                            @elseif ($path1 = Session::get('path'))
                                            <embed src="{{ asset("storage/$path1")}}" type="application/pdf" width="550" height="550" class="ml-5">
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
                            <div class="d-flex justify-content-center align-items-center py-5">
                                <form action="{{route('plagiat.traitementLocal')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <textarea  style="display:none" name="content">
                                        @if ($source = Session::get('source'))
                                         {{ $source }}
                                        @endif
                                    </textarea>
                                    <button class="btn btn-primary" type="submit"> <i class="fas fa-arrow-right"></i> Lancer</button>
                                </form>
                            </div>
                        </section>
                        <h2>Resultats en Ligne</h2>
                        <section>
                           @if ($arrayMaxPlagiat = Session::get('arrayMaxPlagiat'))
                                <div class="card-body">
                                    <div class="able-responsive">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        #
                                                    </th>
                                                    <th>SOURCE</th>
                                                    <th>CIBLE</th>
                                                    <th>SIMILARITE</th>
                                                    <th>DATE DE SCAN</th>
                                                    <th>ACTIONS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $count = 0;
                                            @endphp
                                            @foreach ($arrayMaxPlagiat as $plagiat)
                                                <tr>
                                                    <td>
                                                        {{++$count}}
                                                    </td>
                                                    <td>{{$plagiat["path_source"]}}</td>
                                                    <td>{{$plagiat["path_cible"]}}</td>
                                                    <td class="align-middle">
                                                        {{$plagiat["pourcentage"]}}%
                                                    </td>
                                                    <td>2023-05-05</td>
                                                <td>
                                                    <form action="{{route('generationRapport')}}" method="POST" enctype="multipart/form-data" target="_blank">
                                                        @csrf
                                                        <textarea style="display:none" name="scorePlagiat">
                                                            <!-- @if ($score = Session::get('score'))
                                                                {{$score}}
                                                            @endif-->
                                                            {{$plagiat["pourcentage"]}}
                                                        </textarea>
                                                        <textarea style="display:none" name="source">
                                                            @if ($source = Session::get('source'))
                                                            {{ $source }}
                                                           @endif
                                                        </textarea>
                                                        <textarea style="display:none" name="cible">
                                                            <!--  @if ($source2 = Session::get('source2'))
                                                                {{$source2}}
                                                            @endif -->
                                                            {{$plagiat["content"]}}
                                                        </textarea>
                                                        <textarea style="display:none"  name="similarcontent">
                                                              <!--@if ($similar = Session::get('similarcontent'))
                                                                    <?php echo($similar) ?>
                                                            @endif-->
                                                            <?php echo($plagiat["diff"])?>
                                                        </textarea>
                                                        <button class="btn btn-success">génerer le rapport</button>
                                                    </form>
                                                </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                           @endif
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



