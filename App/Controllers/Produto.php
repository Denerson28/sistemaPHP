<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\core\Funcoes;
use GUMP as Validador;

class Produto extends BaseController{

    protected $filters = [
        'nome' => 'trim|sanitize_string',
        'descricao' => 'trim|sanitize_string',
    ];


    function __construct()
    {
        session_start();
        if (!Funcoes::funcionarioLogado()) :
            Funcoes::redirect("Home");
        endif;
    }

    public function index($numPag = 1)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') :

            $this->view('produto/index', [], 'produto/produtojs');
        else :
            Funcoes::redirect("Home");
        endif;
    }

    public function ajax_lista($data)
    {

        $numPag = $data['numPag'];

        // calcula o offset
        $offset = ($numPag - 1) * REGISTROS_PAG;

        $produtoModel = $this->model("ProdutoModel");
        $categoriaModel = $this->model("CategoriaModel");

        // obtém a quantidade total de registros na base de dados
        $total_registros = $produtoModel->getTotalProdutos();
        $total_categorias = $categoriaModel->read()->fetchAll(\PDO::FETCH_ASSOC);

        // calcula a quantidade de páginas - ceil — Arredonda frações para cima
        $total_paginas = ceil($total_registros / REGISTROS_PAG);

        // obtém os registros referente a página
        $lista_produto = $produtoModel->getRegistroPagina($offset, REGISTROS_PAG)->fetchAll(\PDO::FETCH_ASSOC);

        $corpoTabela = "";
        $corpoCategoria = "";

        if (!empty($lista_produto)) :
            foreach ($lista_produto as $produto) {
                $corpoTabela .= "<tr>";
                $corpoTabela .= "<td>" . htmlentities(utf8_encode($produto['nome_produto'])) . "</td>";
                $corpoTabela .= "<td>" . htmlentities(utf8_encode($produto['descricao'])) . "</td>";
                $corpoTabela .= "<td>" . htmlentities(utf8_encode($produto['liberado_venda'])) . "</td>";
                $corpoTabela .= "<td>" . '<button type="button" id="btAlterar" data-id="' . $produto['id'] . '" class="btn btn-outline-primary">Alterar</button>
                                          <button type="button" id="btExcluir" data-id="' . $produto['id'] . '" data-nome="' . $produto['nome_produto'] . '" class="btn btn-outline-primary">Excluir</button>'
                    . "</td>";
                $corpoTabela .= "</tr>";
            }

            $links = '<nav aria-label="Page navigation example">';
            $links .= '<ul class="pagination">';

            for ($page = 1; $page <= $total_paginas; $page++) {
                $links .= '<li class="page-item"><a class="page-link link-navegacao" href="javascript:load_data(' . $page . ')">' . $page . '</a></li>';
            }
            $links .= '  </ul></nav>';

        else :
            $corpoTabela = "<tr>Não há produtos</tr>";
        endif;

        if (!empty($total_categorias)) :
            foreach ($total_categorias as $categoria) {
                $corpoCategoria .= "<option value = " . $categoria['id'] . ">" . htmlentities(utf8_encode($categoria['nome_categoria'])) . "</option>";
            }
        endif;
        

        $data = [];
        $data["TotalRegistros"] = $total_registros;
        $data["TotalPaginas"] = $total_paginas;
        $data["corpoTabela"] = $corpoTabela;
        $data["corpoCategoria"] = $corpoCategoria;
        $data["links"] = $links;
        $data['status'] = true;
        echo json_encode($data);
        exit();
    }

    public function incluir()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') :
            // gera o CSRF_token e guarda na sessão
            $_SESSION['CSRF_token'] = Funcoes::gerarTokenCSRF();
            // devolve os dados 
            $data = array();
            $data['token'] = $_SESSION['CSRF_token'];
            $data['status'] = true;
            echo json_encode($data);
            exit();
        else :
            Funcoes::redirect("Home");
        endif;
    }

    public function alterarProduto($data)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') :

            // o controlador receber o parâmetro como um array $data['hashID']
            $id = $data['id'];

            // gera o CSRF_token e guarda na sessão
            $_SESSION['CSRF_token'] = Funcoes::gerarTokenCSRF();

            $produtoModel = $this->model("produtoModel");

            $produto = $produtoModel->get($id);

            $data = array();
            $data['status'] = true;
            $data['id'] = $produto['id'];
            $data['nome_produto'] = $produto['nome_produto'];
            $data['descricao'] = $produto['descricao'];
            $data['preco_compra'] = $produto['preco_compra'];
            $data['preco_venda'] = $produto['preco_venda'];
            $data['quantidade_disponivel'] = $produto['quantidade_disponivel'];
            $data['token'] = $_SESSION['CSRF_token'];
            $data['id_categoria'] = $produto['id_categoria'];
            echo json_encode($data);
            exit();

        else :
            Funcoes::redirect("Home");
        endif;
    }
    
    public function gravarAlterar()
    {
        // trata a as solicitações POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :

            if ($_POST['CSRF_token'] == $_SESSION['CSRF_token']) :

                $filters = [
                    'nome_produto_alteracao' => 'trim|sanitize_string',
                    'descricao_alteracao' => 'trim|sanitize_string',
                ];

                $rules = [
                    'liberado_venda' => 'required|exact_len,1',
                ];

                $validacao = new Validador("pt-br");

                $post_filtrado = $validacao->filter($_POST, $filters);
                $post_validado = $validacao->validate($post_filtrado, $rules);

                if ($post_validado === true) :  // verificar dados do produto

                    // criando um objeto produto
                    $produto = new \App\models\Produto();
                    $produto->setNomeProduto($_POST['nome_produto_alteracao']);
                    $produto->setDescricao($_POST['descricao_alteracao']);
                    $produto->setPrecoCompra($_POST['preco_compra_alteracao']);
                    $produto->setPrecoVenda($_POST['preco_Venda_alteracao']);
                    $produto->setQuantidadeDisponivel($_POST['quantidade_disponivel_alteracao']);
                    $produto->setLiberadoVenda($_POST['liberado_venda_alteracao']);
                    $produto->setIdCategoria($_POST['id_categoria_alteracao']);

                    $produtoModel = $this->model("produtoModel");

                    $produtoModel->update($produto);

                    $data['status'] = true;
                    echo json_encode($data);
                    exit();


                else :
                    $erros = $validacao->get_errors_array();
                    $erros = implode("<br>", $erros);

                    $produtoModel = $this->model("produtoModel");
                    $produto = $produtoModel->getId($_POST['id_alteracao']);

                    $data['status'] = true;
                    $data['token'] = $_SESSION['CSRF_token'];
                    $data['nome_produto'] = $produto['nome_produto'];
                    $data['descricao'] = $produto['descricao'];
                    $data['preco_compra'] = $produto['preco_compra'];
                    $data['preco_venda'] = $produto['preco_venda'];
                    $data['quantidade_disponivel'] = $produto['quantidade_disponivel'];
                    $data['liberado_venda'] = $produto['liberado_venda'];
                    $data['id_categoria'] = $produto['id_categoria'];
                    $data['id'] =  $_POST['id_alteracao'];
                    $data['status'] = false;
                    $data['erros'] = $erros;
                    echo json_encode($data);
                    exit();
                endif;
            else :
                die("Erro 404");
            endif;

        else :
            Funcoes::redirect("Home");
        endif;
    }
}

?>