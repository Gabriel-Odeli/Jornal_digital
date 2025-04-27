const botaoCompartilhar = document.getElementById('botao-compartilhar');

botaoCompartilhar.addEventListener('click', async () => {
    if (navigator.share) {
        try {
            await navigator.share({
                title: document.title,
                text: "Confira essa reportagem incrível!",
                url: window.location.href
            });
            console.log('Reportagem compartilhada com sucesso!');
        } catch (error) {
            console.error('Erro ao compartilhar:', error);
        }
    } else {
        alert('Compartilhamento não suportado neste dispositivo. Copie o link manualmente: ' + window.location.href);
    }
});

// Barra de progresso
window.onscroll = function() {
    const barra = document.getElementById('barra-progresso');
    const scrollTotal = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrollAtual = document.documentElement.scrollTop;
    const porcentagem = (scrollAtual / scrollTotal) * 100;
    barra.style.width = porcentagem + "%";
}