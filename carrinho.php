<?php
// js extra que so essa pagina usa, o footer carrega
$extraJs = 'js/carrinho.js';
include __DIR__ . '/inc/header.inc.php';
?>

<div class="container">

    <?php include __DIR__ . '/inc/menu-esq.inc.php'; ?>

    <main>

        <div id="telaCompra">
            <h2 class="titulo">Meu Carrinho</h2>

            <div class="carrinho-grid">

                <div class="coluna-form">

                    <section class="caixa">
                        <h3>1. Itens</h3>
                        <div id="listaItens"></div>
                    </section>

                    <section class="caixa">
                        <h3>2. Cadastro obrigatório</h3>
                        <label>Nome completo</label>
                        <input type="text" id="nome">
                        <label>E-mail</label>
                        <input type="email" id="email">
                        <label>Telefone</label>
                        <input type="text" id="telefone">
                        <button type="button" class="btn" id="btnCadastro">Salvar cadastro</button>
                        <p id="msgCadastro"></p>
                    </section>

                    <section class="caixa">
                        <h3>3. Entrega ou retirada</h3>
                        <label><input type="radio" name="entrega" value="retirada" checked> Buscar no mercado, grátis</label><br>
                        <label><input type="radio" name="entrega" value="entrega"> Entregar na minha casa, taxa de R$ 8,00 e grátis acima de R$ 150,00</label>

                        <div id="blocoRetirada">
                            <p>Retire na Shelfy, Av. Principal, 100, Ponta Grossa. Aberto todo dia das 8h às 22h.</p>
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
                        <h3>4. Cupons e promoções</h3>
                        <input type="text" id="codigoCupom" placeholder="Digite seu cupom">
                        <button type="button" class="btn" id="btnCupom">Aplicar</button>
                        <p id="msgCupom"></p>
                        <div class="cupons" id="listaCupons"></div>
                    </section>

                    <section class="caixa">
                        <h3>5. Pagamento</h3>
                        <div id="metodosSalvos"></div>
                        <p id="msgPag"></p>

                        <label>Novo método</label>
                        <select id="tipoPag">
                            <option value="pix">Pix</option>
                            <option value="credito">Cartão de crédito</option>
                            <option value="debito">Cartão de débito</option>
                        </select>

                        <div id="blocoPix">
                            <p>O código do Pix aparece depois de confirmar o pedido.</p>
                        </div>

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

                        <label><input type="checkbox" id="salvarMetodo"> Salvar este método para a próxima compra</label>
                    </section>

                </div>

                <aside class="resumo caixa">
                    <h3>Resumo</h3>
                    <div class="linha"><span>Subtotal</span><span id="rSubtotal"></span></div>
                    <div class="linha"><span>Desconto</span><span id="rDesconto"></span></div>
                    <div class="linha"><span>Entrega</span><span id="rFrete"></span></div>
                    <div class="linha total"><span>Total</span><span id="rTotal"></span></div>
                    <button type="button" class="btn grande" id="btnConfirmar">Confirmar pedido</button>
                    <p class="erro" id="msgErro"></p>
                </aside>

            </div>
        </div>

        <div id="telaConfirmacao" class="caixa escondido"></div>

    </main>
</div>

<?php include __DIR__ . '/inc/footer.inc.php'; ?>
