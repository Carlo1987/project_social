 @if($friendship->status == 'in sospeso')
 
 <div class="btn-group dropstart">
 @if($friendship->user_id != Auth::user()->id)  <!-- bottone per rispondere a richiesta amicizia di un altro utente -->
    <button type="button" class="btn btn-primary lang" data-section="profile" data-article="question">
       Richiesta in sospeso
    </button>
    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
       <span class="visually-hidden">Toggle Dropend</span>
    </button>
   
    <ul class="menu_search dropdown-menu {{ Themes::show() }}">
      <div class="w-100 d-flex flex-row justify-content-around">
         <li class="me-2">
          <form method="POST" action="{{ route('friendlists.store') }}">
          @csrf
             <input type="hidden" name="id" value="{{ $friendship->id }}">
             <input type="hidden" name="choise" value="accepted">
             <button type="submit" class="btn btn-success lang" data-section="profile" data-article="accept"> Accetta </button>
          </form>
         </li>
       
         <li>
          <form method="POST" action="{{ route('friendlists.store') }}">
          @csrf
             <input type="hidden" name="id" value="{{ $friendship->id }}">
             <input type="hidden"  name="choise" value="rejected">
             <button type="submit" class="btn btn-danger lang" data-section="profile" data-article="reject"> Rifiuta </button>
          </form>
         </li>
      </div>
    </ul>

    @else  <!-- bottone di attesa (deve rispondere alla richiesta l'altro utente) -->

    <button type="button" class="btn btn-warning lang" data-section="profile" data-article="waiting">
       In attesa di risposta
    </button>
    @endif
 </div>

 @endif

