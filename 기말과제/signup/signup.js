document.getElementById('signupForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const email = document.getElementById('email').value;

    if (password !== confirmPassword) {
        alert('비밀번호가 일치하지 않습니다.');
        return;
    }

    if (!username || !password || !email) {
        alert('모든 필드를 입력해주세요.');
        return;
    }

    // TODO: 서버와 통신 코드 추가
    alert('회원가입 시도 중...');
});
