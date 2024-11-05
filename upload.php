<?php
$mainUploadDir = 'uploads/';
$folders = [
    'images' => ['jpg', 'jpeg', 'png', 'gif'],
    'videos' => ['mp4', 'avi', 'mkv'],
    'audios' => ['mp3', 'wav'],
    'documents' => ['pdf', 'docx', 'txt'],
    'others' => []
];

// التأكد من إنشاء مجلدات حسب نوع الملف
foreach ($folders as $folder => $extensions) {
    if (!is_dir($mainUploadDir . $folder)) {
        mkdir($mainUploadDir . $folder, 0777, true);
    }
}

// رفع الملف
if (isset($_FILES['file'])) {
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $folder = 'others';
    foreach ($folders as $key => $extensions) {
        if (in_array($fileExt, $extensions)) {
            $folder = $key;
            break;
        }
    }

    $fileDestination = $mainUploadDir . $folder . '/' . $fileName;
    if (move_uploaded_file($fileTmpName, $fileDestination)) {
        echo json_encode(["status" => "success", "message" => "تم رفع الملف بنجاح."]);
    } else {
        echo json_encode(["status" => "error", "message" => "حدث خطأ أثناء رفع الملف."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "لم يتم تحميل أي ملف."]);
}
?>