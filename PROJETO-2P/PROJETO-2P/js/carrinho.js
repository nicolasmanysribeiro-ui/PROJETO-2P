// valores da entrega
const TAXA_ENTREGA = 8;
const FRETE_GRATIS_ACIMA = 150;

// cupons que existem, o nome do cupom e a chave
const cupons = {
    PROMO10: { tipo: 'percentual', valor: 10, texto: '10% de desconto no total' },
    SHELFY5: { tipo: 'fixo', valor: 5, texto: 'R$ 5,00 de desconto' },
    FRETEGRATIS: { tipo: 'frete', valor: 0, texto: 'entrega grátis' }
};

// guardam o estado enquanto a pagina ta aberta
let cupomAtual = null;
let etapa = 1;

// atalho pra nao ficar escrevendo document.getElementById toda hora
function el(id) {
    return document.getElementById(id);
}

// arredonda pra 2 casas pra nao dar numero quebrado tipo 7.0000001
function arredondar(valor) {
    return Math.round(valor * 100) / 100;
}

function tipoEntrega() {
    return document.querySelector('input[name="entrega"]:checked').value;
}

function pagamentoEscolhido() {
    return document.querySelector('input[name="pagamento"]:checked').value;
}

function pegarMetodos() {
    return JSON.parse(localStorage.getItem('metodos')) || [];
}

