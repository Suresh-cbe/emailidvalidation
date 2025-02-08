<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .container {
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Email Verification</h1>
        <form id="emailForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">We'll check if this email address is valid.</div>
                <div id="email-error" class="text-danger"></div>
                <div id="email-success" class="text-success"></div>
            </div>
            <button type="submit" class="btn btn-primary">Check Email</button>
        </form>

        <div id="results" class="mt-3"></div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#emailForm").submit(function (event) {
                event.preventDefault();

                $("#email-error").text("");
                $("#email-success").text("");
                const email = $("#email").val();

                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailRegex.test(email)) {
                    $("#email-error").text("Invalid email format.");
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "",
                    data: { email: email, action: "check_email" },
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "valid") {
                            $("#email-success").text(response.message);
                            $("#results").html("<p class='text-success'>Email is valid!</p>");
                        } else {
                            $("#email-error").text(response.message);
                            $("#results").html("<p class='text-danger'>Email is not valid: " + response.message + "</p>");
                        }
                    },
                    error: function (error) {
                        $("#email-error").text("An error occurred. Please try again.");
                        console.error("AJAX Error:", error);
                    }
                });
            });
        });
    </script>


    <?php
    if (isset($_POST['action']) && $_POST['action'] === "check_email" && isset($_POST['email'])) {
        $email = $_POST['email'];

        function is_valid_email_format($email)
        {
            $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
            return preg_match($pattern, $email);
        }

        function check_email_domain($email)
        {
            $domain = explode("@", $email)[1];
            if (!checkdnsrr($domain, "A")) {
                return [false, "Domain does not exist"]; // Corrected return
            }
            $has_mx = checkdnsrr($domain, "MX");
            $message = $has_mx ? "Domain has MX records" : "Domain does not have MX records";
            return [$has_mx, $message]; // Corrected return
        }


        if (!is_valid_email_format($email)) {
            echo json_encode(["status" => "invalid", "message" => "Invalid email format."]);
            exit;
        }

        $domain_check_result = check_email_domain($email); // Get the array
        $is_domain_valid = $domain_check_result[0]; // Access the first element (boolean)
        $domain_message = $domain_check_result[1]; // Access the second element (message)


        if (!$is_domain_valid) {
            echo json_encode(["status" => "invalid", "message" => $domain_message]);
            exit;
        }

        echo json_encode(["status" => "valid", "message" => "Email is valid."]);
        exit;
    }
    ?>

</body>

</html>
