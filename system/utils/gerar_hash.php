<?php
// system/utils/gerar_hash.php
// Script utilitário para gerar hash de senha manualmente (rodar uma vez para pegar o hash ou atualizar o banco)

// Senha padrão inicial
$senha = 'admin123';
$hash = password_hash($senha, PASSWORD_DEFAULT);

echo "Senha: $senha<br>";
echo "Hash: $hash<br><br>";

// SQL para atualizar
echo "UPDATE usuarios SET senha = '$hash' WHERE email = 'admin@cartorio.com';";
?>