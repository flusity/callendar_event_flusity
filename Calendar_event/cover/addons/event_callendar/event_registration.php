<?php

    $limit = 7; 
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;

 
    $sql_count = "SELECT COUNT(*) AS cnt FROM " . $prefix['table_prefix'] . "_event_reservation_time";
    $stmt_count = $db->prepare($sql_count);
    $stmt_count->execute();
    $count_data = $stmt_count->fetch(PDO::FETCH_ASSOC);
    $total = $count_data['cnt'];
    $pages = ceil($total / $limit);

    $sql = "SELECT " . $prefix['table_prefix'] . "_event_reservation_time.*, lab.event_name AS laboratory_name, item.title AS event_title, mem.member_first_name, mem.member_last_name
        FROM " . $prefix['table_prefix'] . "_event_reservation_time
        LEFT JOIN " . $prefix['table_prefix'] . "_event_callendar_laboratories AS lab ON " . $prefix['table_prefix'] . "_event_reservation_time.event_laboratory_id = lab.id
        LEFT JOIN " . $prefix['table_prefix'] . "_event_callendar_item AS item ON " . $prefix['table_prefix'] . "_event_reservation_time.event_item_id = item.id
        LEFT JOIN " . $prefix['table_prefix'] . "_callendar_users_member AS mem ON " . $prefix['table_prefix'] . "_event_reservation_time.event_users_member_id = mem.id
        LIMIT :start, :limit";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':start', $start, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $edit_reservation_data = null;
    if (isset($_GET['edit_reservation_id'])) {
        $edit_reservation_id = intval($_GET['edit_reservation_id']);
        $sql = "SELECT " . $prefix['table_prefix'] . "_event_reservation_time.*, lab.event_name AS laboratory_name, item.title AS event_title
                FROM " . $prefix['table_prefix'] . "_event_reservation_time
                LEFT JOIN " . $prefix['table_prefix'] . "_event_callendar_laboratories AS lab ON " . $prefix['table_prefix'] . "_event_reservation_time.event_laboratory_id = lab.id
                LEFT JOIN " . $prefix['table_prefix'] . "_event_callendar_item AS item ON " . $prefix['table_prefix'] . "_event_reservation_time.event_item_id = item.id
                WHERE " . $prefix['table_prefix'] . "_event_reservation_time.id = :edit_reservation_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':edit_reservation_id', $edit_reservation_id, PDO::PARAM_INT);
        $stmt->execute();
        $edit_reservation_data = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if (isset($edit_reservation_data['event_users_member_id'])) {
        $sql_member = "SELECT * FROM " . $prefix['table_prefix'] . "_callendar_users_member WHERE id = :member_id";
        $stmt_member = $db->prepare($sql_member);
        $stmt_member->bindParam(':member_id', $edit_reservation_data['event_users_member_id'], PDO::PARAM_INT);
        $stmt_member->execute();
        $member_data = $stmt_member->fetch(PDO::FETCH_ASSOC);
    }

