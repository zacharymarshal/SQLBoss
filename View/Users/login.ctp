<?php
//    echo '<a class="login" href="'.$authUrl.'"><img src="/btn_google_signin_light_focus_web.png" style="margin: 10px auto 20px; display: block;" /></a>';
    echo $this->Html->image("/btn_google_signin_light_focus_web.png", array(
        "alt" => "Google Login Button",
        "style" => "margin: 10px auto 20px; display: block;",
        'url' => $authUrl
    ));
?>