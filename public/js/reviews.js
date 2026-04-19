const token = localStorage.getItem("token");
const user  = JSON.parse(localStorage.getItem("user") || "null");

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
    return (name || "?")
        .split(" ")
        .map((w) => w[0])
        .join("")
        .slice(0, 2)
        .toUpperCase();
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

function scoreBarColor(score) {
    if (score >= 70) return "bg-emerald-500";
    if (score >= 40) return "bg-amber-500";
    return "bg-red-500";
}

function showToast(message, type = "success") {
    const colors = {
        success: "bg-emerald-600 text-white",
        error:   "bg-red-600 text-white",
        info:    "bg-violet-600 text-white",
    };
    const container = document.getElementById("toastContainer");
    const toast = document.createElement("div");
    toast.className = `pointer-events-auto flex items-center gap-2 px-4 py-3 rounded-xl shadow-lg text-sm font-medium
                       ${colors[type] || colors.info} transition-all duration-300`;
    toast.innerHTML = `
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="${type === "error"
                    ? "M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    : "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"}"/>
        </svg>
        ${escapeHtml(message)}`;
    container.appendChild(toast);
    setTimeout(() => { toast.style.opacity = "0"; setTimeout(() => toast.remove(), 300); }, 3500);
}

/* ── Affichage utilisateur ─────────────────────────────────── */

if (user) {
    const nameEl   = document.getElementById("userName");
    const roleEl   = document.getElementById("userRole");
    const avatarEl = document.getElementById("userAvatar");
    if (nameEl)   nameEl.textContent   = user.name || "Utilisateur";
    if (roleEl)   roleEl.textContent   = user.role === "admin" ? "Administrateur" : "Utilisateur";
    if (avatarEl) avatarEl.textContent = initials(user.name);
}

/* ── Compteur de caractères ────────────────────────────────── */

function updateCharCount(textarea) {
    const len = textarea.value.length;
    const el  = document.getElementById("charCount");
    if (el) el.textContent = `${len} caractère${len !== 1 ? "s" : ""}`;
}

/* ── Chargement des avis ───────────────────────────────────── */

async function loadReviews() {
    const listEl = document.getElementById("reviewsList");
    listEl.innerHTML = `
        <div class="flex items-center justify-center py-16">
            <div class="flex flex-col items-center gap-3">
                <svg class="w-8 h-8 text-violet-500 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                <p class="text-slate-500 text-sm">Chargement…</p>
            </div>
        </div>`;

    try {
        const res  = await fetch("/api/reviews", {
            headers: { "Authorization": `Bearer ${token}`, "Accept": "application/json" },
        });
        const data = await res.json();

        if (!res.ok) {
            listEl.innerHTML = `<p class="text-center text-red-400 py-8">${escapeHtml(data.message || "Impossible de charger les avis")}</p>`;
            return;
        }

        if (!data.length) {
            listEl.innerHTML = `
                <div class="text-center py-16">
                    <svg class="w-12 h-12 text-slate-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-slate-500 text-sm">Aucun avis pour le moment.<br>Soyez le premier à partager votre expérience !</p>
                </div>`;
            return;
        }

        listEl.innerHTML = data.map((review, idx) => {
            const score    = Number(review.score ?? 0);
            const canDel   = user && (user.role === "admin" || user.id === review.user_id);
            const topics   = review.topics || [];
            const userName = escapeHtml(review.user?.name || "Utilisateur");
            const avatar   = initials(review.user?.name || "?");

            return `
            <article class="review-card bg-slate-900/80 border border-slate-800 rounded-2xl p-5 space-y-4
                            hover:border-slate-700 transition-colors" style="animation-delay:${idx * 0.04}s">
                <!-- En-tête -->
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-full bg-violet-600/20 border border-violet-500/30
                                    flex items-center justify-center text-violet-400 font-bold text-sm flex-shrink-0">
                            ${escapeHtml(avatar)}
                        </div>
                        <div class="min-w-0">
                            <p class="text-white font-semibold text-sm truncate">${userName}</p>
                            <p class="text-slate-500 text-xs">${formatDate(review.created_at)}</p>
                        </div>
                    </div>
                    ${sentimentBadge(review.sentiment)}
                </div>

                <!-- Contenu -->
                <p class="text-slate-300 text-sm leading-relaxed">${escapeHtml(review.content)}</p>

                <!-- Score IA -->
                <div>
                    <div class="flex justify-between text-xs text-slate-500 mb-1.5">
                        <span>Score IA</span>
                        <span class="font-medium text-slate-400">${score}/100</span>
                    </div>
                    <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full ${scoreBarColor(score)} rounded-full transition-all duration-700" style="width:${score}%"></div>
                    </div>
                </div>

                <!-- Thèmes -->
                ${topics.length ? `
                <div class="flex flex-wrap gap-1.5">
                    ${topics.map((t) => `
                        <span class="px-2 py-0.5 bg-slate-800 text-slate-400 border border-slate-700 rounded-md text-xs">
                            ${escapeHtml(t)}
                        </span>`).join("")}
                </div>` : ""}

                <!-- Actions -->
                ${canDel ? `
                <div class="pt-1 border-t border-slate-800">
                    <button onclick="deleteReview(${review.id})"
                        class="flex items-center gap-1.5 text-slate-500 hover:text-red-400 text-xs transition-colors group">
                        <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Supprimer
                    </button>
                </div>` : ""}
            </article>`;
        }).join("");
    } catch (err) {
        listEl.innerHTML = `<p class="text-center text-red-400 py-8">Erreur réseau lors du chargement.</p>`;
    }
}

/* ── Soumettre un avis ─────────────────────────────────────── */

document.getElementById("reviewForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const content   = document.getElementById("content").value.trim();
    const submitBtn = document.getElementById("submitReviewBtn");
    const spinner   = document.getElementById("submitSpinner");
    const icon      = document.getElementById("submitIcon");

    if (!content) return;

    submitBtn.disabled = true;
    spinner.classList.remove("hidden");
    icon.classList.add("hidden");

    try {
        const res = await fetch("/api/reviews", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${token}`,
                "Accept": "application/json",
            },
            body: JSON.stringify({ content }),
        });

        if (!res.ok) {
            const data = await res.json();
            showToast(data.message || "Erreur lors de la création", "error");
            return;
        }

        document.getElementById("content").value = "";
        updateCharCount(document.getElementById("content"));
        showToast("Avis publié et analysé avec succès !", "success");
        await loadReviews();
    } catch (err) {
        showToast("Erreur réseau. Réessayez.", "error");
    } finally {
        submitBtn.disabled = false;
        spinner.classList.add("hidden");
        icon.classList.remove("hidden");
    }
});

/* ── Supprimer un avis ─────────────────────────────────────── */

async function deleteReview(id) {
    try {
        const res = await fetch(`/api/reviews/${id}`, {
            method: "DELETE",
            headers: { "Authorization": `Bearer ${token}`, "Accept": "application/json" },
        });

        if (!res.ok) {
            showToast("Suppression impossible", "error");
            return;
        }

        showToast("Avis supprimé", "info");
        await loadReviews();
    } catch (err) {
        showToast("Erreur réseau", "error");
    }
}

/* ── Déconnexion ───────────────────────────────────────────── */

async function logout() {
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
loadReviews();
