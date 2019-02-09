(function () {
    // Variables
    var $error = [];
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var loginError = document.getElementById("login-error");
    var usernamePasswordError = document.getElementById("username-password-error");

    // Functions
    function loginRequest(data) {
        fetch("http://localhost/status-toggle-with-login/api/login/", {
            body: data,
            method: "post"
        }
        ).then((response) => response.text())
            .then(data => {
                (data === "1") ? window.location.replace("index.php") : loginError.style.display = "block";
            })
            .catch((reason) => {
                console.log(reason);
            })
    }

    // Events and Conditions
    document.getElementById("loginForm").addEventListener("submit", function (e) {
        e.preventDefault();
        // Validate
        var formData = new FormData(document.querySelector("#loginForm"));
        if (!username.value) {
            $error.push(username);
        }
        if (!password.value) {
            $error.push(password);
        }
        if ($error.length === 0) {
            loginRequest(formData);
        } else {
            if ($error.indexOf(username) !== -1 || $error.indexOf(password) !== -1) {
                usernamePasswordError.style.display = "block";
            }
        }
    });

    // Reset Errors
    username.addEventListener('keyup', function () {
        usernamePasswordError.style.display = "none";
        loginError.style.display = "none";
        $error = [];
    })
})();