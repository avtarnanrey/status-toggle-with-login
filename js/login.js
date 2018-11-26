(function () {
    // Variables
    var $error = [];
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var usernameError = document.getElementById("invalid-username");
    var passwordError = document.getElementById("invalid-password");

    // Functions
    function loginRequest(data) {
        console.log(data);
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
            if ($error.indexOf(username) === -1) {
                usernameError.style.display = "block";
            }
            if ($error.indexOf(password) === -1) {
                passwordError.style.display = "block";
            }
        }
    });
})();