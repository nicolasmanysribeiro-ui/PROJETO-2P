<?php
// js extra que so essa pagina usa, o footer carrega
$extraJs = 'js/carrinho.js';
include __DIR__ . '/inc/header.inc.php';
?>

<div class="container">

    

    <main>

        <!-- barra de etapas no topo, o js marca qual ta ativa -->
        <ol class="etapas">
            <li id="e1" class="ativa">1. Sacola</li>
            <li id="e2">2. Cadastro</li>
            <li id="e3">3. Entrega e pagamento</li>
            <li id="e4">4. Confirmação</li>
        </ol>

        <div class="carrinho-grid">

            <div class="coluna-form">

                <!-- etapa 1: itens da sacola e cupom -->
                <section id="etapa1" class="caixa">
                    <h3>Sua sacola</h3>
                    <div id="listaItens"></div>
                    <p class="erro" id="msgItens"></p>

                    <h3>Cupom de desconto</h3>
                    <input type="text" id="codigoCupom" placeholder="Digite seu cupom">
                    <button type="button" class="btn" id="btnCupom">Aplicar</button>
                    <p id="msgCupom"></p>
                    <div class="cupons" id="listaCupons"></div>

                    <div class="botoes">
                        <a href="index.php" class="btn escuro">Continuar comprando</a>
                        <button type="button" class="btn" id="btnContinuar1">Continuar</button>
                    </div>
                </section>

                <!-- etapa 2: cadastro obrigatorio -->
                <section id="etapa2" class="caixa escondido">
                    <h3>Seus dados</h3>
                    <label>Nome completo</label>
                    <input type="text" id="nome">
                    <label>E-mail</label>
                    <input type="email" id="email">
                    <label>Telefone</label>
                    <input type="text" id="telefone">
                    <p class="erro" id="msgCadastro"></p>

                    <div class="botoes">
                        <button type="button" class="btn escuro" id="btnVoltar2">Voltar</button>
                        <button type="button" class="btn" id="btnSalvarCadastro">Salvar e continuar</button>
                    </div>
                </section>

                <!-- etapa 3: entrega ou retirada e pagamento -->
                <div id="etapa3" class="escondido">

                    <section class="caixa">
                        <h3>Como você quer receber?</h3>
                        <div id="opcoesEntrega">
                            <label class="opcao">
                                <input type="radio" name="entrega" value="retirada" checked>
                                <span><strong>Retirar no mercado</strong><br>Grátis. Av. Principal, 100, Ponta Grossa. Aberto das 8h às 22h.</span>
                            </label>
                            <label class="opcao">
                                <input type="radio" name="entrega" value="entrega">
                                <span><strong>Entregar na minha casa</strong><br>Taxa de R$ 8,00, grátis em compras acima de R$ 150,00.</span>
                            </label>
                        </div>

                        <div id="blocoEntrega" class="escondido">
                            <button type="button" class="btn escuro" id="btnLocal">Usar minha localização</button>
                            <p id="msgLocal"></p>
                            <label>CEP</label>
                            <input type="text" id="cep">
                            <label>Rua</label>
                            <input type="text" id="rua">
                            <label>Número</label>
                            <input type="text" id="numero">
                            <label>Bairro</label>
                            <input type="text" id="bairro">
                            <label>Cidade</label>
                            <input type="text" id="cidade">
                        </div>
                    </section>

                    <section class="caixa">
                        <h3>Como você quer pagar?</h3>
                        <div id="opcoesPag"></div>

                        <p id="blocoPixInfo" class="escondido">O código do Pix aparece depois de confirmar o pedido.</p>

                        <div id="blocoCartao" class="escondido">
                            <label>Número do cartão</label>
                            <input type="text" id="numCartao" maxlength="19">
                            <label>Nome no cartão</label>
                            <input type="text" id="titular">
                            <label>Validade</label>
                            <input type="text" id="validade" placeholder="MM/AA">
                            <label>CVV</label>
                            <input type="text" id="cvv" maxlength="4">
                        </div>

                        <label id="blocoSalvar" class="escondido"><input type="checkbox" id="salvarMetodo"> Salvar este método para a próxima compra</label>
                    </section>

                    <p class="erro" id="msgErro"></p>
                    <div class="botoes">
                        <button type="button" class="btn escuro" id="btnVoltar3">Voltar</button>
                        <button type="button" class="btn" id="btnConfirmar">Confirmar pedido</button>
                    </div>
                </div>

                <!-- etapa 4: pedido confirmado, o js preenche -->
                <section id="etapa4" class="caixa escondido"></section>

            </div>

            <!-- resumo sempre do lado, some so na confirmacao -->
            <aside id="resumo" class="resumo caixa">
                <h3>Resumo</h3>
                <div class="linha"><span>Itens</span><span id="rItens"></span></div>
                <div class="linha"><span>Subtotal</span><span id="rSubtotal"></span></div>
                <div class="linha"><span>Desconto</span><span id="rDesconto"></span></div>
                <div class="linha"><span>Entrega</span><span id="rFrete"></span></div>
                <div class="linha total"><span>Total</span><span id="rTotal"></span></div>
            </aside>

        </div>
    </main>
</div>

<?php include __DIR__ . '/inc/footer.inc.php'; ?>
