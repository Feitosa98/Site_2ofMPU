<?php
// system/utils/upload.php

function diretorioUploadsPrivados(): string
{
    $configured = getenv('PRIVATE_UPLOAD_DIR');
    return $configured ?: dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'private_uploads_registromanacapuru';
}

function processarUploads($arquivos_array, $solicitacao_id, $conn) {
    if (empty($arquivos_array['name'][0])) return true; // Nada pra upar

    $pastaDestino = diretorioUploadsPrivados() . DIRECTORY_SEPARATOR;
    if (!is_dir($pastaDestino)) {
        if (!mkdir($pastaDestino, 0700, true) && !is_dir($pastaDestino)) {
            throw new RuntimeException('Não foi possível preparar o armazenamento seguro de anexos.');
        }
    }

    $tiposSeguros = [
        'application/pdf' => 'pdf',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
    ];
    $limitePeso = 5 * 1024 * 1024;

    $sqlAnexo = "INSERT INTO anexos (solicitacao_id, nome_arquivo_original, nome_arquivo_salvo, caminho) VALUES (?, ?, ?, ?)";
    $stmtAnexo = $conn->prepare($sqlAnexo);

    $qtd = count($arquivos_array['name']);
    for ($i = 0; $i < $qtd; $i++) {
        $erro_upload = $arquivos_array['error'][$i];
        if ($erro_upload === UPLOAD_ERR_NO_FILE) continue; 
        
        if ($erro_upload !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Um dos anexos não pôde ser recebido.');
        }

        $nomeOriginal = $arquivos_array['name'][$i];
        $tamanho = $arquivos_array['size'][$i];
        $tmpName = $arquivos_array['tmp_name'][$i];

        // 1. Barreira de Peso (15MB)
        if ($tamanho <= 0 || $tamanho > $limitePeso) {
            throw new RuntimeException('Cada anexo deve ter no máximo 5 MB.');
        }

        // Valida o conteúdo real do arquivo, não apenas o nome informado.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($tmpName);
        if (!isset($tiposSeguros[$mime])) {
            throw new RuntimeException('Formato de anexo não permitido. Use PDF, JPG ou PNG.');
        }
        $extensao = $tiposSeguros[$mime];

        // 3. Mascaramento Criptográfico do Nome pra evitar Path Traversal Hacker
        $nomeSeguroUnico = bin2hex(random_bytes(24)) . '.' . $extensao;
        $caminhoRelativo = $nomeSeguroUnico;
        $caminhoFisicoAbsoluto = $pastaDestino . $nomeSeguroUnico;

        if (!move_uploaded_file($tmpName, $caminhoFisicoAbsoluto)) {
            throw new RuntimeException('Não foi possível salvar um dos anexos.');
        }
        chmod($caminhoFisicoAbsoluto, 0600);
        $stmtAnexo->execute([
            $solicitacao_id,
            mb_substr(basename($nomeOriginal), 0, 255),
            $nomeSeguroUnico,
            $caminhoRelativo
        ]);
    }
    return true;
}
?>
