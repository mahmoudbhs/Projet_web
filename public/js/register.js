document.getElementById("registerForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    console.log("register click");

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const password_confirmation = document.getElementById("password_confirmation").value;
    const errorEl = document.getElementById("error");

    const response = await fetch("/api/register", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            name,
            email,
            password,
            password_confirmation
        })
    });

    const data = await response.json();
    console.log(response.status, data);

    // ❌ erreur
    if (!response.ok) {
        errorEl.innerText = "Erreur inscription";
        return;
    }

    // ✅ succès
    alert("Compte créé !");
    window.location.href = "/login";
});