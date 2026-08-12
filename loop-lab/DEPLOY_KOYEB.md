# 🚀 Deploy Loop Lab no Koyeb

## Pré-requisitos

- Conta no [Koyeb](https://www.koyeb.com/)
- GitHub conectado ao Koyeb
- APP_KEY gerado (já temos)

## Passo a Passo

### 1. Criar Aplicação no Koyeb

1. Acesse [koyeb.com/control](https://app.koyeb.com/)
2. Clique em "Create App" ou "Create Service"
3. Escolha "GitHub" como fonte
4. Selecione o repositório `fabiomelloo/loop-lab`
5. Branch: `main`

### 2. Configurar Build

Na tela de configuração do serviço:

- **Builder**: Nixpacks (automático)
- **Build Command**: Deixar vazio (detecta automaticamente via `composer.json`)
- **Run Command**:
  ```
  php -d variables_order=EGPCS artisan serve --host=0.0.0.0 --port=8000
  ```

### 3. Configurar Variáveis de Ambiente

Adicione as seguintes variáveis de ambiente:

```
APP_NAME = Loop Lab
APP_ENV = production
APP_DEBUG = false
APP_URL = https://seu-app.koyeb.app
APP_KEY = base64:sua_chave_aqui
DB_CONNECTION = sqlite
DB_DATABASE = database/database.sqlite
LOG_CHANNEL = stack
```

**Para pegar o APP_KEY**:
```bash
php artisan key:generate --show
```

Ou use o já gerado: `base64:MqKX3eCFKp7d8Y9mN2zK4sB5jL8qR3wT9uV2xC6pD7f=`

### 4. Configurar Porta

- **Port**: `8000` (ou a porta que o Koyeb atribuir como `$PORT`)
- **HTTP**: Ativado na porta 8000

### 5. Deployment

Koyeb suporta diferentes opções:

#### Opção A: Auto-Deploy via GitHub (Recomendado)
1. Autorizar Koyeb a acessar seu GitHub
2. Selecionar branch `main`
3. Cada push para `main` dispara novo build

#### Opção B: Deploy Manual via CLI
```bash
# Instalar Koyeb CLI (opcional)
npm install -g @koyeb/cli
# ou
brew install koyeb

# Fazer login
koyeb auth login

# Deploy
koyeb services create loop-lab \
  --git fabiomelloo/loop-lab \
  --git-branch main \
  --env APP_KEY=base64:... \
  --env DB_CONNECTION=sqlite
```

#### Opção C: Deploy via Docker
```bash
# Fazer push de imagem Docker
docker build -t your-registry/loop-lab:latest .
docker push your-registry/loop-lab:latest
```

### 6. Verificar Logs

Após deploy:
```bash
# Via CLI
koyeb services logs loop-lab

# Via Dashboard
Koyeb Control Panel → Services → loop-lab → Logs
```

### 7. Acessar Aplicação

URL: `https://seu-app.koyeb.app`

---

## Diferenças Koyeb vs Railway

| Aspecto | Railway | Koyeb |
|---------|---------|-------|
| Configuração | `railway.json` | `koyeb.yml` ou UI |
| Variáveis de Env | `.env.railway` | Secrets no Dashboard |
| Auto-deploy | Automático | GitHub Webhook ou Manual |
| Banco SQLite | ✅ Suportado | ✅ Suportado (volume) |
| Free Tier | ~$5/mês | Varável |
| Performance | Bom | Bom |

---

## Troubleshooting

### Erro: "Port não disponível"
- Certifique-se que a porta é `8000` ou `$PORT`
- Koyeb atribui porta automaticamente via `$PORT`

### Erro: "Database locked"
- SQLite em ambientes serverless pode ter problemas
- Alternativa: Usar PostgreSQL no Koyeb (addon disponível)

### Erro: "Composer install falhou"
- Verificar se `composer.lock` está no repositório ✅
- Verificar se `composer.json` está válido

### Aplicação iniciando mas não responde
- Aguardar 2-3 minutos para build completo
- Verificar logs: `koyeb services logs loop-lab`
- Verificar variáveis de ambiente: `APP_DEBUG=true` temporariamente

---

## Monitoramento

No Koyeb Dashboard você pode:
- ✅ Ver logs em tempo real
- ✅ Reiniciar serviço
- ✅ Escalar horizontalmente (aumentar instâncias)
- ✅ Ver métricas de CPU/Memória
- ✅ Gerenciar domínio customizado

---

## Próximos Passos

1. Criar conta Koyeb (se não tiver)
2. Conectar GitHub
3. Configurar variáveis de ambiente
4. Disparar primeiro deployment
5. Testar: `https://seu-app.koyeb.app`

---

## Suporte

- Docs Koyeb: https://docs.koyeb.com/
- Laravel em Koyeb: https://docs.koyeb.com/frameworks/laravel
- Community: https://discord.gg/koyeb

---

**Criado em**: 12 Agosto 2026  
**Versão Laravel**: 13.8  
**PHP**: 8.3