/*     
1 reiškia "patvirtintas"
2 reiškia "atmestas"
3 reiškia "laukiamas patvirtinimo" (ši reikšmė priskirta naujiems įrašams pagal nutylėjimą)
4 reiškia "įvygdyta" 
*/

    if ($edit_reservation_data !== null) {
?>
<form action="../../cover/addons/event_callendar/action/edit_reservation.php" method="post" id="editFormCancel">

    <input type="hidden" name="edit_reservation_id" value="<?php echo ($edit_reservation_data !== null) ? $edit_reservation_data['id'] : ''; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <h4><?php echo "<b>". t("Cabinet: "). "</b>"; echo ($edit_reservation_data !== null) ? htmlspecialchars($edit_reservation_data['laboratory_name']) : ''; ?></h4>
    <input type="hidden" name="laboratory_name" value="<?php echo ($edit_reservation_data !== null) ? htmlspecialchars($edit_reservation_data['laboratory_name']) : ''; ?>">
    
    <h5><?php echo "<b>".t("Event Title: "). "</b>"; echo ($edit_reservation_data !== null) ? htmlspecialchars($edit_reservation_data['event_title']) : ''; ?></h5>
    <input type="hidden" name="event_title" value="<?php echo ($edit_reservation_data !== null) ? htmlspecialchars($edit_reservation_data['event_title']) : ''; ?>">
     
    <h5>
        <?php echo "<b>" . t("Member user") . "</b>: "; ?>
        <?php
        if (isset($member_data)) {
            echo htmlspecialchars($member_data['member_first_name'] . ' ' . $member_data['member_last_name']);
        }
        ?>
    </h5>
    <input type="hidden" name="event_users_member_id" value="<?php echo htmlspecialchars($edit_reservation_data['event_users_member_id'] ?? ''); ?>">
    <h5><?php echo "<b>" . t("Additional information") . ": </b>";?></h5>
    <p><?php echo ($edit_reservation_data !== null) ? htmlspecialchars($edit_reservation_data['reservation_description']) : ''; ?></p>

    <input type="hidden" name="reservation_description" value="<?php echo ($edit_reservation_data !== null) ? htmlspecialchars($edit_reservation_data['reservation_description']) : ''; ?>">


    <select name="event_status" class="p-2">
        <option value="1" <?php if ($edit_reservation_data !== null && $edit_reservation_data['event_status'] == '1') echo 'selected'; ?>>Patvirtintas</option>
        <option value="2" <?php if ($edit_reservation_data !== null && $edit_reservation_data['event_status'] == '2') echo 'selected'; ?>>Atmestas</option>
        <option value="3" <?php if ($edit_reservation_data === null || $edit_reservation_data['event_status'] == '3') echo 'selected'; ?>>Laukiamas patvirtinimo</option>
        <option value="4" <?php if ($edit_reservation_data !== null && $edit_reservation_data['event_status'] == '4') echo 'selected'; ?>>Įvygdyta</option>
    </select>

    <input type="text" class="p-2" name="event_target_audience" placeholder="<?php echo t("Audience");?>" value="<?php echo ($edit_reservation_data !== null) ? htmlspecialchars($edit_reservation_data['event_target_audience']) : ''; ?>">

    <input type="time" class="p-2" name="reserve_event_time" placeholder="<?php echo t("Reservation time");?>" value="<?php echo ($edit_reservation_data !== null) ? htmlspecialchars($edit_reservation_data['reserve_event_time']) : ''; ?>">
    <input type="date" class="p-2" name="reserve_date" placeholder="<?php echo t("Date");?>" value="<?php echo ($edit_reservation_data !== null) ? htmlspecialchars($edit_reservation_data['reserve_date']) : ''; ?>">
   
        <button type="submit" class="btn btn-primary"><?php echo t('Edit reservation'); ?></button>
        <button type="button" class="btn btn-light" onclick="cancelEdit()"><?php echo t('Cancel editing'); ?></button>

</form>

<?php } ?>

<table class="table table-sm mt-3">
        <thead>
            <tr>
                <th><?php echo t("No.");?></th>
                <th><?php echo t("Cabinet heads");?></th>
                <th><?php echo t("Event Title");?></th>
                <th><?php echo t("Audience");?></th>
                <th><?php echo t("Status");?></th>
                <th><?php echo t("Reservation time");?></th>
                <th><?php echo t("Date");?></th>
                <th><?php echo t("Additional information");?></th>
                <th><?php echo t("Actions");?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;
             foreach ($results as $row): ?>
                 <tr><!--$row['id'] -->
                    <td><?php echo $i.". "; ?></td>
                    <td><?php echo htmlspecialchars($row['laboratory_name']); ?></td> 
                    <td><?php echo htmlspecialchars($row['event_title']); ?></td> 
                    <td><?php echo htmlspecialchars($row['event_target_audience']); ?></td>
                    
                    <td>
                <?php 
                switch($row['event_status']) {
                    case '1':
                        echo "Patvirtintas";
                        break;
                    case '2':
                        echo "Atmestas";
                        break;
                    case '3':
                        echo "Laukiamas patvirtinimo";
                        break;
                    case '4':
                        echo "Įvygdyta";
                        break;
                    default:
                        echo "Nežinoma būsena";
                }
                ?>
            </td>
                    <td><?php echo htmlspecialchars($row['reserve_event_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['reserve_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['reservation_description']); ?></td>
                    <td>
                        <a href="addons_model.php?name=event_callendar&id=<?php echo htmlspecialchars($id); ?>&edit_reservation_id=<?php echo htmlspecialchars($row['id']); ?>"><i class="fa fa-edit"></i></a> |
                        <a href="#" onclick="confirmDelete4('../../cover/addons/event_callendar/action/delete_reservation.php?event_calendar&id=<?php echo htmlspecialchars($id); ?>&delete_reservation_id=<?php echo htmlspecialchars($row['id']) ?>')"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php 
            $i++; 
            endforeach; ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php for($i = 1; $i <= $pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?name=<?= htmlspecialchars($_GET['name']) ?>&id=<?= htmlspecialchars($_GET['id']) ?>&page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>