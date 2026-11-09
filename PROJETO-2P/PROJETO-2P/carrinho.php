<?php
// js extra so dessa pagina e esconde a barra de baixo, porque aqui ja ta tudo na tela
$extraJs = 'js/carrinho.js';
$semBarra = true;
include __DIR__ . '/inc/header.inc.php';
?>

<div class="pagina-carrinho">

    <ol class="etapas">
        <li id="e1" class="ativa"><b>1</b> Sacola</li>
        <li id="e2"><b>2</b> Cadastro</li>
        <li id="e3"><b>3</b> Entrega e pagamento</li>
        <li id="e4"><b>4</b> Pedido</li>
    </ol>

    <div class="carrinho-grid">

        <div class="coluna-form">

            <!-- etapa 1: itens e cupom -->
            <section id="etapa1" class="caixa">
                <h2>Sua sacola</h2>
                <div id="listaItens"></div>
                <p class="erro" id="msgItens"></p>

                <details class="cupom">
                    <summary>🏷️ Tem um cupom de desconto?</summary>
                    <div class="cupom-corpo">
                        <input type="text" id="codigoCupom" placeholder="Digite seu cupom">
                        <button type="button" class="btn" id="btnCupom">Aplicar</button>
                        <p id="msgCupom"></p>
                        <div class="cupons" id="listaCupons"></div>
                    </div>
                </details>

                <div class="botoes">
                    <a href="index.php" class="btn escuro">Continuar comprando</a>
                    <button type="button" class="btn" id="btnContinuar1">Continuar</button>
                </div>
            </section>

            <!-- etapa 2: cadastro obrigatorio e rapido -->
            <section id="etapa2" class="caixa escondido">
                <h2>Seus dados</h2>
                <p class="dica">Só 3 dados e sem senha. Eles ficam salvos neste aparelho para as próximas compras.</p>
                <label>Nome completo</label>
                <input type="text" id="nome" autocomplete="name">
                <label>E-mail</label>
                <input type="email" id="email" autocomplete="email">
                <label>Telefone</label>
                <input type="text" id="telefone" autocomplete="tel">
                <p class="erro" id="msgCadastro"></p>

                <div class="botoes">
                    <button type="button" class="btn escuro" id="btnVoltar2">Voltar</button>
                    <button type="button" class="btn" id="btnSalvarCadastro">Salvar e continuar</button>
                </div>
            </section>

            <!-- etapa 3: entrega e pagamento -->
            <div id="etapa3" class="escondido">

                <section class="caixa">
                    <h2>Como você quer receber?</h2>
                    <div id="opcoesEntrega">
                        <label class="opcao">
                            <input type="radio" name="entrega" value="retirada" checked>
                            <span class="icone">🏪</span>
                            <span class="texto"><strong>Retirar no mercado</strong><small>Pronto em 20 a 30 min. Av. Principal, 100, Ponta Grossa.</small></span>
                            <span class="tag">Grátis</span>
                        </label>
                        <label class="opcao">
                            <input type="radio" name="entrega" value="entrega">
                            <span class="icone">🛵</span>
                            <span class="texto"><strong>Entregar na minha casa</strong><small>Chega em 40 a 60 min. Grátis em compras acima de R$ 150,00.</small></span>
                            <span class="tag" id="tagEntrega"></span>
                        </label>
                    </div>

                    <div id="blocoEntrega" class="escondido">
                        <button type="button" class="btn escuro" id="btnLocal">📍 Usar minha localização</button>
                        <p id="msgLocal"></p>
                        <label>CEP</label>
                        <input type="text" id="cep" autocomplete="postal-code">
                        <label>Rua</label>
                        <input type="text" id="rua" autocomplete="street-address">
                        <div class="duas-colunas">
                            <div><label>Número</label><input type="text" id="numero"></div>
                            <div><label>Bairro</label><input type="text" id="bairro"></div>
                        </div>
                        <label>Cidade</label>
                        <input type="text" id="cidade">
                    </div>
                </section>

                <section class="caixa">
                    <h2>Como você quer pagar?</h2>
                    <div id="opcoesPag"></div>

                    <p id="blocoPixInfo" class="dica escondido">O código do Pix aparece assim que você fizer o pedido.</p>

                    <div id="blocoCartao" class="escondido">
                        <label>Número do cartão</label>
                        <input type="text" id="numCartao" maxlength="19" inputmode="numeric">
                        <label>Nome no cartão</label>
                        <input type="text" id="titular">
                        <div class="duas-colunas">
                            <div><label>Validade</label><input type="text" id="validade" placeholder="MM/AA"></div>
                            <div><label>CVV</label><input type="text" id="cvv" maxlength="4" inputmode="numeric"></div>
                        </div>
                    </div>

                    <label id="blocoSalvar" class="escondido"><input type="checkbox" id="salvarMetodo"> Salvar este método para a próxima compra</label>
                    <p class="dica">🔒 Pagamento seguro. Do cartão guardamos só os 4 últimos números.</p>
                </section>

                <p class="erro" id="msgErro"></p>
                <div class="botoes">
                    <button type="button" class="btn escuro" id="btnVoltar3">Voltar</button>
                    <button type="button" class="btn grande" id="btnConfirmar">Fazer pedido</button>
                </div>
            </div>

            <!-- etapa 4: pedido feito, o js preenche -->
            <section id="etapa4" class="caixa escondido"></section>

        </div>

        <!-- resumo fica visivel em todas as etapas, menos na ultima -->
        <aside id="resumo" class="resumo caixa">
            <h2>Resumo</h2>
            <div class="frete-info">
                <p id="msgFrete"></p>
                <div class="barra"><div id="barraProgresso"></div></div>
            </div>
            <div class="linha"><span>Itens</span><span id="rItens"></span></div>
            <div class="linha"><span>Subtotal</span><span id="rSubtotal"></span></div>
            <div class="linha"><span>Desconto</span><span id="rDesconto"></span></div>
            <div class="linha"><span>Entrega</span><span id="rFrete" class="direita"></span></div>
            <div class="linha total"><span id="rTotalLabel">Total</span><span id="rTotal"></span></div>
        </aside>

    </div>
</div>

<?php include __DIR__ . '/inc/footer.inc.php'; ?>
