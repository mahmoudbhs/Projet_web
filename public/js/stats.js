const token = localStorage.getItem("token");

if (!token) {
    window.location.href = "/frontend/login.html";
}

/* ── Utilitaires ───────────────────────────────────────────── */

function escapeHtml(value) {
    return String(value)
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");
}

function initials(name) {
    return (name || "?").split(" ").map((w) => w[0]).join("").slice(0, 2).toUpperCase();
}

function formatDate(dateStr) {
    return new Date(dateStr).toLocaleString("fr-FR", {
        day: "2-digit", month: "short", year: "numeric",
        hour: "2-digit", minute: "2-digit",
    });
}

function sentimentBadge(sentiment) {
    const map = {
        positive: { cls: "bg-emerald-500/15 text-emerald-400 border border-emerald-500/30", label: "Positif" },
        negative: { cls: "bg-red-500/15 text-red-400 border border-red-500/30",             label: "Négatif" },
        neutral:  { cls: "bg-slate-600/40 text-slate-400 border border-slate-500/30",        label: "Neutre"  },
    };
    const s = map[sentiment] || map.neutral;
    return `<span class="px-2.5 py-1 rounded-full text-xs font-semibold ${s.cls}">${s.label}</span>`;
}

function showToast(message, type = "info") {
    const colors = { success: "bg-emerald-600", error: "bg-red-600", info: "bg-violet-600" };
    const container = document.getElementById("toastContainer");
    const toast = document.createElement("div");
    toast.className = `pointer-events-auto flex items-center gap-2 px-4 py-3 rounded-xl shadow-lg text-sm font-medium text-white
                       ${colors[type] || colors.info} transition-all duration-300`;
    toast.textContent = message;
    container.appendChild(toast);
    setTimeout(() => { toast.style.opacity = "0"; setTimeout(() => toast.remove(), 300); }, 3500);
}

/* ── Graphiques ────────────────────────────────────────────── */

let sentimentChartInstance = null;
let topicsChartInstance    = null;

const CHART_DEFAULTS = {
    plugins: { legend: { display: false }, tooltip: { callbacks: {} } },
    responsive: true,
    maintainAspectRatio: false,
};

function buildSentimentChart(positivePercent, negativePercent) {
    const neutral = Math.max(0, 100 - positivePercent - negativePercent);
    const ctx     = document.getElementById("sentimentChart").getContext("2d");

    if (sentimentChartInstance) sentimentChartInstance.destroy();

    sentimentChartInstance = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ["Positif", "Neutre", "Négatif"],
            datasets: [{
                data: [positivePercent, neutral, negativePercent],
                backgroundColor: ["#10b981", "#475569", "#ef4444"],
                borderColor:     ["#10b98130", "#47556930", "#ef444430"],
                borderWidth: 2,
                hoverOffset: 6,
            }],
        },
        options: {
            ...CHART_DEFAULTS,
            maintainAspectRatio: true,
            cutout: "72%",
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (ctx) => ` ${ctx.parsed}%`,
                    },
                    backgroundColor: "#1e293b",
                    titleColor: "#94a3b8",
                    bodyColor: "#f1f5f9",
                    borderColor: "#334155",
                    borderWidth: 1,
                },
            },
        },
    });

    // Valeur centre
    const centerEl = document.getElementById("sentimentCenterValue");
    if (centerEl) centerEl.textContent = `${positivePercent}%`;
}

function buildTopicsChart(topics) {
    const ctx = document.getElementById("topicsChart").getContext("2d");

    if (topicsChartInstance) topicsChartInstance.destroy();

    if (!topics || !topics.length) {
        document.getElementById("topicsChart").closest(".h-52").innerHTML =
            `<p class="text-slate-600 text-sm text-center w-full self-center">Aucun thème détecté</p>`;
        return;
    }

    topicsChartInstance = new Chart(ctx, {
        type: "bar",
        data: {
            labels: topics.map((t) => t.topic),
            datasets: [{
                label: "Occurrences",
                data: topics.map((t) => t.count),
                backgroundColor: ["#7c3aed", "#6d28d9", "#5b21b6"],
                borderRadius: 8,
                borderSkipped: false,
            }],
        },
        options: {
            ...CHART_DEFAULTS,
            indexAxis: "y",
            scales: {
                x: {
                    grid:  { color: "#1e293b" },
                    ticks: { color: "#64748b", font: { size: 11 } },
                    border: { color: "#1e293b" },
                },
                y: {
                    grid:  { display: false },
                    ticks: { color: "#94a3b8", font: { size: 12, weight: "500" } },
                    border: { display: false },
                },
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "#1e293b",
                    titleColor: "#94a3b8",
                    bodyColor: "#f1f5f9",
                    borderColor: "#334155",
                    borderWidth: 1,
                    callbacks: {
                        label: (ctx) => ` ${ctx.parsed.x} mention${ctx.parsed.x > 1 ? "s" : ""}`,
                    },
                },
            },
        },
    });
}

