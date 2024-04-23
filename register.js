const reg_form = document.getElementById("reg-form");
reg_form.addEventListener("submit", function (event) {
    event.preventDefault();
    const name = document.getElementById("name");
    const surname = document.getElementsById("surname");
    const phone = document.getElementById("Телефон за връзка");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirm_password = document.getElementById("confirm_password");
    if (password.value === confirm_password.value) {
        const newUser = JSON.stringify({
            name: name.value,
            surname: surname.value,
            email: email.value,
            password: password.value,
        });
        fetch("https://jsonplaceholder.typicode.com/users", {
            method: "POST",
            body: newUser,
        })
            .then((res) => {
                return res.json();
            })
            .then((data) => {
                if (data.id) {
                    localStorage.setItem("user", newUser);
                    window.location.href = "login.php";
                }
            })
            .catch((error) => console.log(error, "Error"));
    } else {
        alert("The passwords don't match");
        password.value = "";
        confirm_password.value = "";
    }
});
