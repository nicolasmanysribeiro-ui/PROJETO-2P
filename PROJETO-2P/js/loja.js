// pega o carrinho salvo no navegador, se nao tiver nada devolve um objeto vazio
function pegarCarrinho() {
    return JSON.parse(localStorage.getItem('carrinho')) || {};
}

// guarda o carrinho no navegador e ja atualiza o contador
function salvarCarrinho(carrinho) {
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    atualizarContador();
}

// transforma numero em R$ 0,00
function moeda(valor) {
    return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

// soma itens e valor, mostra no topo e na barra de baixo
function atualizarContador() {
    const carrinho = pegarCarrinho();
    let itens = 0;
    let valor = 0;
    for (const id in carrinho) {
        itens += carrinho[id].qtd;
        valor += carrinho[id].qtd * carrinho[id].preco;
    }
    document.getElementById('contadorCarrinho').textContent = itens;

    // a barra so existe nas paginas de compra, na do carrinho nao
    const barra = document.getElementById('barraSacola');
    if (barra) {
        barra.classList.toggle('escondido', itens === 0);
        document.getElementById('barraItens').textContent = itens;
        document.getElementById('barraTotal').textContent = moeda(valor);
    }
}
atualizarContador();

// carrossel so roda se tiver slide na pagina
const slides = document.querySelectorAll('.slide');
if (slides.length > 0) {
    let atual = 0;

    // tira o ativo do slide de agora e coloca no novo, a conta com resto faz voltar pro comeco
    const mostrar = function (n) {
        slides[atual].classList.remove('ativo');
        atual = (n + slides.length) % slides.length;
        slides[atual].classList.add('ativo');
    };

    document.getElementById('anterior').onclick = function () { mostrar(atual - 1); };
    document.getElementById('proximo').onclick = function () { mostrar(atual + 1); };
    setInterval(function () { mostrar(atual + 1); }, 4000);
}

// pra cada produto da pagina liga os botoes de adicionar, mais e menos
document.querySelectorAll('.produto').forEach(function (card) {
    const id = card.dataset.id;
    const btnAdd = card.querySelector('.btn-adicionar');
    const controle = card.querySelector('.controle-qtd');
    const qtdSpan = card.querySelector('.qtd');

    // mostra o botao adicionar ou o controle de quantidade, depende se ja tem no carrinho
    function renderizar() {
        const carrinho = pegarCarrinho();
        const qtd = carrinho[id] ? carrinho[id].qtd : 0;
        qtdSpan.textContent = qtd;
        btnAdd.classList.toggle('escondido', qtd > 0);
        controle.classList.toggle('escondido', qtd === 0);
    }

    // soma ou tira quantidade, se chegar em zero tira o item do carrinho
    function mudar(delta) {
        const carrinho = pegarCarrinho();
        if (!carrinho[id]) {
            carrinho[id] = { nome: card.dataset.nome, preco: Number(card.dataset.preco), emoji: card.dataset.emoji, qtd: 0 };
        }
        carrinho[id].qtd += delta;
        if (carrinho[id].qtd <= 0) {
            delete carrinho[id];
        }
        salvarCarrinho(carrinho);
        renderizar();
    }

    btnAdd.onclick = function () { mudar(1); };
    card.querySelector('.btn-mais').onclick = function () { mudar(1); };
    card.querySelector('.btn-menos').onclick = function () { mudar(-1); };

    renderizar();
});