/* ── Dashboard principal ───────────────────────────────────── */

async function loadDashboard() {
    try {
        const response = await fetch("/api/dashboard", {
            headers: { "Authorization": `Bearer ${token}`, "Accept": "application/json" },
        });

        const data = await response.json();

        if (!response.ok) {
            showToast(data.message || "Impossible de charger le dashboard", "error");
            return;
        }

        const positivePercent = Number(data.positive_percent ?? 0);
        const negativePercent = Number(data.negative_percent ?? 0);
        const averageScore    = Number(data.average_score    ?? 0);

        // KPI textes
        document.getElementById("positivePercent").textContent = `${positivePercent}%`;
        document.getElementById("negativePercent").textContent = `${negativePercent}%`;
        document.getElementById("averageScore").textContent    = `${averageScore}/100`;

        // Barres de progression
        setTimeout(() => {
            document.getElementById("positiveBar").style.width = `${positivePercent}%`;
            document.getElementById("negativeBar").style.width = `${negativePercent}%`;
            document.getElementById("scoreBar").style.width    = `${averageScore}%`;
        }, 100);

        // Graphiques
        buildSentimentChart(positivePercent, negativePercent);
        buildTopicsChart(data.top_topics || []);

        // Avis récents
        const recentEl = document.getElementById("recentReviews");
        const reviews  = data.recent_reviews || [];

        if (!reviews.length) {
            recentEl.innerHTML = `<p class="text-center text-slate-600 text-sm py-6">Aucun avis récent.</p>`;
            return;
        }

        recentEl.innerHTML = reviews.map((review) => {
            const score    = Number(review.score ?? 0);
            const userName = escapeHtml(review.user?.name || "Utilisateur");
            const avatar   = initials(review.user?.name || "?");
            const topics   = review.topics || [];

            const scoreColor = score >= 70 ? "bg-emerald-500" : score >= 40 ? "bg-amber-500" : "bg-red-500";

            return `
            <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-4 space-y-3 hover:border-slate-700 transition-colors">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-violet-600/20 border border-violet-500/30
                                    flex items-center justify-center text-violet-400 font-bold text-xs flex-shrink-0">
                            ${escapeHtml(avatar)}
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">${userName}</p>
                            <p class="text-slate-500 text-xs">${formatDate(review.created_at)}</p>
                        </div>
                    </div>
                    ${sentimentBadge(review.sentiment)}
                </div>
                <p class="text-slate-400 text-sm leading-relaxed line-clamp-2">${escapeHtml(review.content)}</p>
                <div>
                    <div class="flex justify-between text-xs text-slate-600 mb-1">
                        <span>Score IA</span><span>${score}/100</span>
                    </div>
                    <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full ${scoreColor} rounded-full" style="width:${score}%"></div>
                    </div>
                </div>
                ${topics.length ? `
                <div class="flex flex-wrap gap-1.5">
                    ${topics.map((t) => `<span class="px-2 py-0.5 bg-slate-800 text-slate-500 border border-slate-700 rounded text-xs">${escapeHtml(t)}</span>`).join("")}
                </div>` : ""}
            </div>`;
        }).join("");
    } catch (err) {
        showToast("Erreur réseau lors du chargement.", "error");
    }
}

/* ── Déconnexion ───────────────────────────────────────────── */

async function logoutStats() {
    try {
        await fetch("/api/logout", {
            method: "POST",
            headers: { "Authorization": `Bearer ${token}`, "Accept": "application/json" },
        });
    } finally {
        localStorage.clear();
        window.location.href = "/frontend/login.html";
    }
}

/* ── Init ──────────────────────────────────────────────────── */
loadDashboard();
