document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    console.log("login click"); // test

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    const response = await fetch("/api/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            email,
            password
        })
    });

    const data = await response.json();
    console.log(data);

    if (data.token) {
    localStorage.setItem("token", data.token);
    localStorage.setItem("role", data.user.role); // 🔥 important
    window.location.href = "/reviews";
    if (data.user.role === "admin") {
        window.location.href = "/reviews-console";
    } else {
        window.location.href = "/reviews";
    }
    }
});