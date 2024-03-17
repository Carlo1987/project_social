 @if($friendship->status == 'in sospeso')
 
 <div class="btn-group dropstart">
 @if($friendship->user_id != Auth::user()->id)  <!-- bottone per rispondere a richiesta amicizia di un altro utente -->
    <button type="button" class="btn btn-primary">
       Richiesta in sospeso
    </button>
    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
       <span class="visually-hidden">Toggle Dropend</span>
    </button>
   
    <ul class="menu_search dropdown-menu {{ Themes::show(Auth::user()->id) }}">
       <li style="float: left; margin-right:15px">
          <form method="POST" action="{{ route('friendlists.store') }}">
          @csrf
             <input type="hidden" name="id" value="{{ $friendship->id }}">
             <input type="hidden" name="choise" value="accepted">
             <input type="submit" class="btn btn-success" value="Accetta">
          </form>
       </li>
       <li style="float: right;">
          <form method="POST" action="{{ route('friendlists.store') }}">
          @csrf
             <input type="hidden" name="id" value="{{ $friendship->id }}">
             <input type="hidden"  name="choise" value="rejected">
             <input type="submit" class="btn btn-danger" value="Rifiuta">
          </form>
       </li>
       <div class="clearfix"></div>
    </ul>

    @else  <!-- bottone di attesa (deve rispondere alla richiesta l'altro utente) -->

    <button type="button" class="btn btn-warning">
       In attesa di risposta
    </button>
    @endif
 </div>

 @endif

