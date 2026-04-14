const token = localStorage.getItem("token");

async function loadReviews() {
    const res = await fetch("/api/reviews", {
        headers: { Authorization: `Bearer ${token}` }
    });

    const data = await res.json();

    document.getElementById("reviewsList").innerHTML =
        data.map(r => `
            <p>
                ${r.content} 
                <button onclick="deleteReview(${r.id})">Delete</button>
            </p>
        `).join("");
}

async function deleteReview(id) {
    await fetch(`/api/reviews/${id}`, {
        method: "DELETE",
        headers: { Authorization: `Bearer ${token}` }
    });

    loadReviews(); 
}

// 🔥 charger au début
loadReviews();