<!-- Button trigger modal -->
<button type="button" id="btIncluir" class="btn btn-danger mb-1">
    Novo
</button>

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Senha</th>
            <th>Papel</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody name="contudoTabela" id="contudoTabela">
    </tbody>
</table>

<div id="pagination_link"></div>


<!-- Modal Inclusão do funcionario-->
<div class="modal fade" id="modalNovoFuncionario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Novo Funcionario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= url('salvarinclusaofuncionario') ?>" id="formInclusao" method="POST">
                    <div id="mensagem_erro" name="mensagem_erro"></div>
                    <input type="hidden" id="CSRF_token" name="CSRF_token" value="" />
                    <div class="form-group">
                        <label for="nome">Nome*</label>
                        <input type="text" class="form-control" id="nome" name="nome">
                    </div>
                    <div class="form-group">
                        <label for="cpf">CPF*</label>
                        <input type="cpf" class="form-control" id="cpf" name="cpf">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha*</label>
                        <input type="senha" class="form-control" id="senha" name="senha">
                    </div>
                    <div class="form-group">
                        <label for="papel">Papel*</label>
                        <select type="papel" class="form-control" id="papel" name="papel">
                            <option value="0"><?= "Administrador" ?></option>
                            <option value="1"><?= "Vendedor" ?></option>
                            <option value="2"><?= "Comprador" ?></option>
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

<!-- Modal alteracao do funcionario-->
<div class="modal fade" id="modalAlterarFuncionario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Funcionario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?= url('gravaralteracaofuncionario') ?>" id="formAltercao" method="POST">

                    <div id="mensagem_erro_alteracao" name="mensagem_erro_alteracao"></div>

                    <input type="hidden" id="CSRF_token" name="CSRF_token" value="" />
                    <input type="hidden" id="id_alteracao" name="id_alteracao" value="" />

                    <div class="form-group">
                        <label for="nome">Nome*</label>
                        <input type="text" class="form-control" id="nome_alteracao" name="nome_alteracao">
                    </div>
                    <div class="form-group">
                        <label for="cpf">CPF*</label>
                        <input type="cpf" class="form-control" id="cpf_alteracao" name="cpf_alteracao">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha*</label>
                        <input type="senha" class="form-control" id="senha_alteracao" name="senha_alteracao">
                    </div>
                    <div class="form-group">
                        <label for="papel">Papel*</label>
                        <select type="papel" class="form-control" id="papel_alteracao" name="papel_alteracao">
                            <option value="0"><?= "Administrador" ?></option>
                            <option value="1"><?= "Vendedor" ?></option>
                            <option value="2"><?= "Comprador" ?></option>
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