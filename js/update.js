(function () {
    // Variables
    var $error = [];
    var username = document.querySelectorAll("#updatePort");
    var usernameItems = [].slice.call(username);

    // Functions
    function updateRequest(data) {
        fetch("http://localhost/status-toggle-with-login/api/update/", {
            body: data,
            method: "post",
            // headers: {
            //     "Content-Type": "application/json"
            // },
            // body: JSON.stringify({
            //     "payload": data
            // })
        }
        ).then((response) => response.text())
            .then(data => {
                // console.log(data);
                (data == "1") ? location.reload() : alert("Woops! Something is wrong. Please inform webmaster!");
            })
            .catch((reason) => {
                console.log(reason);
            })
    }

    // Events and Conditions
    usernameItems.forEach(function (item, idx) {
        item.addEventListener("click", function (e) {
            e.preventDefault();
            // Validate
            var portId = this.dataset.port;
            var formData = new FormData();
            formData.append("portId", portId);
            if (portId <= 12) {
                updateRequest(formData);
            }
        });
    });
})();