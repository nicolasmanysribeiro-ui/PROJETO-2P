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

function tipoEntrega() {
    return document.querySelector('input[name="entrega"]:checked').value;
}

function pagamentoEscolhido() {
    return document.querySelector('input[name="pagamento"]:checked').value;
}

function pegarMetodos() {
    return JSON.parse(localStorage.getItem('metodos')) || [];
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

// etapa 1: desenha os itens estilo ifood, com foto, preco, quantidade e total da linha
function mostrarItens() {
    const carrinho = pegarCarrinho();
    let html = '';
    for (const id in carrinho) {
        const item = carrinho[id];
        html += '<div class="item">' +
            '<img src="img/' + item.img + '" alt="' + item.nome + '">' +
            '<span class="item-nome"><strong>' + item.nome + '</strong><br>' + moeda(item.preco) + ' cada</span>' +
            '<button type="button" class="btn escuro" onclick="mudarQtd(\'' + id + '\', -1)">-</button>' +
            '<span>' + item.qtd + 'x</span>' +
            '<button type="button" class="btn escuro" onclick="mudarQtd(\'' + id + '\', 1)">+</button>' +
            '<strong>' + moeda(item.preco * item.qtd) + '</strong>' +
            '<button type="button" class="btn escuro pequeno" onclick="mudarQtd(\'' + id + '\', -9999)">Remover</button>' +
            '</div>';
    }
    if (html === '') {
        html = '<p>Sua sacola está vazia. <a href="index.php">Ver promoções</a></p>';
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

// faz as contas: subtotal, desconto do cupom, taxa de entrega e total
function calcularResumo() {
    const carrinho = pegarCarrinho();
    let subtotal = 0;
    let itens = 0;
    for (const id in carrinho) {
        subtotal += carrinho[id].preco * carrinho[id].qtd;
        itens += carrinho[id].qtd;
    }

    let desconto = 0;
    if (cupomAtual) {
        const c = cupons[cupomAtual];
        if (c.tipo === 'percentual') { desconto = subtotal * c.valor / 100; }
        if (c.tipo === 'fixo') { desconto = Math.min(c.valor, subtotal); }
    }

    // a taxa so conta depois que a pessoa chega na etapa de entrega
    let frete = 0;
    if (etapa >= 3 && tipoEntrega() === 'entrega' && subtotal > 0) {
        frete = TAXA_ENTREGA;
        if (subtotal - desconto >= FRETE_GRATIS_ACIMA || cupomAtual === 'FRETEGRATIS') {
            frete = 0;
        }
    }

    const total = subtotal - desconto + frete;

    el('rItens').textContent = itens;
    el('rSubtotal').textContent = moeda(subtotal);
    el('rDesconto').textContent = '- ' + moeda(desconto);
    if (etapa < 3) {
        el('rFrete').textContent = 'Escolha na etapa 3';
    } else if (tipoEntrega() === 'retirada') {
        el('rFrete').textContent = 'Retirada grátis';
    } else {
        el('rFrete').textContent = frete === 0 ? 'Grátis' : moeda(frete);
    }
    el('rTotal').textContent = moeda(total);

    return { subtotal: subtotal, desconto: desconto, frete: frete, total: total };
}

// cupom: aplica se existir
function aplicarCupom(codigo) {
    codigo = codigo.trim().toUpperCase();
    if (!cupons[codigo]) {
        cupomAtual = null;
        el('msgCupom').textContent = 'Cupom inválido.';
    } else {
        cupomAtual = codigo;
        el('msgCupom').textContent = 'Cupom ' + codigo + ' aplicado: ' + cupons[codigo].texto + '.';
    }
    calcularResumo();
}
el('btnCupom').onclick = function () { aplicarCupom(el('codigoCupom').value); };

function mostrarCupons() {
    let html = '';
    for (const codigo in cupons) {
        html += '<button type="button" class="btn escuro" onclick="aplicarCupom(\'' + codigo + '\')">' + codigo + ': ' + cupons[codigo].texto + '</button>';
    }
    el('listaCupons').innerHTML = html;
}

// botao continuar da etapa 1, so deixa passar se tiver item
el('btnContinuar1').onclick = function () {
    if (Object.keys(pegarCarrinho()).length === 0) {
        el('msgItens').textContent = 'Sua sacola está vazia.';
        return;
    }
    el('msgItens').textContent = '';
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
        el('msgCadastro').textContent = 'Preencha nome, e-mail e telefone.';
        return;
    }
    if (!email.includes('@')) {
        el('msgCadastro').textContent = 'E-mail inválido.';
        return;
    }
    localStorage.setItem('cliente', JSON.stringify({ nome: nome, email: email, telefone: telefone }));
    el('msgCadastro').textContent = '';
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

// monta um cartao clicavel de forma de pagamento
function opcaoPag(valor, titulo, sub, botao, marcado) {
    return '<label class="opcao"><input type="radio" name="pagamento" value="' + valor + '"' + (marcado ? ' checked' : '') + '>' +
        '<span><strong>' + titulo + '</strong><br>' + sub + '</span>' + botao + '</label>';
}

// desenha primeiro os metodos salvos, depois as opcoes novas, a primeira da lista ja vem marcada
function mostrarPagamentos() {
    const lista = pegarMetodos();
    let html = '';
    let primeiro = true;

    lista.forEach(function (m, i) {
        const sub = m.tipo === 'pix' ? 'Pix salvo' : m.titular + ', validade ' + m.validade;
        const botao = '<button type="button" class="btn escuro pequeno" onclick="removerSalvo(' + i + ', event)">Remover</button>';
        html += opcaoPag('s' + i, nomeMetodo(m), sub, botao, primeiro);
        primeiro = false;
    });

    if (!lista.some(function (m) { return m.tipo === 'pix'; })) {
        html += opcaoPag('pix', 'Pix', 'Pague na hora pelo app do banco', '', primeiro);
        primeiro = false;
    }
    html += opcaoPag('credito', 'Cartão de crédito', 'Adicionar novo cartão', '', primeiro);
    html += opcaoPag('debito', 'Cartão de débito', 'Adicionar novo cartão', '', false);

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

// confirmar: valida entrega e pagamento e se passar vai pra etapa 4
el('btnConfirmar').onclick = function () {
    const erro = el('msgErro');
    erro.textContent = '';

    if (tipoEntrega() === 'entrega') {
        if (el('rua').value.trim() === '' || el('numero').value.trim() === '' || el('cidade').value.trim() === '') {
            erro.textContent = 'Preencha rua, número e cidade para a entrega.';
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
            erro.textContent = 'Número do cartão inválido.';
            return;
        }
        if (el('titular').value.trim() === '' || el('validade').value.trim() === '' || el('cvv').value.length < 3) {
            erro.textContent = 'Preencha nome, validade e CVV do cartão.';
            return;
        }
        pagamento = { tipo: v, final: numero.slice(-4), titular: el('titular').value.trim(), validade: el('validade').value.trim() };
    }

    if (v.charAt(0) !== 's' && el('salvarMetodo').checked) {
        salvarMetodo(pagamento);
    }

    mostrarConfirmacao(pagamento);
};

// etapa 4: monta a tela de pedido confirmado e limpa o carrinho
function mostrarConfirmacao(pagamento) {
    const resumo = calcularResumo();
    const carrinho = pegarCarrinho();
    const cliente = JSON.parse(localStorage.getItem('cliente'));
    const numeroPedido = Math.floor(Math.random() * 90000) + 10000;

    let itens = '';
    for (const id in carrinho) {
        itens += '<div class="linha"><span>' + carrinho[id].qtd + 'x ' + carrinho[id].nome + '</span><span>' + moeda(carrinho[id].preco * carrinho[id].qtd) + '</span></div>';
    }

    let local = 'Retirada na Shelfy, Av. Principal, 100, Ponta Grossa.';
    if (tipoEntrega() === 'entrega') {
        local = 'Entrega em ' + el('rua').value + ', ' + el('numero').value + ', ' + el('bairro').value + ', ' + el('cidade').value + '.';
    }

    let aviso = '';
    if (pagamento.tipo === 'pix') {
        aviso = '<p>Pague pelo Pix em até 30 minutos para o pedido ser separado.</p>';
    }

    el('etapa4').innerHTML =
        '<h2>Pedido confirmado</h2>' +
        '<p>Número do pedido: <strong>#' + numeroPedido + '</strong></p>' +
        '<p>Cliente: ' + cliente.nome + '</p>' +
        '<p>' + local + '</p>' +
        '<p>Pagamento: ' + nomeMetodo(pagamento) + '</p>' +
        '<h3>Itens</h3>' + itens +
        '<div class="linha"><span>Desconto</span><span>- ' + moeda(resumo.desconto) + '</span></div>' +
        '<div class="linha"><span>Entrega</span><span>' + moeda(resumo.frete) + '</span></div>' +
        '<div class="linha total"><span>Total</span><span>' + moeda(resumo.total) + '</span></div>' +
        aviso +
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
