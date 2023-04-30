@extends('layouts.backend')
@section('content')

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
    

@endsection
