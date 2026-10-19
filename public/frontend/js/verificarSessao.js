async function verificarSessao() {
    try {
        const response = await fetch('http://localhost:8080/api/me', { credentials: 'include' });
        const user = await response.json();
        if (!(response.ok && user.ok)) {
            window.location.href = 'login.html';
        } 
        return user;
    } catch (e) {
        console.error(e);
    }
}

export default verificarSessao;