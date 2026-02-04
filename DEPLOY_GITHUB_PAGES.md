# 🚀 Como Publicar o Site no GitHub Pages

## Passo 1: Preparar o Repositório

Você já criou o repositório: `https://github.com/Feitosa98/Site_2ofMPU.git`

## Passo 2: Inicializar Git e Fazer Upload

Abra o **PowerShell** ou **Git Bash** na pasta do projeto e execute:

```bash
# Navegar até a pasta do projeto
cd d:\Site_2ofMPU

# Inicializar o repositório Git
git init

# Adicionar o repositório remoto
git remote add origin https://github.com/Feitosa98/Site_2ofMPU.git

# Adicionar todos os arquivos
git add .

# Fazer o primeiro commit
git commit -m "Initial commit - Site Cartório 2º Ofício Manacapuru"

# Renomear branch para main (se necessário)
git branch -M main

# Enviar para o GitHub
git push -u origin main
```

## Passo 3: Ativar GitHub Pages

1. Vá para: `https://github.com/Feitosa98/Site_2ofMPU`
2. Clique em **Settings** (Configurações)
3. No menu lateral esquerdo, clique em **Pages**
4. Em **Source** (Origem), selecione:
   - Branch: `main`
   - Folder: `/ (root)`
5. Clique em **Save** (Salvar)

## Passo 4: Aguardar Deploy

- O GitHub vai processar o site (leva 1-3 minutos)
- Você verá uma mensagem: "Your site is live at..."
- O site estará disponível em: `https://feitosa98.github.io/Site_2ofMPU/`

## 📝 Comandos para Atualizar o Site Futuramente

Sempre que fizer alterações:

```bash
cd d:\Site_2ofMPU
git add .
git commit -m "Descrição da alteração"
git push
```

O site será atualizado automaticamente em 1-2 minutos!

## ✅ Checklist

- [ ] Git instalado no computador
- [ ] Executei os comandos do Passo 2
- [ ] Ativei o GitHub Pages no Passo 3
- [ ] Aguardei o deploy (1-3 minutos)
- [ ] Acessei o site: `https://feitosa98.github.io/Site_2ofMPU/`

## 🆘 Problemas Comuns

**"Git não é reconhecido":**
- Instale o Git: https://git-scm.com/download/win
- Reinicie o PowerShell após instalar

**"Permission denied":**
- Configure suas credenciais do GitHub:
```bash
git config --global user.name "Seu Nome"
git config --global user.email "seu@email.com"
```

**"Repository not found":**
- Verifique se o repositório existe em: https://github.com/Feitosa98/Site_2ofMPU
- Certifique-se de estar logado no GitHub

## 🎉 Pronto!

Após seguir esses passos, seu site estará online e acessível para qualquer pessoa em:

**https://feitosa98.github.io/Site_2ofMPU/**

Você pode compartilhar esse link com clientes, colocar em cartões de visita, etc!
