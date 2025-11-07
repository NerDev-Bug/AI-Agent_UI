# AI Agent API Configuration Setup

## 📝 Idagdag ang mga sumusunod sa iyong `.env` file:

Ilagay ang mga ito sa **dulo ng iyong `.env` file**, pagkatapos ng iba pang configuration:

```env
# ============================================
# AI Agent Backend Configuration
# ============================================
API_AI_AGENT_URL=http://localhost:8002/api/agent
API_AI_AGENT_CONFIRM_URL=http://localhost:8002/api/storage/approve-simple
AI_AGENT_KEY=your-strong-random-key
```

## 📍 Lokasyon sa .env file:

Ang `.env` file ay nasa **root directory** ng iyong Laravel project:
```
AI-Agent_UI/
├── .env          ← Dito mo ilalagay
├── app/
├── config/
├── routes/
└── ...
```

## ⚙️ Configuration Details:

### `API_AI_AGENT_URL`
- **Default**: `http://localhost:8002/api/agent`
- **Description**: Ang URL para sa analyze at reanalyze endpoints
- **Ginagamit para sa**: File analysis (Analyze Demo Form button)
- **Example**: 
  - Local: `http://localhost:8002/api/agent`
  - Production: `https://api.yourdomain.com/api/agent`

### `API_AI_AGENT_CONFIRM_URL`
- **Default**: `http://localhost:8002/api/storage/approve-simple`
- **Description**: Ang URL para sa save/confirm endpoint
- **Ginagamit para sa**: Save button (pag-send ng confirmation)
- **Example**: 
  - Local: `http://localhost:8002/api/storage/approve-simple`
  - Production: `https://api.yourdomain.com/api/storage/approve-simple`

### `AI_AGENT_KEY`
- **Required**: Oo
- **Description**: Ang secure API key para sa authentication sa AI Agent backend
- **Kung saan makukuha**: Check mo ang `.env` file ng iyong `agentic-ai-evaluator` project
- **Important**: Dapat **pareho** ang value nito sa `API_KEY` sa FastAPI backend `.env` file
- **Security**: Ang Laravel app ay magse-send ng `X-API-Key` header sa lahat ng requests

## ✅ Pagkatapos mag-add:

1. **Save** ang `.env` file
2. **Clear cache** (optional pero recommended):
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

## 🔍 Example ng complete .env section:

```env
APP_NAME="AI Agent UI"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

# ... iba pang configurations ...

# Database
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite

# ... iba pang configurations ...

# ============================================
# AI Agent Backend Configuration
# ============================================
API_AI_AGENT_URL=http://localhost:8002/api/agent
API_AI_AGENT_CONFIRM_URL=http://localhost:8002/api/storage/approve-simple
AI_AGENT_KEY=your-strong-random-key
```

## ⚠️ Important Notes:

- **HUWAG** i-commit ang `.env` file sa git (naka-gitignore na ito)
- **PALITAN** ang `your-strong-random-key` ng actual API key mo
- **SIGURADUHIN** na tumatakbo ang FastAPI backend sa URL na nakalista
- **API KEY MATCHING**: Ang `AI_AGENT_KEY` sa Laravel `.env` ay dapat **pareho** sa `API_KEY` sa FastAPI backend `.env`
  - FastAPI backend `.env`: `API_KEY=your-strong-random-key`
  - Laravel frontend `.env`: `AI_AGENT_KEY=your-strong-random-key` (same value!)
- **Security**: Lahat ng requests ay may `X-API-Key` header para sa authentication
- Kung naka-docker ang FastAPI mo, baka kailangan mong gamitin ang docker network URL

## 🔐 Security Implementation:

Ang FastAPI backend ay may security protection:
- **Header Name**: `X-API-Key`
- **FastAPI Environment Variable**: `API_KEY`
- **Laravel Environment Variable**: `AI_AGENT_KEY`
- Parehong value dapat sila para mag-work ang authentication

