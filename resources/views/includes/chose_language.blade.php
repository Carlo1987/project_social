

<div class="dropdown positione-relative" id="chose_language">
  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <img src="{{ asset('img/bandiera_italia.png') }}" alt="flag_italy" style="width: 40px; height:28px;" id="flag_language" class="image_hover_{{ Themes::show() }}">  
  </a>

 @if(Auth::check()) 
  <ul class="dropdown-menu div_{{ Themes::show() }}">
 @else
 <ul class="dropdown-menu div_{{ Themes::show() }}">
 @endif
    <li class="li_{{ Themes::show() }}">
        <a class="dropdown-item" id="ita" href="#" data-language="ita">
           <img src="{{ asset('img/bandiera_italia.png') }}" alt="flag_italy">  Italiano 
        </a>
    </li>
    <li class="li_{{ Themes::show() }}">
        <a class="dropdown-item" id="esp" href="#" data-language="esp">
           <img src="{{ asset('img/bandiera_spagna.png') }}" alt="flag_spain">  Español 
        </a>
    </li>
  </ul>
</div>