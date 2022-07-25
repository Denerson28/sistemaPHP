<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\core\Funcoes;
use GUMP as Validador;

class Funcionario extends BaseController
{

    protected $filters = [
        'nome' => 'trim|sanitize_string',
        'cpf' => 'trim|sanitize_string',
        'senha' => 'trim|sanitize_string',
        'papel' => 'trim',
    ];

    protected $rules = [
        'nome'    => 'required|min_len,2|max_len,40',
        'cpf' => 'required|exact_len,14',
        'senha' => 'required|max_len,20',
        'papel' => 'required|exact_len,1',
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

            $this->view('funcionario/index', [], 'funcionario/funcionariojs');
        else :
            Funcoes::redirect("Home");
        endif;
    }


    public function ajax_lista($data)
    {

        $numPag = $data['numPag'];

        // calcula o offset
        $offset = ($numPag - 1) * REGISTROS_PAG;

        $funcionarioModel = $this->model("FuncionarioModel");

        // obtém a quantidade total de registros na base de dados
        $total_registros = $funcionarioModel->getTotalFuncionarios();

        // calcula a quantidade de páginas - ceil — Arredonda frações para cima
        $total_paginas = ceil($total_registros / REGISTROS_PAG);

        // obtém os registros referente a página
        $lista_funcionarios = $funcionarioModel->getRegistroPagina($offset, REGISTROS_PAG)->fetchAll(\PDO::FETCH_ASSOC);

        $corpoTabela = "";

        if (!empty($lista_funcionarios)) :
            foreach ($lista_funcionarios as $funcionario) {
                $corpoTabela .= "<tr>";
                $corpoTabela .= "<td>" . htmlentities(utf8_encode($funcionario['nome'])) . "</td>";
                $corpoTabela .= "<td>" . htmlentities(utf8_encode($funcionario['cpf'])) . "</td>";
                $corpoTabela .= "<td>" . htmlentities(utf8_encode($funcionario['senha'])) . "</td>";
                $corpoTabela .= "<td>" . htmlentities(utf8_encode($funcionario['papel'])) . "</td>";
                $corpoTabela .= "<td>" . '<button type="button" id="btAlterar" data-id="' . $funcionario['id'] . '" class="btn btn-outline-primary">Alterar</button>
                                          <button type="button" id="btExcluir" data-id="' . $funcionario['id'] . '" data-nome="' . $funcionario['nome'] . '"class="btn btn-outline-primary">Excluir</button>'
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
            $corpoTabela = "<tr>Não há funcionarios</tr>";
        endif;

        $data = [];
        $data["TotalRegistros"] = $total_registros;
        $data["TotalPaginas"] = $total_paginas;
        $data["corpoTabela"] = $corpoTabela;
        $data["links"] = $links;
        $data['status'] = true;
        echo json_encode($data);
        exit();
    }

    // ***********************************************************************
    // chama a view para entrada dos dados do funcionario
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

    public function gravarInclusao()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') :

            if ($_POST['CSRF_token'] == $_SESSION['CSRF_token']) :

                $validacao = new Validador("pt-br");
                $post_filtrado = $validacao->filter($_POST, $this->filters);
                $post_validado = $validacao->validate($post_filtrado, $this->rules);

                if ($post_validado === true) :  // verificar dados do funcionario

                    //$hash_senha = password_hash($_POST['senha'], PASSWORD_ARGON2I); // gerar hash senha enviada

                    $funcionario = new \App\models\Funcionario(); // criar uma instância de usuário
                    $funcionario->setNome($_POST['nome']);   // setar os valores
                    $funcionario->setCpf($_POST['cpf']);
                    $funcionario->setSenha($_POST['senha']);
                    $funcionario->setPapel($_POST['papel']);
                    $funcionarioModel = $this->model("FuncionarioModel"); 
                    $funcionarioModel->create($funcionario); // incluir usuário no BD

                    $data['status'] = true;          // retornar inclusão realizada
                    echo json_encode($data);
                    exit();
                else :  // validação dos dados falhou
                    $erros = $validacao->get_errors_array();  // obter erros de validação
                    $erros = implode("<br>", $erros);         // gerar uma string com os erros
                    $_SESSION['CSRF_token'] = Funcoes::gerarTokenCSRF();

                    $data['token'] = $_SESSION['CSRF_token'];  // gerar CSRF
                    $data['status'] = false;        // retornar erros
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

    // ***********************************************************************
    public function alterarFuncionario($data)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') :

            // o controlador receber o parâmetro como um array $data['hashID']
            $id = $data['id'];

            // gera o CSRF_token e guarda na sessão
            $_SESSION['CSRF_token'] = Funcoes::gerarTokenCSRF();

            $funcionarioModel = $this->model("funcionarioModel");

            $funcionario = $funcionarioModel->get($id);

            $data = array();
            $data['token'] = $_SESSION['CSRF_token'];
            $data['status'] = true;
            $data['nome'] = $funcionario['nome'];
            $data['cpf'] = $funcionario['cpf'];
            $data['senha'] = $funcionario['senha'];
            $data['papel'] = $funcionario['papel'];
            $data['id'] =  $id;
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
                    'nome_alteracao' => 'trim|sanitize_string',
                    'cpf_alteracao' => 'trim|sanitize_string',
                    'senha_alteracao' => 'trim|sanitize_string',
                    'papel_alteracao' => 'trim',
                ];
            
                $rules = [
                    'nome_alteracao'    => 'required|min_len,2|max_len,40',
                    'cpf_alteracao' => 'required|exact_len,14',
                    'senha_alteracao' => 'required|max_len,20',
                    'papel_alteracao' => 'required|exact_len,1',
                ];

                $validacao = new Validador("pt-br");

                $post_filtrado = $validacao->filter($_POST, $filters);
                $post_validado = $validacao->validate($post_filtrado, $rules);

                if ($post_validado === true) :  // verificar dados do funcionario

                    // criando um objeto funcionario
                    $funcionario = new \App\models\Funcionario();
                    $funcionario->setNome($_POST['nome_alteracao']);
                    $funcionario->setCpf($_POST['cpf_alteracao']);
                    $funcionario->setSenha($_POST['senha_alteracao']);
                    $funcionario->setPapel($_POST['papel_alteracao']);
                    $funcionario->setId($_POST['id_alteracao']);

                    $funcionarioModel = $this->model("funcionarioModel");

                    $funcionarioModel->update($funcionario);

                    $data['status'] = true;
                    echo json_encode($data);
                    exit();


                else :
                    $erros = $validacao->get_errors_array();
                    $erros = implode("<br>", $erros);
                    $_SESSION['CSRF_token'] = Funcoes::gerarTokenCSRF();

                    $funcionarioModel = $this->model("funcionarioModel");
                    $funcionario = $funcionarioModel->getId($_POST['id_alteracao']);

                    $data['status'] = true;
                    $data['nome'] = $funcionario['nome'];
                    $data['cpf'] = $funcionario['cpf'];
                    $data['senha'] = $funcionario['senha'];
                    $data['papel'] = $funcionario['papel'];
                    $data['id'] =  $_POST['id_alteracao'];
                    $data['token'] = $_SESSION['CSRF_token'];
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

    // ***********************************************************************


    public function excluirFuncionario($data)
    {
        // trata a as solicitações POST
        if ($_SERVER['REQUEST_METHOD'] == 'GET') :

            $id = $data['id'];

            $funcionarioModel = $this->model("FuncionarioModel");

            $funcionarioModel->delete($id);

            $data = array();
            $data['status'] = true;
            echo json_encode($data);
            exit();

        else :
            Funcoes::redirect("Home");
        endif;
    }
}