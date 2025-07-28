<?php
// ⏱ Start Output
header('Content-Type: application/json');

// 📦 Get current folder name (like IND-FEMALE)
$folder = basename(__DIR__);

// 🖼️ Full path to current folder
$folderPath = __DIR__;

// 🔍 Get all images (jpg, png, webp)
$images = array_filter(scandir($folderPath), function($file) use ($folderPath) {
    return is_file("$folderPath/$file") && preg_match('/\.(jpg|jpeg|png|webp)$/i', $file);
});

// ❌ If no images found
if (empty($images)) {
    http_response_code(404);
    echo json_encode([
        'error' => '❌ No images found in this folder.',
        'folder' => $folder
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// 🎯 Select random image
$randomImage = $images[array_rand($images)];

// 🌐 Dynamically detect domain (with protocol)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$baseURL = "$protocol://$host/$folder";

// 🖼️ Full image URL
$imageURL = "$baseURL/$randomImage";
$imageSize = filesize("$folderPath/$randomImage");

// 🧠 Extract country/gender
$gender = stripos($folder, 'FEMALE') !== false ? 'Female' : 'Male';
$country = stripos($folder, 'US') !== false ? 'United States' : 'India';

// ✅ JSON Output
echo json_encode([
    'student_image' => $imageURL,
    'student_type' => 'College Student',
    'format' => 'Passport',
    'gender' => $gender,
    'country' => $country,
    'size_bytes' => $imageSize,
    'image_file' => $randomImage,
    'folder' => $folder,
    'owner' => 'TELEGRAM - @kunwarviren7',
    'generated_at' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
