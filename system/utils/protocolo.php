<?php
// system/utils/protocolo.php

function gerarProtocolo()
{
    // Formato: CART + ANO + ID_UNICO (Ex: CART20241AB2)
    // Usando uniqid para garantir unicidade e strtoupper para padronizar
    $ano = date('Y');
    $uniq = strtoupper(substr(uniqid(), -5)); // Pega os últimos 5 caracteres
    return "CART{$ano}{$uniq}";
}

function gerarSenha()
{
    // Gera senha numérica de 6 dígitos
    return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
}
?>