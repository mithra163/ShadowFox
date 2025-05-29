<?php
include 'db.php';

$uploadSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $teacher = $_POST['teacher'];
    $passkey = $_POST['passkey'];
    $file = $_FILES['file'];

    if (!file_exists('files')) {
        mkdir('files', 0777, true);
    }

    if ($file['error'] === 0) {
        $filename = basename($file['name']);
        $filepath = 'files/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $stmt = $pdo->prepare("INSERT INTO fi (filename, filepath, subject, teacher, passkey) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$filename, $filepath, $subject, $teacher, $passkey]);
            $uploadSuccess = true;
        } else {
            echo "<script>alert('Failed to upload file.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Error uploading file.'); window.history.back();</script>";
        exit;
    }
}
?>

<?php if ($uploadSuccess): ?>
<!DOCTYPE html>
<html>
<head>
    <title>Uploading...</title>
    <script>
        window.onload = function() {
            alert("File uploaded successfully!");
            setTimeout(function() {
                window.location.href = "again.html"; 
            }, 3000);
        };
    </script>
</head>
<body>
    <p style="text-align: center; margin-top: 50px;">Please wait... Redirecting.</p>
</body>
</html>
<?php endif; ?>
