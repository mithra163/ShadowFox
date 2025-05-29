<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $passkey = $_POST['passkey'];

    $stmt = $pdo->prepare("SELECT * FROM fi WHERE subject = ? AND passkey = ?");
    $stmt->execute([$subject, $passkey]);
    $files = $stmt->fetchAll();

    if (count($files) > 0) {
        echo "
        <style>
            body {
                font-family: 'Segoe UI', sans-serif;
                background: linear-gradient(to right, #f0f8ff, #ffffff);
                padding: 30px;
                color: #333;
            }
            h2 {
                text-align: center;
                color: #2c3e50;
                margin-bottom: 30px;
            }
            .file-card {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 6px 12px rgba(0,0,0,0.1);
                padding: 20px;
                margin: 15px auto;
                width: 80%;
                transition: 0.3s;
            }
            .file-card:hover {
                transform: scale(1.02);
            }
            .file-title {
                font-size: 1.2em;
                font-weight: bold;
                color: #0077cc;
                text-decoration: none;
            }
            .file-title:hover {
                text-decoration: underline;
            }
            .teacher {
                color: #777;
                font-size: 0.95em;
                margin-top: 5px;
            }
        </style>
        ";

        echo "<h2>📂 Files for Subject: <em>$subject</em></h2>";

        foreach ($files as $file) {
            $filename = htmlspecialchars($file['filename']);
            $filepath = htmlspecialchars($file['filepath']);
            $teacher = htmlspecialchars($file['teacher']);

            echo "
            <div class='file-card'>
                <a class='file-title' href='$filepath' download>📥 $filename</a>
                <p class='teacher'>Uploaded by: <strong>$teacher</strong></p>
            </div>";
        }
    } else {
        echo "
        <style>
            body {
                font-family: 'Segoe UI', sans-serif;
                background-color: #fff3f3;
                color: #cc0000;
                text-align: center;
                padding-top: 50px;
            }
            .error-msg {
                font-size: 1.2em;
                background: #ffe6e6;
                display: inline-block;
                padding: 20px 30px;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(255,0,0,0.1);
            }
        </style>
        <div class='error-msg'>❌ Invalid passkey or no files available.</div>";
    }
}
?>
