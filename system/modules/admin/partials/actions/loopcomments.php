<?php

function loopcomments_ALL(Web $w, $params) {
    $w->ctx("comments", $params['object']);
    $w->ctx("redirect", $params['redirect']);
}
    