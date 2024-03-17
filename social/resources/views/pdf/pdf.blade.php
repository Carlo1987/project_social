<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ public_path('css/style_pdf.css') }}">
    <title>Elenco utenti</title>
</head>

<body>
    <h1>Elenco utenti</h1>

    <p>I profili <span class="blue">pubblici</span> sono visibili a tutti, i profili <span class="red">privati</span>
     solo dopo essere diventati amici </p>

        <section id="section_fake">
            <div class="yellow"></div>

            <div class="content">
                <h2>Utenti fittizzi</h2>

                <p>Oltre al tuo, puoi anche entrare in questi profili e usarli, ma non potrai modificarne i dati dell'Acount</p>

                <table border="1px">
                    <tr>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Profilo</th>
                    </tr>
                    @foreach($users as $user)
                    @if($user->id != 1 && $user->id <= 19) <tr>
                        <td>{{ $user->email }}</td>
                        <td>{{ strtolower($user->name) }}</td>
                        <td>@if($user->type == 'public')
                             <span class="blue">pubblico</span> 
                            @elseif($user->type == 'private')
                             <span class="red">privato</span> 
                            @endif
                        </td>
                        </tr>
                        @endif
                        @endforeach
                </table>
            </div>

            <div class="clearfix"></div>
        </section>

        <section id="section_users">
            <div class="green"></div>

            <div class="content">
                <h2>Utenti reali</h2>

                <table border="1px">
                    <tr>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Nickname</th>
                        <th>Profilo</th>
                    </tr>
                    @foreach($users as $user)
                    @if($user->id == 1 || $user->id > 19)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->surname }}</td>
                        <td>{{ $user->nick }}</td>
                        <td>@if($user->type == 'public')
                        <span class="blue">pubblico   @if($user->id==Auth::user()->id) (mio) @endif </span> 
                            @elseif($user->type == 'private')
                        <span class="red">privato   @if($user->id==Auth::user()->id) (mio) @endif </span> 
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </table>
            </div>

            <div class="clearfix"></div>
        </section>

</body>

</html>