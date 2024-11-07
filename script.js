document.getElementById('signupForm').addEventListener('submit', function(event) {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // 유효성 검사: 이메일 형식 체크
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        event.preventDefault(); // 폼 제출 막기
        document.getElementById('message').innerText = '유효한 이메일을 입력하세요.';
        return;
    }

    // 비밀번호 길이 확인
    if (password.length < 6) {
        event.preventDefault();
        document.getElementById('message').innerText = '비밀번호는 6자리 이상이어야 합니다.';
        return;
    }

    document.getElementById('message').innerText = ''; // 성공 시 메시지 초기화
});
