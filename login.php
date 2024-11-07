<?php
// 데이터베이스 연결 정보
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "user_database";

// MySQL 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 폼 데이터 받기
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // 이메일을 기준으로 사용자 찾기
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // 사용자 정보가 존재하면
        $user = $result->fetch_assoc();
        $stored_password = $user['password']; // 데이터베이스에 저장된 평문 비밀번호

        // 평문 비밀번호 비교
        if ($pass === $stored_password) {
            // 로그인 성공, 세션 시작
            session_start();
            $_SESSION['user_id'] = $user['id']; // 로그인한 사용자 ID 저장
            $_SESSION['username'] = $user['username']; // 사용자 이름 저장
            
            // 홈 페이지로 리디렉션
            header("Location: index.html");
            exit;
        } else {
            echo "비밀번호가 일치하지 않습니다.";
        }
    } else {
        echo "이메일이 존재하지 않습니다.";
    }

    $stmt->close();
}

$conn->close();
?>
