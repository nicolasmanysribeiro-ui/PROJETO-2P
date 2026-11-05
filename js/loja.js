const contador = document.getElementById('contadorCarrinho');
const acoes = document.querySelectorAll('.acao-produto');

function atualizarContador() {
    let total = 0;
    acoes.forEach(function (acao) {
        total += Number(acao.dataset.quantidade);
    });
    contador.textContent = total;
}

acoes.forEach(function (acao) {
    const btnAdicionar = acao.querySelector('.btn-adicionar');
    const controle = acao.querySelector('.controle-qtd');
    const qtdSpan = acao.querySelector('.qtd');
    const btnMais = acao.querySelector('.btn-mais');
    const btnMenos = acao.querySelector('.btn-menos');

    function renderizar() {
        const quantidade = Number(acao.dataset.quantidade);
        qtdSpan.textContent = quantidade;
        btnAdicionar.classList.toggle('d-none', quantidade > 0);
        controle.classList.toggle('d-none', quantidade === 0);
        atualizarContador();
    }

    btnAdicionar.addEventListener('click', function () {
        acao.dataset.quantidade = 1;
        renderizar();
    });

    btnMais.addEventListener('click', function () {
        acao.dataset.quantidade = Number(acao.dataset.quantidade) + 1;
        renderizar();
    });

    btnMenos.addEventListener('click', function () {
        acao.dataset.quantidade = Math.max(0, Number(acao.dataset.quantidade) - 1);
        renderizar();
    });
});
