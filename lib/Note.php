<?php
class Note {
    public static function can_access($note_id) {
        global $db;
        $note = $db->query_single("SELECT * FROM `note` WHERE `id` = :id", array("id" => $note_id));
        return $note["is_shared"] == 1 || $note["author_id"] == $_SESSION["user"]->id;
    }

    public static function can_edit($note_id) {
        global $db;
        $note = $db->query_single("SELECT * FROM `note` WHERE `id` = :id", array("id" => $note_id));
        return $note["author_id"] == $_SESSION["user"]->id;
    }
}
?>
