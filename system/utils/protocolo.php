<?php
// system/utils/protocolo.php

function gerarProtocolo()
{
    // Formato: CART + ANO + 10 caracteres criptograficamente aleatórios.
    $ano = date('Y');
    $uniq = strtoupper(bin2hex(random_bytes(5)));
    return "CART{$ano}{$uniq}";
}

function gerarSenha()
{
    // Gera senha numérica de 6 dígitos
    return (string) random_int(100000, 999999);
}
?>
