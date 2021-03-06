<?php

function ajaxSaveComment_POST(Web $w) {
    $p = $w->pathMatch('parent_id');
        
    $comment = new Comment($w);
    $comment->obj_table = "comment";
    $comment->obj_id = $p['parent_id'];
    $comment->comment = strip_tags($w->request('comment'));
    $comment->insert();
    
    $w->setLayout(null);
    echo $w->partial("displaycomment", array("object" => $comment, 'redirect' => $w->request('redirect')), "admin");
}
