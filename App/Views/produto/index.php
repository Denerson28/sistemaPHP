<!-- Button trigger modal -->
<button type="button" id="btIncluir" class="btn btn-outline-primary mb-1">
    Novo
</button>

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Nome do Produto</th>
            <th>descricao</th>
            <th>Liberado Venda</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody name="contudoTabela" id="contudoTabela">
    </tbody>
</table>

<div id="pagination_link"></div>


<!-- Modal Inclusão da Produto-->
<div class="modal fade" id="modalNovoProduto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Novo Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= url('salvarinclusaoproduto') ?>" id="formInclusao" method="POST">
                    <div id="mensagem_erro" name="mensagem_erro"></div>
                    <input type="hidden" id="CSRF_token" name="CSRF_token" value="" />
                    <div class="form-group">
                        <label for="nome_produto">Nome</label>
                        <input type="text" class="form-control" id="nome_produto" name="nome_produto">
                        <label for="descricao_produto">Descrição</label>
                        <input type="text" class="form-control" id="descricao_produto" name="descricao_produto">
                        <label for="preco_compra_produto">Preço Compra</label>
                        <input type="number" class="form-control" id="preco_compra_produto" name="preco_compra_produto">
                        <label for="preco_venda_produto">Preço Venda</label>
                        <input type="number" class="form-control" id="preco_venda_produto" name="preco_venda_produto">
                        <label for="quantidade_disponivel_produto">Quantidade Disponível</label>
                        <input type="number" class="form-control" id="quantidade_disponivel_produto" name="quantidade_disponivel_produto">
                        <label for="liberado_venda_produto">Liberado Venda? (S/N)</label>
                        <input type="text" class="form-control" id="liberado_venda_produto" name="liberado_venda_produto">
                        <label for="categoria_produto">Categoria do Produto</label> <br>
                        <select name="categorias" id="categorias">
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btSalvarInclusao" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal alteracao da Produto-->
<div class="modal fade" id="modalAlterarProduto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?= url('gravaralteracaoproduto') ?>" id="formAltercao" method="POST">

                    <div id="mensagem_erro_alteracao" name="mensagem_erro_alteracao"></div>

                    <input type="hidden" id="CSRF_token" name="CSRF_token" value="" />
                    <input type="hidden" id="id_alteracao" name="id_alteracao" value="" />

                    <div class="form-group">
                        <label for="nome_produto_alteracao">Nome*</label>
                        <input type="text" class="form-control" id="nome_produto_alteracao" name="nome_produto_alteracao">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btSalvarAlteracao" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>