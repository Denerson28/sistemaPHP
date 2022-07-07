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
                        <label for="descricao">Descrição</label>
                        <input type="text" class="form-control" id="descricao" name="descricao">
                        <label for="preco_compra">Preço Compra</label>
                        <input type="number" class="form-control" id="preco_compra" name="preco_compra">
                        <label for="preco_venda">Preço Venda</label>
                        <input type="number" class="form-control" id="preco_venda" name="preco_venda">
                        <label for="quantidade_disponível">Quantidade Disponível</label>
                        <input type="number" class="form-control" id="quantidade_disponível" name="quantidade_disponível">
                        <label for="liberado_venda">Liberado Venda? (S/N)</label>
                        <input type="text" class="form-control" id="liberado_venda" name="liberado_venda">
                        <label for="id_categoria">Categoria do Produto</label> <br>
                        <select name="id_categoria" id="id_categoria">
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
                    <label for="nome_produto_alteracao">Nome</label>
                        <input type="text" class="form-control" id="nome_produto_alteracao" name="nome_produto_alteracao">
                        <label for="descricao_alteracao">Descrição</label>
                        <input type="text" class="form-control" id="descricao_alteracao" name="descricao_alteracao">
                        <label for="preco_compra_alteracao">Preço Compra</label>
                        <input type="number" class="form-control" id="preco_compra_alteracao" name="preco_compra_alteracao">
                        <label for="preco_venda_alteracao">Preço Venda</label>
                        <input type="number" class="form-control" id="preco_venda_alteracao" name="preco_venda_alteracao">
                        <label for="quantidade_disponível_alteracao">Quantidade Disponível</label>
                        <input type="number" class="form-control" id="quantidade_disponível_alteracao" name="quantidade_disponível_alteracao">
                        <label for="liberado_venda_alteracao">Liberado Venda? (S/N)</label>
                        <input type="text" class="form-control" id="liberado_venda_alteracao" name="liberado_venda_alteracao">
                        <label for="id_categoria_alteracao">Categoria do Produto</label> <br>
                        <select name="id_categoria_alteracao" id="id_categoria_alteracao">
                        </select>
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