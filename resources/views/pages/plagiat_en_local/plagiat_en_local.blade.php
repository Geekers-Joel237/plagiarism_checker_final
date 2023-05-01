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
                                    <div class="form-group">
                                        <label for="file">Choisir le document</label>
                                        <input class="btn btn-primary" type="file" id="file" name="file" required>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn  btn-warning" type="submit" >
                                            Chargez le document
                                        </button>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group row mb-4">
                                        <div class="col-sm-12 col-md-12">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Source</label>
                                            <textarea class="summernote" >
                                            </textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </section>
                        <h2>Lancer le Scan</h2>
                        <section>
                            <div class="d-flex justify-content-center align-items-center py-5">
                                <a href="#" class="btn btn-icon icon-left btn-primary"><i class="fas fa-arrow-right"></i> Lancer </a>
                            </div>
                        </section>
                        <h2>Resultats en Ligne</h2>
                        <section>
                            <p>Husbands ask repeated resolved but laughter debating. She end cordial visitor
                                noisier
                                fat subject general picture. Or if offering confined entrance no. Nay rapturous
                                him
                                see something residence. Highly talked do so vulgar. Her use behaved spirits
                                and
                                natural attempt say feeling. Exquisite mr incommode immediate he something
                                ourselves
                                it of. Law conduct yet chiefly beloved examine village proceed.</p>
                        </section>
                        <h2>Forth Step</h2>
                        <section>
                            <p>An country demesne message it. Bachelor domestic extended doubtful as concerns
                                at. Morning
                                prudent removal an letters by. On could my in order never it. Or excited
                                certain
                                sixteen it to parties colonel. Depending conveying direction has led immediate.
                                Law
                                gate her well bed life feet seen rent. On nature or no except it sussex.</p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



