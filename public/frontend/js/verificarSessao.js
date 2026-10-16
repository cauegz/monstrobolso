async function verificarSessao() {
    try {
        const r = await fetch('http://localhost:8080/api/me', { credentials: 'include' });
        const d = await r.json();
        console.log(r)
        console.log(d)
        if (!(r.ok && d.ok)) {
            window.location.href = 'login.html';
        } 
    } catch (e) {
        console.error(e);
    }
}

export default verificarSessao;