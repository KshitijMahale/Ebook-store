<?php
session_start();
if (!isset($_SESSION['user_id'])){
	header("Location: login.php");
}

# Database Connection File
include "db_conn.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the message ID is set
    if (isset($_POST['message_id'])) {
        $message_id = intval($_POST['message_id']);

        // Prepare and execute SQL statement to delete the message
        $sql = "DELETE FROM contact_messages WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$message_id]);

        // Check if the message was deleted successfully
        if ($stmt->rowCount() > 0) {
            $_SESSION['delete_success'] = "Message deleted successfully.";
        } else {
            $_SESSION['delete_success'] = "Failed to delete message. Message not found.";
        }

        // Redirect back to this page to display the result
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        // Message ID is not set
        $_SESSION['delete_success'] = "Error: Message ID is not set.";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}

# Fetch messages from the database using PDO
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$stmt = $conn->query($sql);

# Check if there are any messages
if ($stmt !== false) {
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $messages = [];
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img//book-open-reader-solid (1).svg" />
    <title>BookHauler - Messages</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .message-card {
            flex: 1 1 300px; /* grow and shrink */
            max-width: calc(25% - 1rem);
            margin-right: 1rem;
            margin-bottom: 1rem;

        }

        .message-body {
            max-height: 15rem;
            overflow-y: auto; 
        }

        @media (max-width: 575.98px) {
            /* For small screens, display messages in a single column */
            .message-card {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include "admin-header.html"; ?>
        <?php if (isset($_SESSION['delete_success'])) : ?>
            <div class="alert alert-success" role="alert">
                <?= $_SESSION['delete_success'] ?>
            </div>
            <?php unset($_SESSION['delete_success']); ?>
        <?php endif; ?>
        <h1 class="text-center pb-5 display-4 fs-3" style="margin-top:4rem;"><b>Messages</b></h1>
        <div class="d-flex flex-wrap">
            <?php if (!empty($messages)) : ?>
                <?php foreach ($messages as $message) : ?>
                    <div class="card message-card shadow">
                        <div class="card-body message-body">
                            <h5 class="card-title"><?= htmlspecialchars($message['name']) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($message['email']) ?></h6><hr>
                            <p class="card-text"><?= htmlspecialchars($message['message']) ?></p>
                            <small class="text-muted"><?= htmlspecialchars($message['created_at']) ?></small>
                            <!-- Delete button -->
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display: inline; margin-left: 1rem">
                                <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No messages found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
