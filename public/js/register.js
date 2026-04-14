document.getElementById("registerForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const password_confirmation = document.getElementById("password_confirmation").value;

    const res = await fetch("/api/register", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            name,
            email,
            password,
            password_confirmation
        })
    });

    const data = await res.json();
    console.log(data);

    if (data.token) {
        localStorage.setItem("token", data.token);
        localStorage.setItem("role", data.user.role);
        window.location.href = data.user.role === "admin" ? "/admin" : "/reviews";
    }
});