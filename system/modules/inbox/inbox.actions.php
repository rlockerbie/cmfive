<?php

function delete_ALL(Web &$w) {
    $p = $w->pathMatch("type", "arr");
    $check = explode(",", $p['arr']);
    if ($check[0] == "on") {
        unset($check[0]);
    }
    foreach ($check as $message) {
        $mess_obj = $w->Inbox->getMessage($message);
        $mess_obj->is_deleted = 1;
        //		$mess_obj->dt_archived = time();
        $mess_obj->update();
    }
    $w->msg("Message(s) Deleted", "/inbox/" . $p['type']);
}

function trash_ALL(Web &$w) {
    $w->Inbox->navigation($w, 'Bin');
    $p = $w->pathMatch('num');
    $num = $p['num'] ? $p['num'] : 1;

    $read_del = $w->Inbox->getMessages($num - 1, 40, $w->Auth->user()->id, 0, 0, 1);
    //$new_del = $w->Inbox->getMessages(0,100,$w->Auth->user()->id,1,0,1);
    $del_count = $w->Inbox->getDelMessageCount();

    $table_header = array("<input style='margin: 0px;' type='checkbox' id='allChk' onclick='selectAll()' />", "Subject", "Date", "Sender");
    $table_data = array();
    if (!empty($read_del)) {
        foreach ($read_del as $q) {
            $table_data[] = array(
                "<input style='margin: 0px;' type='checkbox' id='" . $q->id . "' value='" . $q->id . "' class='classChk'/>",
                Html::a(WEBROOT . "/inbox/view/" . $q->id, $q->subject),
                $q->getDate("dt_created", "d/m/Y H:i"),
                ($q->sender_id ? $q->getSender()->getFullName() : "")
            );
        }
    }
    $w->ctx("del_table", Html::table($table_data, null, "tablesorter", $table_header));

    $w->ctx('del_count', $del_count);
    $w->ctx('pgnum', $num);
    $w->ctx('readdel', $read_del);
    //$w->ctx('newdel',$new_del);
}

function deleteforever_ALL(Web &$w) {
    $p = $w->pathMatch("arr");
    $check = explode(",", $p['arr']);
    if ($check[0] == "on") {
        unset($check[0]);
    }
    foreach ($check as $message) {
        $mess_obj = $w->Inbox->getMessage($message);
        $mess_obj->del_forever = 1;
        //		$mess_obj->dt_archived = time();
        $mess_obj->update();
    }
    $w->msg("Message(s) Deleted", "/inbox/trash");
}

?>
