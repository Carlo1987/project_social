@extends('layouts.app')

@if(Auth::user()->gender == 'male')
                  <?php $log = 'Sei loggato';
                        $welcome = "Benvenuto"  ?> 
@else
                  <?php $log = 'Sei loggata';
                        $welcome = "Benvenuta"  ?> 
@endif

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header edit_{{ Themes::show(Auth::user()->id) }}"><?=$log?></div>

                <div class="card-body" style="font-size: 20px; text-align: center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <?=$welcome?> {{ Auth::user()->name }} nel mio progetto!!

                    <div>
                        <p>Clicca <span class="download fs-5" style="color: #0d6efd;  text-decoration: underline;">qui</span> per scaricare la lista degli utenti presenti</p>
                    </div>

                    <div>
                        <a href="{{ route('users.index') }}">Inizia a navigare</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
