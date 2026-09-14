<?php
// system/utils/prazos.php
date_default_timezone_set('America/Manaus');

/**
 * Adiciona N dias úteis a uma data inicial, ignorando Sábados e Domingos.
 *
 * @param string $dataReferencia Data no formato 'Y-m-d' ou 'Y-m-d H:i:s'
 * @param int $diasUteis Número inteiro de dias úteis a somar
 * @return string Data final calculada no formato 'Y-m-d H:i:s'
 */
function calcularDiasUteis($dataReferencia, $diasUteis) {
    if ($diasUteis == 0) return $dataReferencia;

    $dt = new DateTime($dataReferencia);
    
    $diasAdicionados = 0;
    while ($diasAdicionados < $diasUteis) {
        $dt->modify('+1 day');
        
        // 6 = Sábado, 7 = Domingo
        $diaSemana = $dt->format('N');
        if ($diaSemana < 6) { 
            // É um dia útil (Segunda a Sexta)
            $diasAdicionados++;
        }
    }

    return $dt->format('Y-m-d H:i:s');
}
?>
