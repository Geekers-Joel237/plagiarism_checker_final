@extends('layouts.backend')
@section('content')

    <style>
        /* Difference Highlighting and Strike-through
------------------------------------------------ */
        ins {
            color: #333333;
            background-color: #eaffea;
            text-decoration: none;
        }

        del {
            color: #AA3333;
            background-color: #ffeaea;
            text-decoration: line-through;
        }

        /* Image Diffing
        ------------------------------------------------ */
        del.diffimg.diffsrc {
            display: inline-block;
            position: relative;
        }

        del.diffimg.diffsrc:before {
            position: absolute;
            content: "";
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(
                to left top,
                rgba(255, 0, 0, 0),
                rgba(255, 0, 0, 0) 49.5%,
                rgba(255, 0, 0, 1) 49.5%,
                rgba(255, 0, 0, 1) 50.5%
            ), repeating-linear-gradient(
                to left bottom,
                rgba(255, 0, 0, 0),
                rgba(255, 0, 0, 0) 49.5%,
                rgba(255, 0, 0, 1) 49.5%,
                rgba(255, 0, 0, 1) 50.5%
            );
        }

        /* List Diffing
        ------------------------------------------------ */
        /* List Styles */
        .diff-list {
            list-style: none;
            counter-reset: section;
            display: table;
        }

        .diff-list > li.normal,
        .diff-list > li.removed,
        .diff-list > li.replacement {
            display: table-row;
        }

        .diff-list > li > div {
            display: inline;
        }

        .diff-list > li.replacement:before,
        .diff-list > li.new:before {
            color: #333333;
            background-color: #eaffea;
            text-decoration: none;
        }

        .diff-list > li.removed:before {
            counter-increment: section;
            color: #AA3333;
            background-color: #ffeaea;
            text-decoration: line-through;
        }

        /* List Counters / Numbering */
        .diff-list > li.normal:before,
        .diff-list > li.removed:before,
        .diff-list > li.replacement:before {
            width: 15px;
            overflow: hidden;
            content: counters(section, ".") ". ";
            display: table-cell;
            text-indent: -1em;
            padding-left: 1em;
        }

        .diff-list > li.normal:before,
        li.replacement + li.replacement:before,
        .diff-list > li.replacement:first-child:before {
            counter-increment: section;
        }

        ol.diff-list li.removed + li.replacement {
            counter-increment: none;
        }

        ol.diff-list li.removed + li.removed + li.replacement {
            counter-increment: section -1;
        }

        ol.diff-list li.removed + li.removed + li.removed + li.replacement {
            counter-increment: section -2;
        }

        ol.diff-list li.removed + li.removed + li.removed + li.removed + li.replacement {
            counter-increment: section -3;
        }

        ol.diff-list li.removed + li.removed + li.removed + li.removed + li.removed + li.replacement {
            counter-increment: section -4;
        }

        ol.diff-list li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.replacement {
            counter-increment: section -5;
        }

        ol.diff-list li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.replacement {
            counter-increment: section -6;
        }

        ol.diff-list li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.replacement {
            counter-increment: section -7;
        }

        ol.diff-list li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.replacement {
            counter-increment: section -8;
        }

        ol.diff-list li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.replacement {
            counter-increment: section -9;
        }

        ol.diff-list li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.replacement {
            counter-increment: section -10;
        }

        ol.diff-list li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.removed + li.replacement {
            counter-increment: section -11;
        }

        /* Exception Lists */
        ul.exception,
        ul.exception li:before {
            list-style: none;
            content: none;
        }

        .diff-list ul.exception ol {
            list-style: none;
            counter-reset: exception-section;
            /* Creates a new instance of the section counter with each ol element */
        }

        .diff-list ul.exception ol > li:before {
            counter-increment: exception-section;
            content: counters(exception-section, ".") ".";
        }

    </style>

    {{-----------------nav section------------------}}
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary text-white-all">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="#"><i class="far fa-file"></i> Library</a></li>
                <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i> Data</li>
            </ol>
        </nav>
    </div>
    {{-----------------nav section------------------}}

    {{-----------------main content------------------}}

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div id="wizard_horizontal">
                        <h2>Chargez Vos Document</h2>
                        <section>

                            {{------------formulaire de controle de plagiat-----------------}}
                            <div class="row">
                                <form action="{{ route('uploadFile') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="ml-4">
                                        <button class="btn btn-warning" type="submit">chargez les documents</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            {{------------boutton de soumission-----------------}}

                                            <div class="col">
                                                <div class="form-group row mb-4">
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="col-form-label text-md-right">Source</label>
                                                        <textarea class="summernote">
                                                             @if ($source = Session::get('source'))
                                                                {{ $source }}
                                                            @endif
                                                        </textarea>
                                                        <input class="btn btn-primary" type="file" name="file" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="form-group row mb-4">
                                                    <div class="col-sm-12 col-md-12">
                                                        <label class="col-form-label text-md-right">Cible</label>
                                                        <textarea class="summernote">
                                                             @if ($source2 = Session::get('source2'))
                                                                {{ $source2 }}
                                                            @endif
                                                        </textarea>

                                                        <input class="btn btn-primary" type="file" name="file2"
                                                               required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>
                        <h2>Controller Le Seuille De Plagiat</h2>
                        <section>
                            {{------------formulaire pour voir plagiat-----------------}}
                            <div class="row">

                                {{------------formulaire de soumission pour pouvoir controller le plagiat de doc-----------------}}
                                <form class="col-2" action="{{ route('comparePlagiat') }}" method="POST">
                                    @csrf
                                    <textarea class="" name="source" style="display:none">
                                        @if ($source = Session::get('source'))
                                            {{$source}}
                                        @endif
                                    </textarea>

                                    <textarea class="" name="source2" style="display:none">
                                        @if ($source2 = Session::get('source2'))
                                            {{$source2}}
                                        @endif
                                    </textarea>

                                    <div class="mt-3">
                                        <button class="btn btn-success" type="submit">seuille de plagiat</button>
                                    </div>

                                    <div class="mt-4">
                                        <p>Score de plagiat</p>
                                        @if ($score = Session::get('score'))
                                            {{$score}}
                                        @endif
                                    </div>
                                </form>
                                <div class="col">
                                    <div class="form-group row mb-4">
                                        <div class="col-sm-12 col-md-12">
                                            <label class="col-form-label text-md-right">Cible</label>
                                            <textarea class="summernote">
                                                             @if ($similar = Session::get('similarcontent'))
                                                        <?php echo($similar) ?>
                                                @endif
                                                        </textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </section>
                        <h2>Décision</h2>
                        <section>
                            @if($score = Session::get('score') and $seuil = Session::get('seuil'))
                                <p class="text-info">SCORE DE PLAGIAT : {{round($score,2)}} %</p>
                                <p class="text-info">SEUIL DE PLAGIAT : {{$seuil}} %</p>

                                @if($score < $seuil )
                                    <p class="lead text-success">
                                        Document Autorisé !
                                    </p>
                                @else()
                                    <p class="lead text-danger">
                                        Document Rejeté !
                                    </p>
                                @endif
                            @endif

                        </section>
                        <h2>Générer Votre Rapport</h2>
                        <section>
                            {{-----ce formulaire seras utiliser pour la genaration de rapport----------}}
                            <div class="row">

                                <div class="col-2 mt-1">
                                    <form action="{{route('generationRapport')}}" method="POST"
                                          enctype="multipart/form-data" target="_blank">
                                        @csrf
                                        <textarea style="display:none" name="scorePlagiat">
                                            @if ($score = Session::get('score'))
                                                {{$score}}
                                            @endif
                                       </textarea>
                                        <textarea style="display:none" name="source">
                                             @if ($source = Session::get('source'))
                                                {{$source}}
                                            @endif
                                       </textarea>
                                        <textarea style="display:none" name="cible">
                                             @if ($source2 = Session::get('source2'))
                                                {{$source2}}
                                            @endif
                                       </textarea>
                                        <textarea style="display:none" name="similarcontent">
                                             @if ($similar = Session::get('similarcontent'))
                                                    <?php echo($similar) ?>
                                            @endif
                                       </textarea>
                                        <button class="btn btn-success">génerer le rapport</button>
                                    </form>
                                </div>

                                <div class="col">
                                    <p>
                                        Description de code couleur An country demesne message it. Bachelor domestic
                                        extended doubtful as concerns
                                        at. Morning
                                        prudent removal an letters by. On could my in order never it. Or excited
                                        certain
                                        sixteen it to parties colonel. Depending conveying direction has led immediate.
                                        Law
                                        gate her well bed life feet seen rent. On nature or no except it sussex
                                    </p>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-----------------main content------------------}}

@endsection
