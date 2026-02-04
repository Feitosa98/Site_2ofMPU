# Resolver Conflito com GitHub

## O Problema
O repositório no GitHub já tem arquivos (provavelmente README.md criado automaticamente).

## Solução Rápida

Execute estes comandos no PowerShell:

```powershell
# Opção 1: Forçar o push (RECOMENDADO - sobrescreve o que está no GitHub)
git push -u origin main --force

# OU

# Opção 2: Puxar primeiro e depois enviar
git pull origin main --allow-unrelated-histories
git push -u origin main
```

## Qual usar?

**Use a Opção 1** se você quer que o site fique exatamente como está agora (recomendado).

**Use a Opção 2** se você quer manter o README.md que foi criado no GitHub.

---

Depois de executar um dos comandos acima, seu site estará no GitHub!
