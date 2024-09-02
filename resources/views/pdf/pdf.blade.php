<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ public_path('css/style_pdf.css') }}">
    <title class="lang" data-section="pdf" data-article="title">Users</title>
</head>

<body>


<?php


$text_words = ["title"=>"Elenco utenti" , "profiles"=>"I profili" , "publics"=>"pubblici" , "all"=>"sono visibili a tutti, i profili" , "privates"=>"privati",
 "after"=>"solo dopo essere diventati amici" , "fake_users"=>"Utenti fittizzi" , "real_users"=>"Utenti reali" , "warning"=>"Oltre al tuo, puoi anche entrare in questi profili e usarli, ma non potrai modificarne i dati dell'Acount" ,
 "public"=>"pubblico" , "private"=>"privato" , "name"=>"Nome" , "surname"=>"Cognome" , "email"=>"Email" , "profile_uppercase"=>"Profilo"];

 
if(isset($_GET['lang']) && $_GET['lang'] == 'esp'){

$text_words = ["title"=>"Lista de Usuarios" , "profiles"=>"Los perfiles" , "publics"=>"publicos" , "all"=>"son visibles a todos, los perfiles" , "privates"=>"privados",
    "after"=>"solo despues de hacerce amigos" , "fake_users"=>"Usuarios falsos" , "real_users"=>"Usuarios reales" , "warning"=>"Ademas de lo tuyo, puedes tambien entrar en estos perfiles y usarlos, pero no podras modificar los datos del Acount" ,
    "public"=>"publico" , "private"=>"privado" , "name"=>"Nombre" , "surname"=>"Apellido" , "email"=>"Correo electronico" , "profile_uppercase"=>"Perfil"];
}

?>






    <h1> <?= $text_words['title'] ?> </h1>

    <p>
        <span> <?= $text_words['profiles'] ?>  </span> 
        <span class="blue"> <?= $text_words['publics'] ?> </span> 
        <span>  <?= $text_words['all'] ?>  </span> 
        <span class="red"> <?= $text_words['privates'] ?> </span>
        <span> <?= $text_words['after'] ?>  </span> 
    </p>

        <section id="section_fake">
            <div class="yellow"></div>

            <div class="content">
                <h2> <?= $text_words['fake_users'] ?> </h2>

                <p> <?= $text_words['warning'] ?> </p>

                <table border="1px">
                    <tr>
                        <th> <?= $text_words['email'] ?> </th>
                        <th>Password</th>
                        <th> <?= $text_words['profile_uppercase'] ?> </th>
                    </tr>
                    @foreach($users as $user)
                    @if($user->id != 1 && $user->id <= 19) <tr>
                        <td>{{ $user->email }}</td>
                        <td>{{ strtolower($user->name) }}</td>
                        <td>@if($user->type == 'public')
                             <span class="blue"> <?= $text_words['public'] ?>   @if(Auth::check() && $user->id==Auth::user()->id) (mio) @endif</span> 
                            @elseif($user->type == 'private')
                             <span class="red"> <?= $text_words['private'] ?>   @if(Auth::check() && $user->id==Auth::user()->id)  (mio) @endif</span> 
                            @endif
                        </td>
                        </tr>
                        @endif
                        @endforeach
                </table>
            </div>

            <div class="clearfix"></div>
        </section>



        @if(Auth::check())

        <section id="section_users mt-1">
            <div class="green"></div>

            <div class="content">
                <h2> <?= $text_words['real_users'] ?> </h2>

                <table border="1px">
                    <tr>
                        <th><?= $text_words['name'] ?></th>
                        <th><?= $text_words['surname'] ?></th>
                        <th>Nickname</th>
                        <th> <?= $text_words['profile_uppercase'] ?> </th>
                    </tr>
                    @foreach($users as $user)
                    @if($user->id == 1 || $user->id > 19)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->surname }}</td>
                        <td>{{ $user->nick }}</td>
                        <td>@if($user->type == 'public')
                        <span class="blue"> <?= $text_words['public'] ?>    @if($user->id==Auth::user()->id) (mio) @endif </span> 
                            @elseif($user->type == 'private')
                        <span class="red"> <?= $text_words['private'] ?>    @if($user->id==Auth::user()->id) (mio) @endif </span> 
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </table>
            </div>

            <div class="clearfix"></div>
        </section>

        @endif

</body>

</html>



