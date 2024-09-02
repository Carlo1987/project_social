@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card animate__animated animate__backInUp">
                <div class="card-header edit_{{ Themes::show() }} lang" data-section="welcome" data-article="success"> Login effettuato </div>

                <div class="card-body" style="font-size: 20px; text-align: center">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        <span class="fs-4 lang" data-section="welcome" data-article="thanks">
                           Divertiti con Faceback!! 
                        </span> 
                        <i class="fa-regular fa-face-smile-wink"></i>
                    </p> 

                    <div>
                        <a href="{{ route('users.index') }}" class="lang" data-section="welcome" data-article="link">Entra nella HOME</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
