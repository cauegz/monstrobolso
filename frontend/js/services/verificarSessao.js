async function verificarSessao() {
    try {
        const response = await fetch('/api/me', { credentials: 'include' });
        const user = await response.json();
        if (!(response.ok && user.ok)) {
            window.location.href = '/pages/login.html';
        } 
        return user;
    } catch (e) {
        console.error(e);
    }
}

export default verificarSessao;