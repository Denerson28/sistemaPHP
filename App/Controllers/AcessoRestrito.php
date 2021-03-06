<?php

namespace App\Controllers;

use App\core\BaseController;
use App\core\Funcoes;
use GUMP as Validador;

class AcessoRestrito extends BaseController
{
    protected $filters = [
        //'email' => 'trim|sanitize_email',
        'cpf' => 'trim',
        'senha' => 'trim|sanitize_string',

    ];

    protected $rules = [
        //'email'    => 'required|min_len,8|max_len,255',
        'cpf' => 'required',
        'senha'  => 'required',

    ];


    function __construct() {
        session_start();

    }

    public function login()
    {
        // chama a view
        $this->view('acessorestrito/login');
    }

    public function logar()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") :


            $validacao = new Validador("pt-br");

            $post_filtrado = $validacao->filter($_POST, $this->filters);
            $post_validado = $validacao->validate($post_filtrado, $this->rules);

            if ($post_validado === true) :  // verificar login

                    $senha_enviada = $_POST['senha'];

                    /* gera uma senha fake
                    $senha_fake   = random_bytes(64);
                    $hash_senha_fake = password_hash($senha_fake, PASSWORD_ARGON2I);*/

                    // busca o funcionario
                    $funcionarioModel = $this->model('FuncionarioModel');
                    $funcionario = $funcionarioModel->getFuncionarioCpf($_POST['cpf']);


                    if (!empty($funcionario)) :
                        $senha_bd = $funcionario['senha']; // achou o usuário usa hash do banco
                    /*else :
                        $senha_hash = $hash_senha_fake;  // não achou o usuário usa hash fake*/
                    endif;

                    if ($senha_enviada == $senha_bd) :
                        
                        // regenerar a sessão
                        session_regenerate_id(true);

                        $_SESSION['id'] = $funcionario['id'];
                        $_SESSION['nomeFuncionario'] = $funcionario['nome'];
                        $_SESSION['cpfFuncionario'] = $funcionario['cpf'];
                        $_SESSION['papelFuncionario'] = $funcionario['papel'];
                       
                        if($funcionario['papel'] == 0):
                            Funcoes::redirect("DashboardAdministrador");  // acesso área restrita do admin
                        elseif($funcionario['papel'] == 1):
                            Funcoes::redirect("DashboardVendedor");  // acesso área restrita do vendedor
                        elseif($funcionario['papel'] == 2):
                            Funcoes::redirect("DashboardComprador");  // acesso área restrita do comprador
                        endif;

                    else :
                        $mensagem = ["CPF e/ou Senha incorreta"];
                        $this->view('acessorestrito/login');
                    endif;
            else : // erro de validação
                $mensagem = $validacao->get_errors_array();
                $data = [
                    'mensagens' => $mensagem
                ];

                $this->view('acessorestrito/login', $data);
            endif;
        else : // não POST
            Funcoes::redirect();
        endif;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        Funcoes::redirect();

    }

}
