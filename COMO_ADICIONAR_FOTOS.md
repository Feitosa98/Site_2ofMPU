# Guia: Como Adicionar Fotos Personalizadas

## 📸 Fotos Necessárias

Você precisa adicionar 3 tipos de imagens na pasta `images/`:

### 1. Logo do Cartório
- **Nome do arquivo**: `logo.png`
- **Tamanho recomendado**: 300x300 pixels (ou proporção quadrada)
- **Formato**: PNG com fundo transparente (preferencial)
- **Onde aparece**: Header (topo do site)

### 2. Foto da Equipe
- **Nome do arquivo**: `equipe.jpg`
- **Tamanho recomendado**: 800x600 pixels (ou similar)
- **Formato**: JPG ou PNG
- **Onde aparece**: Seção "Nossa Equipe"

### 3. Fotos de Manacapuru (Opcional)
Se você quiser substituir os ícones coloridos por fotos reais:

#### Festival de Cirandas
- **Nome do arquivo**: `cirandas.jpg`
- **Tamanho**: 600x400 pixels

#### Ponte/Rodovia
- **Nome do arquivo**: `ponte.jpg`
- **Tamanho**: 600x400 pixels

#### Balneários
- **Nome do arquivo**: `balneario.jpg`
- **Tamanho**: 600x400 pixels

## 📂 Como Adicionar as Imagens

### Passo 1: Prepare as Imagens
1. Tire fotos ou encontre imagens de boa qualidade
2. Redimensione se necessário (use Paint, Photoshop, ou sites como [Pixlr](https://pixlr.com))
3. Renomeie os arquivos conforme indicado acima

### Passo 2: Salve na Pasta Correta
1. Abra a pasta: `d:\Site_2ofMPU\images\`
2. Cole as imagens lá dentro
3. Certifique-se que os nomes estão corretos (com letras minúsculas)

### Passo 3: Atualizar o HTML (Para Fotos de Manacapuru)
Se você quiser usar fotos reais ao invés dos ícones coloridos:

1. Abra o arquivo `index.html`
2. Procure pela seção "Conheça Manacapuru" (linha ~130)
3. Substitua as linhas que contêm `background: linear-gradient...` por:

**Para o Festival de Cirandas:**
```html
<div class="city-img" style="background-image: url('images/cirandas.jpg');"></div>
```

**Para a Ponte:**
```html
<div class="city-img" style="background-image: url('images/ponte.jpg');"></div>
```

**Para os Balneários:**
```html
<div class="city-img" style="background-image: url('images/balneario.jpg');"></div>
```

## ✅ Verificação

Depois de adicionar as imagens:
1. Abra o arquivo `index.html` no navegador
2. Pressione `Ctrl + F5` para atualizar (limpa o cache)
3. Verifique se as imagens aparecem corretamente

## 💡 Dicas

- **Qualidade**: Use imagens de boa resolução, mas não muito pesadas (máximo 500KB cada)
- **Formato**: JPG para fotos, PNG para logos com transparência
- **Proporção**: Mantenha proporções similares às recomendadas para evitar distorções
- **Direitos**: Use apenas imagens que você tem permissão para usar

## 🆘 Problemas Comuns

**Imagem não aparece:**
- Verifique se o nome do arquivo está correto (letras minúsculas)
- Confirme que a imagem está na pasta `images/`
- Limpe o cache do navegador (Ctrl + F5)

**Imagem distorcida:**
- Redimensione a imagem para a proporção recomendada
- Use ferramentas online como [iLoveIMG](https://www.iloveimg.com/pt/redimensionar-imagem)
