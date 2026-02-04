@echo off
echo ========================================
echo  Deploy para GitHub Pages
echo ========================================
echo.

cd /d d:\Site_2ofMPU

echo [1/5] Verificando Git...
git --version >nul 2>&1
if errorlevel 1 (
    echo ERRO: Git nao encontrado!
    echo Instale o Git em: https://git-scm.com/download/win
    pause
    exit /b 1
)
echo OK - Git instalado

echo.
echo [2/5] Adicionando arquivos...
git add .
if errorlevel 1 (
    echo ERRO ao adicionar arquivos
    pause
    exit /b 1
)
echo OK - Arquivos adicionados

echo.
echo [3/5] Criando commit...
set /p mensagem="Digite a mensagem do commit (ou pressione Enter para usar padrao): "
if "%mensagem%"=="" set mensagem=Atualizacao do site
git commit -m "%mensagem%"
if errorlevel 1 (
    echo Nenhuma alteracao para commitar
)

echo.
echo [4/5] Verificando repositorio remoto...
git remote -v | find "Site_2ofMPU" >nul
if errorlevel 1 (
    echo Adicionando repositorio remoto...
    git remote add origin https://github.com/Feitosa98/Site_2ofMPU.git
    git branch -M main
)

echo.
echo [5/5] Enviando para GitHub...
git push -u origin main
if errorlevel 1 (
    echo.
    echo ERRO ao enviar para GitHub
    echo Verifique suas credenciais e conexao
    pause
    exit /b 1
)

echo.
echo ========================================
echo  SUCESSO!
echo ========================================
echo.
echo Seu site foi enviado para o GitHub!
echo.
echo Aguarde 1-3 minutos e acesse:
echo https://feitosa98.github.io/Site_2ofMPU/
echo.
echo Para ativar o GitHub Pages (primeira vez):
echo 1. Va em: https://github.com/Feitosa98/Site_2ofMPU/settings/pages
echo 2. Em Source, selecione: main / (root)
echo 3. Clique em Save
echo.
pause
