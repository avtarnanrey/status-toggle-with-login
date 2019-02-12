(function () {
    // Variables
    var $error = [];
    var name = document.getElementById("name");
    var email = document.getElementById("email");
    var membership = document.getElementById("membership");
    var username = document.getElementById("username");
    var password = document.getElementById("password");
    var signupError = document.getElementById("signup-error");
    var usernameError = document.getElementById("username-error");
    var memberError = document.getElementById("member-error");
    var emailError = document.getElementById("email-error");
    var passwordError = document.getElementById("password-error");

    // Functions
    function signupRequest(data) {
        fetch("http://dev.avtarnanrey.com/rangeburlington/ports/api/signup/", {
            body: data,
            method: "post"
        }
        ).then((response) => response.text())
            .then(data => {
                (data === "1") ? window.location.replace("index.php") : signupError.style.display = "block";
            })
            .catch((reason) => {
                console.log(reason);
            })
    }

    // Events and Conditions
    document.getElementById("signupForm").addEventListener("submit", function (e) {
        e.preventDefault();
        // Validate
        var formData = new FormData(document.querySelector("#signupForm"));
        if (!username.value) {
            $error.push(username);
        }
        if (!email.value) {
            $error.push(email);
        }
        if (!membership.value) {
            $error.push(membership);
        }
        if (!password.value) {
            $error.push(password);
        }
        if ($error.length === 0) {
            signupRequest(formData);
        } else {
            if ($error.indexOf(username) !== -1) {
                usernameError.style.display = "block";
            } else if ($error.indexOf(email) !== -1) {
                emailError.style.display = "block";
            } else if ($error.indexOf(membership) !== -1) {
                memberError.style.display = "block";
            } else if ($error.indexOf(password) !== -1) {
                passwordError.style.display = "block";
            }
        }
    });

    // Reset Errors
    username.addEventListener('keyup', function () {
        signupError.style.display = "none";
        usernameError.style.display = "none";
        $error = [];
    });
    membership.addEventListener('keyup', function () {
        signupError.style.display = "none";
        memberError.style.display = "none";
        $error = [];
    });
    email.addEventListener('keyup', function () {
        signupError.style.display = "none";
        emailError.style.display = "none";
        $error = [];
    });
    password.addEventListener('keyup', function () {
        passwordError.style.display = "none";
        $error = [];
    });
})();