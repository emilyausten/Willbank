# WillBank - Sistema de Empréstimo PIX

Sistema completo de empréstimo com integração PIX via API SyncPay, desenvolvido com HTML, CSS, JavaScript e PHP.

## 🚀 Funcionalidades

- **Landing Page Profissional**: Design moderno e responsivo
- **Simulação de Empréstimo**: Calculadora interativa
- **Sistema de Pagamento PIX**: Integração com API SyncPay
- **Checkout Transparente**: Interface profissional para pagamentos
- **Webhook Automático**: Confirmação de pagamentos em tempo real
- **Página de Sucesso**: Confirmação e próximos passos

## 📁 Estrutura do Projeto

```
willbank/
├── index.htm                 # Página principal
├── js/
│   └── page-handler.js      # Gerenciador de páginas
├── chat/
│   ├── pagamento/
│   │   └── index.html       # Página de pagamento
│   ├── checkout-transparente/
│   │   └── index.html       # Checkout PIX
│   └── sucesso/
│       └── index.html       # Página de sucesso
├── webhook/
│   ├── pix-status.php       # Webhook para notificações
│   └── check-status.php     # Endpoint de verificação
├── css/                     # Estilos CSS
├── images/                  # Imagens do projeto
└── scripts/                 # Scripts externos
```

## 🛠️ Tecnologias Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 7.4+
- **Framework CSS**: Tailwind CSS
- **Ícones**: Font Awesome
- **API**: SyncPay (PIX)
- **QR Code**: API externa gratuita

## ⚙️ Configuração

### 1. Requisitos do Servidor

- PHP 7.4 ou superior
- Servidor web (Apache/Nginx)
- SSL/HTTPS (recomendado para produção)

### 2. Configuração da API SyncPay

Edite o arquivo `chat/checkout-transparente/index.html` e atualize:

```javascript
const API_CONFIG = {
    url: 'https://api.syncpay.pro/v1/gateway/api/',
    apiKey: 'SUA_API_KEY_AQUI',
    postbackUrl: 'https://seudominio.com/webhook/pix-status.php'
};
```

### 3. Configuração do Webhook

Certifique-se de que o webhook está acessível em:
```
https://seudominio.com/webhook/pix-status.php
```

## 🔧 Instalação

1. **Clone o repositório**:
```bash
git clone https://github.com/seuusuario/willbank.git
cd willbank
```

2. **Configure o servidor web**:
   - Apontar o document root para a pasta do projeto
   - Habilitar mod_rewrite (Apache)
   - Configurar SSL/HTTPS

3. **Configure as permissões**:
```bash
chmod 755 webhook/
chmod 644 webhook/*.php
```

4. **Teste a instalação**:
   - Acesse `https://seudominio.com`
   - Verifique se todas as páginas carregam corretamente

## 📱 Fluxo do Usuário

1. **Landing Page** (`index.htm`)
   - Usuário vê oferta de empréstimo
   - Clica em "Ativar meu crédito agora"
   - Preenche CPF para consulta

2. **Página de Pagamento** (`chat/pagamento/`)
   - Escolhe método de recebimento (PIX/Banco)
   - Preenche dados bancários
   - Confirma dados

3. **Checkout PIX** (`chat/checkout-transparente/`)
   - Gera PIX via API SyncPay
   - Exibe QR Code e código PIX
   - Verifica status automaticamente

4. **Página de Sucesso** (`chat/sucesso/`)
   - Confirma pagamento realizado
   - Mostra próximos passos
   - Opções de compartilhamento

## 🔒 Segurança

- **API Key protegida**: Armazenada no frontend (considere mover para backend)
- **Webhook seguro**: Validação de dados recebidos
- **HTTPS obrigatório**: Para produção
- **Logs de transações**: Todas as operações são registradas

## 📊 Monitoramento

### Logs Disponíveis

- `webhook/pix_webhook.log`: Notificações recebidas
- `webhook/status_*.json`: Status das transações

### Métricas Importantes

- Taxa de conversão por etapa
- Tempo médio de pagamento
- Taxa de abandono
- Status dos PIXs gerados

## 🚀 Deploy

### Opções de Hospedagem

1. **Hospedagem Compartilhada**:
   - Hostinger, GoDaddy, etc.
   - Upload via FTP/cPanel

2. **VPS/Dedicado**:
   - DigitalOcean, AWS, etc.
   - Configuração manual do servidor

3. **Plataformas Cloud**:
   - Heroku, Vercel, Netlify
   - Deploy automático via Git

### Checklist de Deploy

- [ ] Configurar domínio e SSL
- [ ] Atualizar API Key da SyncPay
- [ ] Configurar webhook URL
- [ ] Testar fluxo completo
- [ ] Configurar monitoramento
- [ ] Backup automático

## 🔧 Manutenção

### Atualizações Regulares

- Monitorar logs de erro
- Verificar status da API SyncPay
- Atualizar dependências
- Backup dos dados

### Troubleshooting

**PIX não gera**:
- Verificar API Key
- Confirmar URL da API
- Verificar logs de erro

**Webhook não funciona**:
- Verificar permissões de arquivo
- Confirmar URL acessível
- Verificar logs do servidor

**Status não atualiza**:
- Verificar endpoint check-status.php
- Confirmar arquivos JSON criados
- Verificar permissões de escrita

## 📞 Suporte

Para suporte técnico:
- Email: suporte@willbank.com
- Documentação: [Link para docs]
- Issues: [GitHub Issues]

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

---

**Desenvolvido com ❤️ pela equipe WillBank** 