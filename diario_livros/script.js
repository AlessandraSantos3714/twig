document.querySelector('form').addEventListener('submit', function(e) {
    
    const titulo = document.getElementById('titulo');
    const autor = document.getElementById('autor');
    const avaliacao = document.getElementById('avaliacao');

    if (titulo && titulo.value.trim() === '') {
        e.preventDefault();
        alert('Por favor, preencha o título do livro!');
    } else if (autor && autor.value.trim() === '') {
        e.preventDefault();
        alert('Por favor, preencha o autor do livro!');
    } else if (avaliacao && avaliacao.value === '') {
        e.preventDefault();
        alert('Por favor, selecione uma avaliação!');
    }

    const nome = document.getElementById('nome');
    const senha = document.getElementById('senha');
    const confirmar = document.getElementById('confirmar');

    if (nome && nome.value.trim() === '') {
        e.preventDefault();
        alert('Por favor, preencha o nome!');
    } else if (senha && senha.value.length < 6) {
        e.preventDefault();
        alert('A senha deve ter pelo menos 6 caracteres!');
    } else if (confirmar && senha.value !== confirmar.value) {
        e.preventDefault();
        alert('As senhas não coincidem!');
    }

    const email = document.getElementById('email');
    if (email && email.value.trim() === '') {
        e.preventDefault();
        alert('Por favor, preencha o email!');
    }
});