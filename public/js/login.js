document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    console.log("login click");

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const errorEl = document.getElementById("error"); // ✅ IMPORTANT

    const response = await fetch("/api/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json" // 🔥 important aussi
        },
        body: JSON.stringify({
            email,
            password
        })
    });

    const data = await response.json();
    console.log(response.status, data);

    //gestion erreur
    if (response.status === 401) {
        errorEl.innerText = "Identifiants invalides";
        return;
    }

    //succès
    if (data.token) {
        localStorage.setItem("token", data.token);
        localStorage.setItem("role", data.user.role);

        if (data.user.role === "admin") {
            window.location.href = "/admin";
        } else {
            window.location.href = "/reviews";
        }
    }
});