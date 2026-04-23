const token = localStorage.getItem("token");
const role = localStorage.getItem("role");
const storedUser = localStorage.getItem("user");
const currentUser = storedUser ? JSON.parse(storedUser) : null;

const reviewsList = document.getElementById("reviewsList");
const adminName = document.getElementById("adminName");
const adminRole = document.getElementById("adminRole");
const adminAvatar = document.getElementById("adminAvatar");
const totalReviews = document.getElementById("totalReviews");
const positiveReviews = document.getElementById("positiveReviews");
const negativeReviews = document.getElementById("negativeReviews");

if (!token) {
    window.location.href = "/frontend/login.html";
} else if (role !== "admin") {
    alert("Acces refuse");
    window.location.href = "/frontend/login.html";
}

if (currentUser) {
    if (adminName) {
        adminName.textContent = currentUser.name || "Admin";
    }
    if (adminRole) {
        adminRole.textContent = (currentUser.role || "admin").toUpperCase();
    }
    if (adminAvatar) {
        const source = currentUser.name || currentUser.email || "A";
        adminAvatar.textContent = source.charAt(0).toUpperCase();
    }
}

function updateCounters(reviews) {
    const total = reviews.length;
    const positive = reviews.filter((review) => review.sentiment === "positive").length;
    const negative = reviews.filter((review) => review.sentiment === "negative").length;

    if (totalReviews) {
        totalReviews.textContent = String(total);
    }
    if (positiveReviews) {
        positiveReviews.textContent = String(positive);
    }
    if (negativeReviews) {
        negativeReviews.textContent = String(negative);
    }
}

function reviewTopics(topics) {
    if (!Array.isArray(topics) || topics.length === 0) {
        return '<span class="text-slate-500">Aucun theme</span>';
    }

    return topics.map((topic) => `
        <span class="px-2 py-1 rounded-full bg-slate-800 border border-slate-700 text-slate-300 text-xs">
            ${topic}
        </span>
    `).join("");
}

function sentimentBadge(sentiment) {
    if (sentiment === "positive") {
        return "bg-emerald-500/10 text-emerald-400 border-emerald-500/20";
    }
    if (sentiment === "negative") {
        return "bg-red-500/10 text-red-400 border-red-500/20";
    }

    return "bg-slate-700/40 text-slate-300 border-slate-600/50";
}

async function loadReviews() {
    if (!reviewsList) {
        return;
    }

    reviewsList.innerHTML = `
        <div class="flex items-center justify-center py-16">
            <div class="flex flex-col items-center gap-3">
                <svg class="w-8 h-8 text-amber-400 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                <p class="text-slate-500 text-sm">Chargement des avis...</p>
            </div>
        </div>
    `;

    try {
        const res = await fetch("/api/reviews", {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });

        if (res.status === 401) {
            clearSessionAndRedirect();
            return;
        }

        if (!res.ok) {
            reviewsList.innerHTML = "<p class=\"text-slate-400\">Impossible de charger les avis.</p>";
            return;
        }

        const data = await res.json();

        if (!Array.isArray(data)) {
            reviewsList.innerHTML = "<p class=\"text-slate-400\">Format de donnees invalide.</p>";
            return;
        }

        updateCounters(data);

        if (data.length === 0) {
            reviewsList.innerHTML = `
                <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-8 text-center text-slate-400">
                    Aucun avis disponible pour le moment.
                </div>
            `;
            return;
        }

        reviewsList.innerHTML = data.map((review) => `
            <article class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5 shadow-xl">
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-white font-semibold">${review.user?.name ?? "Utilisateur inconnu"}</span>
                            <span class="text-slate-500 text-sm">${review.user?.email ?? "Email indisponible"}</span>
                            <span class="px-2.5 py-1 rounded-full border text-xs font-medium ${sentimentBadge(review.sentiment)}">
                                ${review.sentiment ?? "neutral"}
                            </span>
                            <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-300 border border-amber-500/20 text-xs font-medium">
                                Score ${review.score ?? 0}
                            </span>
                        </div>
                        <p class="text-slate-200 leading-relaxed">${review.content ?? ""}</p>
                        <div class="flex flex-wrap gap-2">
                            ${reviewTopics(review.topics)}
                        </div>
                    </div>
                    <div class="flex md:flex-col gap-2 md:min-w-32">
                        <button type="button"
                            onclick="deleteReview(${review.id})"
                            class="w-full px-4 py-2 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-300 border border-red-500/20 transition-colors text-sm font-medium">
                            Supprimer
                        </button>
                    </div>
                </div>
            </article>
        `).join("");
    } catch (error) {
        reviewsList.innerHTML = "<p class=\"text-slate-400\">Erreur reseau pendant le chargement.</p>";
    }
}

async function deleteReview(id) {
    try {
        const res = await fetch(`/api/reviews/${id}`, {
            method: "DELETE",
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });

        if (res.status === 401) {
            clearSessionAndRedirect();
            return;
        }

        if (!res.ok) {
            alert("Suppression impossible.");
            return;
        }

        loadReviews();
    } catch (error) {
        alert("Erreur reseau pendant la suppression.");
    }
}

async function logoutAdmin() {
    try {
        await fetch("/api/logout", {
            method: "POST",
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: "application/json",
            },
        });
    } catch (error) {
        // Ignore logout network issues and clear local session anyway.
    }

    clearSessionAndRedirect();
}

function clearSessionAndRedirect() {
    localStorage.removeItem("token");
    localStorage.removeItem("user");
    localStorage.removeItem("role");
    window.location.href = "/frontend/login.html";
}

window.loadReviews = loadReviews;
window.deleteReview = deleteReview;
window.logoutAdmin = logoutAdmin;

loadReviews();
