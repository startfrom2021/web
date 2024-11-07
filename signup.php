<?php
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
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // 중복 이메일 체크
    $sql_check = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql_check);
    
    if ($result->num_rows > 0) {
        echo "이메일이 이미 존재합니다.";
    } else {
        // 회원가입 SQL 쿼리 (비밀번호 해시 처리 없이 평문으로 저장)
        $sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$pass')";
        
        if ($conn->query($sql) === TRUE) {
            // 회원가입 성공 후 login.html로 리디렉션
            header("Location: login.html");
            exit; // 추가: header 호출 후 스크립트 종료
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