// mostra o erro e rola a tela ate ele, pra pessoa ver onde errou
function mostrarErro(id, texto) {
    el(id).textContent = texto;
    if (texto !== '') {
        el(id).scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// troca a etapa: mostra so a atual e marca a barra de cima
function irParaEtapa(n) {
    etapa = n;
    for (let i = 1; i <= 4; i++) {
        el('etapa' + i).classList.toggle('escondido', i !== n);
        el('e' + i).classList.toggle('ativa', i === n);
        el('e' + i).classList.toggle('feita', i < n);
    }
    el('resumo').classList.toggle('escondido', n === 4);
    calcularResumo();
    window.scrollTo(0, 0);
}

// etapa 1: lista de itens com emoji, nome, preco, quantidade e total da linha
function mostrarItens() {
    const carrinho = pegarCarrinho();
    let html = '';
    for (const id in carrinho) {
        const item = carrinho[id];
        html += '<div class="item">' +
            '<div class="emoji-box">' + (item.emoji || '🛒') + '</div>' +
            '<div class="item-info"><strong>' + item.nome + '</strong><span>' + moeda(item.preco) + ' cada</span></div>' +
            '<div class="stepper">' +
            '<button type="button" onclick="mudarQtd(\'' + id + '\', -1)">−</button>' +
            '<span>' + item.qtd + '</span>' +
            '<button type="button" onclick="mudarQtd(\'' + id + '\', 1)">+</button>' +
            '</div>' +
            '<strong class="item-total">' + moeda(item.preco * item.qtd) + '</strong>' +
            '<button type="button" class="remover" aria-label="Remover item" onclick="mudarQtd(\'' + id + '\', -9999)">✕</button>' +
            '</div>';
    }
    if (html === '') {
        html = '<div class="vazio"><div class="emoji-grande">🛒</div><p>Sua sacola está vazia.</p><a href="index.php" class="btn">Ver promoções</a></div>';
    }
    el('listaItens').innerHTML = html;
    calcularResumo();
}

// muda a quantidade de um item e redesenha
function mudarQtd(id, delta) {
    const carrinho = pegarCarrinho();
    carrinho[id].qtd += delta;
    if (carrinho[id].qtd <= 0) {
        delete carrinho[id];
    }
    salvarCarrinho(carrinho);
    mostrarItens();
}

// faz as contas e atualiza o resumo, a barra de entrega gratis e o botao de fazer pedido
function calcularResumo() {
    const carrinho = pegarCarrinho();
    let subtotal = 0;
    let itens = 0;
    for (const id in carrinho) {
        subtotal += carrinho[id].preco * carrinho[id].qtd;
        itens += carrinho[id].qtd;
    }
    subtotal = arredondar(subtotal);

    let desconto = 0;
    if (cupomAtual) {
        const c = cupons[cupomAtual];
        if (c.tipo === 'percentual') { desconto = subtotal * c.valor / 100; }
        if (c.tipo === 'fixo') { desconto = Math.min(c.valor, subtotal); }
    }
    desconto = arredondar(desconto);

    // entrega e gratis acima do valor ou com o cupom de frete
    const baseFrete = subtotal - desconto;
    const gratis = baseFrete >= FRETE_GRATIS_ACIMA || cupomAtual === 'FRETEGRATIS';
    const taxa = (gratis || subtotal === 0) ? 0 : TAXA_ENTREGA;

    // a taxa so entra na conta quando a pessoa escolhe entrega na etapa 3
    let frete = 0;
    if (etapa >= 3 && tipoEntrega() === 'entrega') {
        frete = taxa;
    }

    const total = arredondar(subtotal - desconto + frete);

    // barra de progresso da entrega gratis
    let porcentagem = Math.min(100, baseFrete / FRETE_GRATIS_ACIMA * 100);
    let mensagem = 'Faltam ' + moeda(FRETE_GRATIS_ACIMA - baseFrete) + ' para entrega grátis';
    if (subtotal === 0) {
        mensagem = 'Entrega grátis em compras acima de ' + moeda(FRETE_GRATIS_ACIMA);
    }
    if (gratis) {
        porcentagem = 100;
        mensagem = '🎉 Você ganhou entrega grátis!';
    }
    el('msgFrete').textContent = mensagem;
    el('barraProgresso').style.width = porcentagem + '%';

    el('rItens').textContent = itens;
    el('rSubtotal').textContent = moeda(subtotal);
    el('rDesconto').textContent = '- ' + moeda(desconto);

    // antes da etapa 3 mostra a estimativa, assim ninguem leva susto no final
    if (etapa < 3) {
        el('rFrete').textContent = gratis ? 'Grátis' : moeda(TAXA_ENTREGA) + ' na entrega, grátis na retirada';
    } else if (tipoEntrega() === 'retirada') {
        el('rFrete').textContent = 'Retirada grátis';
    } else {
        el('rFrete').textContent = frete === 0 ? 'Grátis' : moeda(frete);
    }
    el('rTotalLabel').textContent = etapa < 3 ? 'Total sem entrega' : 'Total';
    el('rTotal').textContent = moeda(total);
    el('tagEntrega').textContent = taxa === 0 ? 'Grátis' : moeda(taxa);
    el('btnConfirmar').textContent = 'Fazer pedido • ' + moeda(total);

    return { subtotal: subtotal, desconto: desconto, frete: frete, total: total, itens: itens };
}

// cupom: aplica se existir
function aplicarCupom(codigo) {
    codigo = codigo.trim().toUpperCase();
    if (!cupons[codigo]) {
        cupomAtual = null;
        el('msgCupom').textContent = 'Cupom inválido.';
    } else {
        cupomAtual = codigo;
        el('msgCupom').textContent = '✅ Cupom ' + codigo + ' aplicado: ' + cupons[codigo].texto + '.';
    }
    calcularResumo();
}
el('btnCupom').onclick = function () { aplicarCupom(el('codigoCupom').value); };

function mostrarCupons() {
    let html = '';
    for (const codigo in cupons) {
        html += '<button type="button" class="btn escuro" onclick="aplicarCupom(\'' + codigo + '\')">' + codigo + '<small>' + cupons[codigo].texto + '</small></button>';
    }
    el('listaCupons').innerHTML = html;
}

// botao continuar da etapa 1, so deixa passar se tiver item
el('btnContinuar1').onclick = function () {
    if (Object.keys(pegarCarrinho()).length === 0) {
        mostrarErro('msgItens', 'Sua sacola está vazia. Adicione algum produto.');
        return;
    }
    mostrarErro('msgItens', '');
    irParaEtapa(2);
};

// etapa 2: se ja tem cadastro salvo preenche os campos
function carregarCadastro() {
    const c = JSON.parse(localStorage.getItem('cliente'));
    if (c) {
        el('nome').value = c.nome;
        el('email').value = c.email;
        el('telefone').value = c.telefone;
    }
}

el('btnVoltar2').onclick = function () { irParaEtapa(1); };

// valida o cadastro, salva no navegador e vai pra etapa 3
el('btnSalvarCadastro').onclick = function () {
    const nome = el('nome').value.trim();
    const email = el('email').value.trim();
    const telefone = el('telefone').value.trim();
    if (nome === '' || email === '' || telefone === '') {
        mostrarErro('msgCadastro', 'Preencha nome, e-mail e telefone.');
        return;
    }
    if (!email.includes('@')) {
        mostrarErro('msgCadastro', 'Esse e-mail parece inválido.');
        return;
    }
    localStorage.setItem('cliente', JSON.stringify({ nome: nome, email: email, telefone: telefone }));
    mostrarErro('msgCadastro', '');
    irParaEtapa(3);
};

// etapa 3: mostra o endereco so se escolher entrega
el('opcoesEntrega').onchange = function () {
    el('blocoEntrega').classList.toggle('escondido', tipoEntrega() !== 'entrega');
    calcularResumo();
};

// pede a localizacao pro navegador, pega so latitude e longitude, o endereco continua na mao
el('btnLocal').onclick = function () {
    if (!navigator.geolocation) {
        el('msgLocal').textContent = 'Seu navegador não suporta localização.';
        return;
    }
    el('msgLocal').textContent = 'Buscando...';
    navigator.geolocation.getCurrentPosition(function (pos) {
        el('msgLocal').textContent = 'Localização: ' + pos.coords.latitude.toFixed(5) + ', ' + pos.coords.longitude.toFixed(5) + '. Confira o endereço abaixo.';
    }, function () {
        el('msgLocal').textContent = 'Não consegui pegar, preencha o endereço abaixo.';
    });
};

// nome do metodo, nunca mostra o numero inteiro do cartao
function nomeMetodo(m) {
    if (m.tipo === 'pix') { return 'Pix'; }
    return (m.tipo === 'credito' ? 'Crédito' : 'Débito') + ' final ' + m.final;
}

// emoji de cada tipo de pagamento
function iconeMetodo(tipo) {
    return tipo === 'pix' ? '💠' : '💳';
}

// monta um cartao clicavel de forma de pagamento
function opcaoPag(valor, icone, titulo, sub, tag, botao, marcado) {
    return '<label class="opcao"><input type="radio" name="pagamento" value="' + valor + '"' + (marcado ? ' checked' : '') + '>' +
        '<span class="icone">' + icone + '</span>' +
        '<span class="texto"><strong>' + titulo + '</strong><small>' + sub + '</small></span>' +
        (tag !== '' ? '<span class="tag">' + tag + '</span>' : '') + botao + '</label>';
}

// desenha primeiro os metodos salvos, depois as opcoes novas, a primeira da lista ja vem marcada
function mostrarPagamentos() {
    const lista = pegarMetodos();
    let html = '';
    let primeiro = true;

    lista.forEach(function (m, i) {
        const sub = m.tipo === 'pix' ? 'Pagamento na hora pelo app do banco' : m.titular + ', validade ' + m.validade;
        const botao = '<button type="button" class="remover" aria-label="Remover método" onclick="removerSalvo(' + i + ', event)">✕</button>';
        html += opcaoPag('s' + i, iconeMetodo(m.tipo), nomeMetodo(m), sub, 'Salvo', botao, primeiro);
        primeiro = false;
    });

    if (!lista.some(function (m) { return m.tipo === 'pix'; })) {
        html += opcaoPag('pix', '💠', 'Pix', 'Aprovação na hora', '', '', primeiro);
        primeiro = false;
    }
    html += opcaoPag('credito', '💳', 'Cartão de crédito', 'Adicionar novo cartão', '', '', primeiro);
    html += opcaoPag('debito', '💳', 'Cartão de débito', 'Adicionar novo cartão', '', '', false);

    el('opcoesPag').innerHTML = html;
    atualizarPagamento();
}

// mostra os campos certos de acordo com o que ta marcado
function atualizarPagamento() {
    const v = pagamentoEscolhido();
    const cartao = v === 'credito' || v === 'debito';
    el('blocoCartao').classList.toggle('escondido', !cartao);
    el('blocoPixInfo').classList.toggle('escondido', v !== 'pix');
    el('blocoSalvar').classList.toggle('escondido', !(cartao || v === 'pix'));
}
el('opcoesPag').onchange = atualizarPagamento;

// remove um metodo salvo, o preventDefault evita marcar o radio ao clicar no botao
function removerSalvo(i, ev) {
    ev.preventDefault();
    const lista = pegarMetodos();
    lista.splice(i, 1);
    localStorage.setItem('metodos', JSON.stringify(lista));
    mostrarPagamentos();
}

function salvarMetodo(metodo) {
    const lista = pegarMetodos();
    lista.push(metodo);
    localStorage.setItem('metodos', JSON.stringify(lista));
}

el('btnVoltar3').onclick = function () { irParaEtapa(2); };

// fazer pedido: valida entrega e pagamento e se passar vai pra etapa 4
el('btnConfirmar').onclick = function () {
    mostrarErro('msgErro', '');

    if (tipoEntrega() === 'entrega') {
        if (el('rua').value.trim() === '' || el('numero').value.trim() === '' || el('cidade').value.trim() === '') {
            mostrarErro('msgErro', 'Preencha rua, número e cidade para a entrega.');
            return;
        }
    }

    const v = pagamentoEscolhido();
    let pagamento;
    if (v.charAt(0) === 's') {
        pagamento = pegarMetodos()[Number(v.slice(1))];
    } else if (v === 'pix') {
        pagamento = { tipo: 'pix' };
    } else {
        const numero = el('numCartao').value.replace(/\s/g, '');
        if (numero.length < 13 || isNaN(numero)) {
            mostrarErro('msgErro', 'Número do cartão inválido.');
            return;
        }
        if (el('titular').value.trim() === '' || el('validade').value.trim() === '' || el('cvv').value.length < 3) {
            mostrarErro('msgErro', 'Preencha nome, validade e CVV do cartão.');
            return;
        }
        pagamento = { tipo: v, final: numero.slice(-4), titular: el('titular').value.trim(), validade: el('validade').value.trim() };
    }

    if (v.charAt(0) !== 's' && el('salvarMetodo').checked) {
        salvarMetodo(pagamento);
    }

    mostrarConfirmacao(pagamento);
};

// copia o codigo pix, se o navegador nao deixar avisa
function copiarPix(codigo) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(codigo);
        el('msgCopia').textContent = 'Código copiado!';
    } else {
        el('msgCopia').textContent = 'Selecione o código e copie na mão.';
    }
}

