document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (!username || !password) {
        alert('아이디와 비밀번호를 입력해주세요.');
        return;
    }

    // TODO: 서버와 통신 코드 추가
    alert('로그인 시도 중...');
});
