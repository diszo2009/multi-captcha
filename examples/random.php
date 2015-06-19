<?php

include_once( "../src/captcha.php");


$captcha = new \MultiCaptcha\Captcha([
    'secret'=>    "form1-secret-key",
    'options' =>  [

        'honeypot' => array(
            'description'=> "Leave this field empty if you are human",
            'class' => 'error'
        ),
        'math' => array(
            'description'=> "Answer following question if you are human",
            'level' => 4
        ),
        'image' => array(
            'maxCodeLength' => 8,
            'font'=>'../src/types/image/comic.ttf',
            'width'=>180
        ),
        'ascii' => array(
            'maxCodeLength' => 8,
            'fonts'=>array(
                'banner'=> 4,
                'doom'=> 8,
                'small'=>'8'
            )
        ),
        'gif' => array(
            'maxCodeLength' => 8,
            'font'=>'../src/types/image/comic.ttf',
            'width'=>180,
            'height'=>60,
            'totalFrames'=>50,
            'delay'=>20
        )
    ]
] );

if( isset( $_REQUEST['submit'] ) ){
    var_dump( $captcha->validate( $_POST, $_SERVER['REMOTE_ADDR'] ) );
}
?>
<h2>Display a random captcha from types initialized using "<i>options</i>" parameter.</h2>
<form action="" method="post">
    <?php
    echo $captcha->render() ;
    ?>
    <input type="submit" name="submit" value="Submit">

</form>

