<?php
session_start();
require_once '../../models/ApplicationModel.php';
require_once '../../controllers/ApplicationController.php';

$applicationModel = new ApplicationModel();
$applications = $applicationModel->getAllApplications(); // Assuming this method exists in the model
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Drop Applications</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h2>Drop Applications</h2>
    <table>
        <thead>
            <tr>
                <th>Application ID</th>
                <th>Student ID</th>
                <th>Status</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applications as $application): ?>
                <tr>
                    <td><?php echo htmlspecialchars($application['application_id']); ?></td>
                    <td><?php echo htmlspecialchars($application['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($application['status']); ?></td>
                    <td><?php echo htmlspecialchars($application['comment']); ?></td>
                    <td>
                        <form action="../../controllers/ApplicationController.php" method="POST">
                            <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($application['application_id']); ?>">
                            <button type="submit" name="status" value="accept">Accept</button>
                            <button type="submit" name="status" value="reject">Reject</button>
                            <textarea name="comment" placeholder="Add comment if rejecting"></textarea>
                            <button id="fetchApplications">Fetch Applications</button>
                            <div id="applicationsList"></div>

                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
