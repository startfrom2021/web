<?php
session_start();
require_once 'db.php';

// 로그인 체크
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// 게시물 목록 가져오기
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

// 게시물 목록 배열로 저장
$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 8px 12px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f4f4f4; }
        .btn { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .btn:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <h1 style="text-align: center;">게시판</h1>
    <p style="text-align: center;">안녕하세요, <?php echo $_SESSION['username']; ?>님!</p>

    <table>
        <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>작성일자</th>
                <th>조회수</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
            <tr>
                <td><?php echo $post['id']; ?></td>
                <td><a href="view-post.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></td>
                <td><?php echo $post['author']; ?></td>
                <td><?php echo $post['created_at']; ?></td>
                <td><?php echo $post['views']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="text-align: center;">
        <button class="btn" onclick="window.location.href='create-post.php'">새 게시물 작성</button>
    </div>
</body>
</html>

<?php
$conn->close();
?>
