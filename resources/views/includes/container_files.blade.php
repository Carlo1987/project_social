
<div class="container" id="container_index">                              

    <div class="nav_responsive fixed-top nav_{{ Themes::show() }} z-1">
        <div id="button_images_responsive" class="titles_{{ Themes::show() }} lang" data-section="profile" data-article="images">  Immagini   </div>
        <div id="button_videos_responsive" class="titles_{{ Themes::show() }} lang" data-section="profile" data-article="videos">  Video </div>
    </div>

    <div class="content_images">
        <div class="titles titles_{{ Themes::show() }} btn">
            <h3 class="lang" data-section="profile" data-article="images">Immagini</h3>
        </div>

        @include('includes.images-profile')
    </div>



    <div class="content_videos">
        <div class="titles titles_{{ Themes::show() }} btn">
            <h3 class="lang" data-section="profile" data-article="videos">Video</h3>
        </div>

        @include('includes.videos-profile')
    </div>

</div>                                                                                  

