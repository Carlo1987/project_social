

    <ul class="container_chat">
              <!--   chat realizzata con JS     -->
    </ul>

    <form  class="my-3 form_chat" id="form_chat">
        <input type="hidden" class="friend_data" data-friend_id="{{ $chat['friend_id'] }}">
        <div class="row">
            <div class="col-sm-10 col-9">
                <input class="auth_data w-100" type="text" data-auth_id="{{ $chat['auth_id'] }}" />
            </div>
            <div class="col-sm-2 col-3">
                  <button type="submit" class="btn btn-primary mb-2 px-4 fs-5 lang" data-section ="chat" data-article="send">Invia</button>
            </div>
        </div>
    </form>







   