// etapa 4: tela do pedido com status, previsao, itens e total
function mostrarConfirmacao(pagamento) {
    const resumo = calcularResumo();
    const carrinho = pegarCarrinho();
    const cliente = JSON.parse(localStorage.getItem('cliente'));
    const numeroPedido = Math.floor(Math.random() * 90000) + 10000;
    const retirada = tipoEntrega() === 'retirada';
    const pix = pagamento.tipo === 'pix';

    let itens = '';
    for (const id in carrinho) {
        itens += '<div class="linha"><span>' + carrinho[id].qtd + 'x ' + carrinho[id].nome + '</span><span>' + moeda(carrinho[id].preco * carrinho[id].qtd) + '</span></div>';
    }

    let local = '🏪 Retirada na Shelfy, Av. Principal, 100, Ponta Grossa';
    if (!retirada) {
        local = '🛵 Entrega em ' + el('rua').value + ', ' + el('numero').value + ', ' + el('bairro').value + ', ' + el('cidade').value;
    }
    const previsao = retirada ? 'Pronto em 20 a 30 min' : 'Chega em 40 a 60 min';

    // status do pedido, igual ifood: com pix fica aguardando pagamento primeiro
    const passo1 = pix ? '⏳<br>Aguardando pagamento' : '✅<br>Pedido recebido';
    const passo3 = retirada ? '🏪<br>Pronto para retirada' : '🛵<br>Saiu para entrega';

    let blocoPix = '';
    if (pix) {
        const codigo = '00020126SHELFY' + numeroPedido + '5204000053039865802BR6007PONTAGROSSA6304ABCD';
        blocoPix = '<div class="pix-box"><h3>Pague com Pix em até 10 minutos</h3>' +
            '<p class="pix-codigo">' + codigo + '</p>' +
            '<button type="button" class="btn" onclick="copiarPix(\'' + codigo + '\')">Copiar código Pix</button>' +
            '<p id="msgCopia"></p></div>';
    }

    el('etapa4').innerHTML =
        '<div class="sucesso"><div class="emoji-grande">🎉</div><h2>Pedido feito, ' + cliente.nome.split(' ')[0] + '!</h2>' +
        '<p>Pedido <strong>#' + numeroPedido + '</strong> • ' + previsao + '</p></div>' +
        '<div class="tracker">' +
        '<div class="passo ativo">' + passo1 + '</div>' +
        '<div class="passo">👨‍🍳<br>Separando</div>' +
        '<div class="passo">' + passo3 + '</div></div>' +
        blocoPix +
        '<h3>Resumo do pedido</h3>' + itens +
        '<div class="linha"><span>Desconto</span><span>- ' + moeda(resumo.desconto) + '</span></div>' +
        '<div class="linha"><span>Entrega</span><span>' + (resumo.frete === 0 ? 'Grátis' : moeda(resumo.frete)) + '</span></div>' +
        '<div class="linha total"><span>Total</span><span>' + moeda(resumo.total) + '</span></div>' +
        '<p class="dica">' + local + '</p>' +
        '<p class="dica">Pagamento: ' + nomeMetodo(pagamento) + '</p>' +
        '<br><a href="index.php" class="btn">Voltar para o início</a>';

    localStorage.removeItem('carrinho');
    atualizarContador();
    irParaEtapa(4);
}

// ao abrir a pagina
carregarCadastro();
mostrarItens();
mostrarCupons();
mostrarPagamentos();
irParaEtapa(1);
