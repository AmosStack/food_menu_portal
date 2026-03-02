<?php
session_start();
include "connection.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$config = include __DIR__ . '/google-oauth-config.php';
$googleClientId = trim($config['google_client_id'] ?? '');

if ($googleClientId === '') {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Google OAuth is not configured.']);
    exit;
}

$requestBody = json_decode(file_get_contents('php://input'), true);
$credentialToken = trim($requestBody['credential'] ?? '');

if ($credentialToken === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing Google credential token.']);
    exit;
}

$tokenInfoUrl = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($credentialToken);
$tokenInfoRaw = @file_get_contents($tokenInfoUrl);

if ($tokenInfoRaw === false && function_exists('curl_init')) {
    $curlHandle = curl_init($tokenInfoUrl);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlHandle, CURLOPT_TIMEOUT, 10);
    $tokenInfoRaw = curl_exec($curlHandle);
    curl_close($curlHandle);
}

if (!$tokenInfoRaw) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unable to verify Google token.']);
    exit;
}

$tokenInfo = json_decode($tokenInfoRaw, true);

if (!is_array($tokenInfo) || isset($tokenInfo['error_description'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid Google token.']);
    exit;
}

if (($tokenInfo['aud'] ?? '') !== $googleClientId) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Google token audience mismatch.']);
    exit;
}

$emailVerified = $tokenInfo['email_verified'] ?? false;
if (!in_array($emailVerified, [true, 'true', 1, '1'], true)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Google email is not verified.']);
    exit;
}

$userEmail = strtolower(trim($tokenInfo['email'] ?? ''));
if ($userEmail === '') {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Google account email is missing.']);
    exit;
}

$displayName = trim($tokenInfo['name'] ?? $tokenInfo['given_name'] ?? '');
if ($displayName === '') {
    $displayName = strtok($userEmail, '@');
}

$findUserStatement = $conn->prepare("SELECT id, username FROM tbl_users WHERE email = ? LIMIT 1");
$findUserStatement->bind_param("s", $userEmail);
$findUserStatement->execute();
$userResult = $findUserStatement->get_result();

if ($userResult && $userResult->num_rows > 0) {
    $existingUser = $userResult->fetch_assoc();
    $_SESSION['id'] = $existingUser['id'];
    $_SESSION['username'] = $existingUser['username'];

    echo json_encode(['success' => true, 'redirect' => 'userpage.php']);
    exit;
}

$baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '', $displayName)));
if ($baseUsername === '') {
    $baseUsername = 'user';
}

$generatedUsername = substr($baseUsername, 0, 20);
$counter = 1;

while (true) {
    $usernameCheckStatement = $conn->prepare("SELECT id FROM tbl_users WHERE username = ? LIMIT 1");
    $usernameCheckStatement->bind_param("s", $generatedUsername);
    $usernameCheckStatement->execute();
    $usernameCheckResult = $usernameCheckStatement->get_result();

    if ($usernameCheckResult->num_rows === 0) {
        break;
    }

    $generatedUsername = substr($baseUsername, 0, 16) . $counter;
    $counter++;
}

$randomPasswordHash = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
$insertUserStatement = $conn->prepare("INSERT INTO tbl_users (username, email, password) VALUES (?, ?, ?)");
$insertUserStatement->bind_param("sss", $generatedUsername, $userEmail, $randomPasswordHash);

if (!$insertUserStatement->execute()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Unable to create user account.']);
    exit;
}

$_SESSION['id'] = $insertUserStatement->insert_id;
$_SESSION['username'] = $generatedUsername;

echo json_encode(['success' => true, 'redirect' => 'userpage.php']);
