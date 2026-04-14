<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Review Console</title>
    <style>
        :root {
            --bg: #fff4e8;
            --panel: rgba(255, 255, 255, 0.82);
            --line: #e7d4bf;
            --text: #2b1708;
            --muted: #7a6657;
            --accent: #d96b27;
            --accent-dark: #2f1b0f;
            --ok: #0f8a5f;
            --danger: #c14343;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top, #fff8ef 0%, #ffe7cf 42%, #ffcfa5 100%);
        }

        .shell {
            max-width: 1220px;
            margin: 0 auto;
            padding: 24px;
        }

        .hero,
        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 28px;
            box-shadow: 0 18px 50px rgba(88, 41, 7, 0.08);
            backdrop-filter: blur(14px);
        }

        .hero {
            padding: 32px;
            margin-bottom: 24px;
        }

        .hero h1 {
            margin: 0 0 12px;
            font-size: clamp(2rem, 5vw, 3.5rem);
            line-height: 1.05;
        }

        .hero p {
            margin: 0;
            max-width: 760px;
            color: var(--muted);
            line-height: 1.7;
        }

        .hero-badge {
            display: inline-block;
            margin-bottom: 14px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(217, 107, 39, 0.12);
            color: var(--accent);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .layout {
            display: grid;
            grid-template-columns: 400px minmax(0, 1fr);
            gap: 24px;
        }

        .stack {
            display: grid;
            gap: 20px;
        }

        .panel {
            padding: 24px;
        }

        .panel h2 {
            margin: 0 0 8px;
            font-size: 1.35rem;
        }

        .hint {
            margin: 0 0 18px;
            color: var(--muted);
            font-size: 0.95rem;
        }

        label {
            display: block;
            margin-bottom: 14px;
            font-size: 0.92rem;
            font-weight: 600;
        }

        input,
        textarea {
            width: 100%;
            margin-top: 6px;
            padding: 14px 16px;
            border-radius: 18px;
            border: 1px solid var(--line);
            background: #fffaf5;
            color: var(--text);
            font: inherit;
        }

        textarea {
            min-height: 112px;
            resize: vertical;
        }

        .actions {
            display: flex;
            gap: 12px;
        }

        button {
            border: 0;
            border-radius: 18px;
            padding: 14px 16px;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.15s ease, opacity 0.15s ease, background 0.15s ease;
        }

        button:hover {
            transform: translateY(-1px);
        }

        .primary {
            background: var(--accent-dark);
            color: white;
        }

        .secondary {
            background: white;
            color: var(--text);
            border: 1px solid var(--line);
        }

        .accent {
            background: var(--accent);
            color: white;
        }

        .gold {
            background: #f0b24a;
            color: #2b1708;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            background: #f3ece5;
            color: var(--muted);
        }

        .session-grid,
        .response-grid {
            display: grid;
            gap: 12px;
        }

        .session-grid {
            grid-template-columns: 1fr;
        }

        .response-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            margin-bottom: 14px;
        }

        .info-card {
            border-radius: 18px;
            background: #f7efe7;
            padding: 14px;
        }

        .info-card small {
            display: block;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .mono {
            font-family: Consolas, Monaco, monospace;
            font-size: 12px;
            word-break: break-all;
        }

        .reviews {
            overflow: hidden;
            border-radius: 22px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.8);
        }

        .review-item {
            padding: 18px;
            border-top: 1px solid var(--line);
        }

        .review-item:first-child {
            border-top: 0;
        }

        .review-meta {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: start;
        }

        .review-pill {
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(217, 107, 39, 0.12);
            color: var(--accent);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .response-box {
            margin: 0;
            padding: 18px;
            border-radius: 22px;
            background: #21150f;
            color: #f8efe6;
            overflow: auto;
            min-height: 220px;
            font-family: Consolas, Monaco, monospace;
            font-size: 12px;
            line-height: 1.7;
        }

        @media (max-width: 980px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .response-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="shell">
        <section class="hero">
            <span class="hero-badge">Review Console</span>
            <h1>Console de test pour l'API de reviews</h1>
        </section>

        <main class="layout">
            <section class="stack">
                <article class="panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
                        <div>
                            <h2>Reviews</h2>
                            <p class="hint">Teste `GET /api/reviews`. Admin = `200`, user = `403`, sans token = `401`.</p>
                        </div>
                        <button id="fetch-reviews" class="primary" type="button">Charger les reviews</button>
                    </div>

                    <div id="reviews-list" class="reviews">
                        <div class="review-item" style="color:var(--muted);">Aucune requete lancee pour l'instant.</div>
                    </div>
                </article>

                <article class="panel">
                    <h2>Derniere reponse API</h2>

                    <div class="response-grid">
                        <div class="info-card">
                            <small>Endpoint</small>
                            <div id="response-endpoint">-</div>
                        </div>
                        <div class="info-card">
                            <small>Status</small>
                            <div id="response-status">-</div>
                        </div>
                        <div class="info-card">
                            <small>Message</small>
                            <div id="response-message">-</div>
                        </div>
                    </div>

                    <pre id="response-body" class="response-box">Aucune reponse pour le moment.</pre>
                </article>
            </section>
        </main>
    </div>

    <script>
        const storageKey = 'review-console-session';

        const refs = {
            authBadge: document.getElementById('auth-badge'),
            email: document.getElementById('email'),
            password: document.getElementById('password'),
            loginForm: document.getElementById('login-form'),
            registerForm: document.getElementById('register-form'),
            registerName: document.getElementById('register-name'),
            registerEmail: document.getElementById('register-email'),
            registerPassword: document.getElementById('register-password'),
            registerPasswordConfirmation: document.getElementById('register-password-confirmation'),
            logoutButton: document.getElementById('logout-button'),
            currentUser: document.getElementById('current-user'),
            currentRole: document.getElementById('current-role'),
            currentToken: document.getElementById('current-token'),
            reviewForm: document.getElementById('review-form'),
            reviewContent: document.getElementById('review-content'),
            fetchReviews: document.getElementById('fetch-reviews'),
            reviewsList: document.getElementById('reviews-list'),
            responseEndpoint: document.getElementById('response-endpoint'),
            responseStatus: document.getElementById('response-status'),
            responseMessage: document.getElementById('response-message'),
            responseBody: document.getElementById('response-body'),
        };

        function readSession() {
            const raw = localStorage.getItem(storageKey);

            if (!raw) {
                return { token: null, user: null };
            }

            try {
                return JSON.parse(raw);
            } catch {
                return { token: null, user: null };
            }
        }

        function writeSession(session) {
            localStorage.setItem(storageKey, JSON.stringify(session));
        }

        function clearSession() {
            localStorage.removeItem(storageKey);
        }

        function tokenPreview(token) {
            if (!token) {
                return 'Non stocke';
            }

            if (token.length <= 20) {
                return token;
            }

            return `${token.slice(0, 10)}...${token.slice(-6)}`;
        }

        function renderSession() {
            const session = readSession();
            const user = session.user;

            refs.authBadge.textContent = user ? 'Connecte' : 'Deconnecte';
            refs.authBadge.style.background = user ? '#dff6ec' : '#f3ece5';
            refs.authBadge.style.color = user ? '#0f8a5f' : '#7a6657';

            refs.currentUser.textContent = user ? `${user.name} (${user.email})` : 'Aucun';
            refs.currentRole.textContent = user ? user.role : 'Aucun';
            refs.currentToken.textContent = tokenPreview(session.token);
        }

        function renderResponse(endpoint, status, body) {
            const message = body?.message || body?.error || (Array.isArray(body) ? `${body.length} reviews chargees` : 'OK');

            refs.responseEndpoint.textContent = endpoint;
            refs.responseStatus.textContent = String(status);
            refs.responseMessage.textContent = message || '-';
            refs.responseBody.textContent = JSON.stringify(body, null, 2);
        }

        function escapeHtml(value) {
            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function renderReviews(data) {
            if (!Array.isArray(data) || data.length === 0) {
                refs.reviewsList.innerHTML = '<div class="review-item" style="color:var(--muted);">Aucune review trouvee.</div>';
                return;
            }

            refs.reviewsList.innerHTML = data.map((review) => `
                <article class="review-item">
                    <div class="review-meta">
                        <div>
                            <div style="font-weight:700;">${escapeHtml(review.user?.name || 'Utilisateur inconnu')}</div>
                            <div style="font-size:13px;color:var(--muted);">${escapeHtml(review.user?.email || 'Email indisponible')}</div>
                        </div>
                        <div class="review-pill">Review #${review.id}</div>
                    </div>
                    <p style="margin:14px 0 0;line-height:1.7;color:#5d4637;">${escapeHtml(review.content || '')}</p>
                </article>
            `).join('');
        }

        async function apiRequest(endpoint, options = {}) {
            const session = readSession();
            const headers = {
                Accept: 'application/json',
                ...(options.body ? { 'Content-Type': 'application/json' } : {}),
                ...(options.headers || {}),
            };

            if (session.token) {
                headers.Authorization = `Bearer ${session.token}`;
            }

            const response = await fetch(endpoint, {
                ...options,
                headers,
            });

            let body;

            try {
                body = await response.json();
            } catch {
                body = { message: 'Reponse non JSON' };
            }

            renderResponse(endpoint, response.status, body);

            if (!response.ok) {
                throw { status: response.status, body };
            }

            return body;
        }

        refs.loginForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            try {
                const body = await apiRequest('/api/login', {
                    method: 'POST',
                    body: JSON.stringify({
                        email: refs.email.value,
                        password: refs.password.value,
                    }),
                });

                writeSession({
                    token: body.token,
                    user: body.user,
                });

                renderSession();
            } catch {
                clearSession();
                renderSession();
            }
        });

        refs.registerForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            try {
                const body = await apiRequest('/api/register', {
                    method: 'POST',
                    body: JSON.stringify({
                        name: refs.registerName.value,
                        email: refs.registerEmail.value,
                        password: refs.registerPassword.value,
                        password_confirmation: refs.registerPasswordConfirmation.value,
                    }),
                });

                writeSession({
                    token: body.token,
                    user: body.user,
                });

                refs.email.value = body.user.email;
                refs.password.value = refs.registerPassword.value;
                refs.registerForm.reset();
                renderSession();
            } catch {
                //
            }
        });

        refs.logoutButton.addEventListener('click', () => {
            clearSession();
            renderSession();
            refs.reviewsList.innerHTML = '<div class="review-item" style="color:var(--muted);">Session effacee. Recharge les reviews pour retester.</div>';
        });

        refs.fetchReviews.addEventListener('click', async () => {
            try {
                const body = await apiRequest('/api/reviews');
                renderReviews(body);
            } catch (error) {
                refs.reviewsList.innerHTML = `<div class="review-item" style="color:var(--danger);">Echec du chargement. Status ${error.status}. Regarde le panneau de reponse API.</div>`;
            }
        });

        refs.reviewForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            try {
                await apiRequest('/api/reviews', {
                    method: 'POST',
                    body: JSON.stringify({
                        content: refs.reviewContent.value,
                    }),
                });

                refs.reviewContent.value = '';
                refs.reviewsList.innerHTML = '<div class="review-item" style="color:var(--ok);">Review creee. Recharge les reviews pour voir le resultat.</div>';
            } catch {
                //
            }
        });

        renderSession();
    </script>
</body>
</html>
