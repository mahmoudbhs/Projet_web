const token = localStorage.getItem("token");

//Ajouter review
document.getElementById("reviewForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const content = document.getElementById("content").value;
    if (!content) {
      alert("Ecris un avis !");
      return;
    }
    await fetch("http://127.0.0.1:8000/api/reviews", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer "+ token,
            "Accept": "application/json"
        },
        body: JSON.stringify({
            content: content 
        })
    });

    loadReviews();
});

//Charger reviews
async function loadReviews() {
    const res = await fetch("http://127.0.0.1:8000/api/reviews", {
        headers: {
            "Authorization": "Bearer "+ token,
            "Accept": "application/json"
        }
    });

    const text = await res.text();
    console.log("RAW:", text);

    let data;
    try {
        data = JSON.parse(text);
    } catch (e) {
        console.error("PAS JSON:", text);
        return;
    }
    if (!Array.isArray(data)) {
    console.error("Erreur API:", data);
    return;
   }

    const user = JSON.parse(localStorage.getItem("user"));

     
    document.getElementById("reviewsList").innerHTML =
      data.map(r => `
         <p>
             <b>${r.user.name}</b> : ${r.content}

             ${
                user && (user.role === "admin" || user.id === r.user.id)
                ? `<button onclick="deleteReview(${r.id})">Delete</button>`
                : ""
             }
          </p>
     `).join("");
}

//Supprimer
async function deleteReview(id) {
    await fetch(`http://127.0.0.1:8000/api/reviews/${id}`, {
        method: "DELETE",
        headers: {
            "Authorization": "Bearer " + token,
            "Accept": "application/json"
        }
    });

    loadReviews();
}
function logout() {
    localStorage.clear();
    window.location.href = "/login";
}

//au chargement
loadReviews();