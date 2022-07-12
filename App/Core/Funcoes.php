<?php

namespace App\core;

class Funcoes
{

    public static function gerarTokenCSRF()
    {
        $string_aleatoria = bin2hex(openssl_random_pseudo_bytes(16));
        return hash_hmac('sha256', $string_aleatoria, CSRF_TOKEN_SECRET);
    }
    
    public static function validarTokenCSRF($token_crsf, $token_session)
    {
        $token_crsf_original = $token_session;
        if (hash_equals($token_crsf_original, $token_crsf)) {
            return true;
        }
        return false;
    }

    public static function redirect($rota = "")
    {
       header("Location:" . URL_BASE . "/". $rota);
    }

    public static function funcionarioLogado()
    {
        return isset($_SESSION['id']) && isset($_SESSION['nomeFuncionario']);
    }

    public static function setMessagem($mensagem, $title="Sucesso", $icon="success")
    {
        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['title'] = $title;
        $_SESSION['icon'] = $icon;

        //icones = warning", "error", "success" and "info"
    }
    public static function apagarMessagem()
    {
        unset($_SESSION['mensagem']);
        unset($_SESSION['title']);
        unset($_SESSION['icon']);

    }
}
