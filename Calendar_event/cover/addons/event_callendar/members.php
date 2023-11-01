<?php
$perPage = 15; // Įrašų skaičius viename puslapyje
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

$sqlTotal = "SELECT COUNT(*) FROM " . $prefix['table_prefix'] . "_callendar_users_member";
$stmtTotal = $db->prepare($sqlTotal);
$stmtTotal->execute();
$totalRecords = $stmtTotal->fetchColumn();
$pages = ceil($totalRecords / $perPage);

$sql = "SELECT * FROM " . $prefix['table_prefix'] . "_callendar_users_member LIMIT $offset, $perPage";
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
 <table class="table table-sm">
        <thead>
            <tr>
                <th><?php echo t("No.");?></th>
                <th><?php echo t("Login Name");?></th>
                <th><?php echo t("Member User");?></th>
                <th><?php echo t("Telephone");?></th>
                <th><?php echo t("Email");?></th>
                <th><?php echo t("Institution");?></th>
                <th><?php echo t("Position");?></th>
                <th><?php echo t("Actions");?></th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;
            foreach ($results as $row): ?>
                <tr>
                    <td><?php echo $i.". "; ?></td>
                    <td><?php echo htmlspecialchars($row['member_login_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['member_first_name'] . ' ' . $row['member_last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['member_telephone']); ?></td>
                    <td><?php echo htmlspecialchars($row['member_email']); ?></td>
                    <td><?php echo htmlspecialchars($row['member_institution']); ?></td>
                    <td><?php echo htmlspecialchars($row['member_employee_position']); ?></td>
                    <td>
                        <a href="addons_model.php?name=event_callendar&id=<?php echo htmlspecialchars($id); ?>&edit_member_id=<?php echo htmlspecialchars($row['id']); ?>"><i class="fa fa-edit"></i></a> |
                        <a href="#" onclick="confirmDelete4('../../cover/addons/event_callendar/action/delete_member.php?event_calendar&id=<?php echo htmlspecialchars($id); ?>&delete_member_id=<?php echo htmlspecialchars($row['id']) ?>')"><i class="fa fa-trash"></i></a>
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