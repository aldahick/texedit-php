<?php
require_once(__DIR__ . "/inc/layout.php");
$_VIEW["requires_auth"] = true;
$sql = "SELECT
            `note`.*,
            `author`.`email` AS author_email
        FROM
            `note`
                LEFT JOIN `user` `author` ON
                    `note`.`author_id` = `author`.`id`
        WHERE
            `note`.`author_id` = :author_id
        ORDER BY `note`.`created` DESC";
$notes = $db->query($sql, array("author_id" => $_SESSION["user"]->id));
layout_header();
?>
<h4>List Notes</h4>
<div class="col-md-8">
    <table class="table table-hover table-striped">
        <thead>
            <th>Title</th>
            <th>Date Created</th>
            <th>Author</th>
        </thead>
        <tbody>
            <?php foreach ($notes as $k => $note): ?>
                <tr class="note-row" data-id="<?=$note["id"]?>">
                    <td>
                        <a href="edit.php?id=<?=$note["id"]?>"><?=htmlspecialchars($note["title"])?></a>
                    </td>
                    <td>
                        <?=$note["created"]?>
                    </td>
                    <td><?=htmlspecialchars($note["author_email"])?></td>
                    <td>
                        <span class="btn-delete glyphicon glyphicon-trash"></span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
layout_footer();
?>
