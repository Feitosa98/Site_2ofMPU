# Como Adicionar Vídeos do Instagram ao Site

## 📱 Passo a Passo Simplificado:

### 1️⃣ Pegue o Link do Vídeo
1. Abra o Instagram (app ou navegador)
2. Vá até o Reel ou post que você quer mostrar
3. Clique nos **3 pontinhos** (...)
4. Selecione **"Copiar link"**

### 2️⃣ Abra o Arquivo HTML
1. Vá até: `d:\Site_2ofMPU\`
2. Clique com botão direito em `index.html`
3. Escolha **"Abrir com"** → **Bloco de Notas** (ou outro editor)

### 3️⃣ Encontre a Seção do Instagram
1. Pressione `Ctrl + F` para buscar
2. Digite: `Instagram Placeholder 1`
3. Você vai ver algo assim:

```html
<!-- Instagram Placeholder 1 -->
<div class="instagram-placeholder">
    <div class="instagram-icon">
        <i class="fa-brands fa-instagram"></i>
    </div>
    <h4>Vídeo 1</h4>
    <p>Adicione o link do seu Reel aqui</p>
    <small>Veja INSTRUCOES_INSTAGRAM.md</small>
</div>
```

### 4️⃣ Substitua pelo Código do Vídeo
**APAGUE** todo o bloco acima e **COLE** este código:

```html
<!-- Instagram Vídeo 1 -->
<div class="instagram-embed">
    <blockquote class="instagram-media" data-instgrm-permalink="COLE_SEU_LINK_AQUI" data-instgrm-version="14"></blockquote>
</div>
```

**IMPORTANTE**: Substitua `COLE_SEU_LINK_AQUI` pelo link que você copiou!

### 5️⃣ Exemplo Completo

**ANTES:**
```html
<div class="instagram-placeholder">
    ...
</div>
```

**DEPOIS:**
```html
<div class="instagram-embed">
    <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/reel/C1a2b3c4d5/" data-instgrm-version="14"></blockquote>
</div>
```

### 6️⃣ Repita para os Outros Vídeos
- Faça o mesmo para "Placeholder 2" e "Placeholder 3"
- Você pode adicionar quantos vídeos quiser!

### 7️⃣ Salve e Teste
1. Salve o arquivo (`Ctrl + S`)
2. Abra `index.html` no navegador
3. Aguarde alguns segundos (Instagram demora um pouco para carregar)

## ✅ Checklist Rápido

- [ ] Copiei o link do Instagram
- [ ] Abri o index.html no Bloco de Notas
- [ ] Encontrei o "Instagram Placeholder"
- [ ] Substituí pelo código do embed
- [ ] Colei meu link no lugar certo
- [ ] Salvei o arquivo
- [ ] Testei no navegador

## 🎥 Exemplo de Link Válido

✅ **CORRETO:**
```
https://www.instagram.com/reel/C1234567890/
https://www.instagram.com/p/ABC123XYZ/
```

❌ **ERRADO:**
```
instagram.com (sem https://)
@cartorio.2oficiomanacapuru (isso é usuário, não link)
```

## 💡 Dica Extra

Se você quiser **remover** a seção do Instagram completamente:
1. Procure por `<!-- Instagram Feed Section -->`
2. Delete tudo até `</section>` (incluindo)

## 🆘 Problemas?

**Vídeo não aparece:**
- Aguarde 5-10 segundos (Instagram é lento)
- Verifique se o link está correto
- Certifique-se que o post é **público**
- Limpe o cache: `Ctrl + F5`

**Aparece erro:**
- Confira se você copiou o código completo
- Veja se não faltou nenhuma aspas `"` ou `>`
