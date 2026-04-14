const token = localStorage.getItem("token");

fetch("/api/reviews", {
    headers: { Authorization: `Bearer ${token}` }
})
.then(res => res.json())
.then(data => {
    document.getElementById("reviewsList").innerHTML =
        data.map(r => `
            <p>${r.content} 
            <button onclick="deleteReview(${r.id})">Delete</button>
            </p>
        `).join("");
});

function deleteReview(id) {
    fetch(`/api/reviews/${id}`, {
        method: "DELETE",
        headers: { Authorization: `Bearer ${token}` }
    }).then(() => location.reload());
}