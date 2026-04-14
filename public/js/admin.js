const token = localStorage.getItem("token");
const role = localStorage.getItem("role");

//sécurité frontend
if (role !== "admin") {
    alert("Accès refusé");
    window.location.href = "/login";
}

//charger reviews
async function loadReviews() {
    const res = await fetch("/api/reviews", {
        headers: {
            Authorization: `Bearer ${token}`
        }
    });

    const data = await res.json();

    document.getElementById("reviewsList").innerHTML =
        data.map(r => `
            <p>
                <b>${r.user.name}</b> : ${r.content}
                <button onclick="deleteReview(${r.id})">Delete</button>
            </p>
        `).join("");
}

//supprimer
async function deleteReview(id) {
    await fetch(`/api/reviews/${id}`, {
        method: "DELETE",
        headers: {
            Authorization: `Bearer ${token}`
        }
    });

    loadReviews();
}

loadReviews();