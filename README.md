# Email Verification Tool

This is a free and open-source email verification tool that checks the format and domain validity of email addresses. It uses a combination of client-side JavaScript for basic format checks and server-side PHP for more thorough validation, including DNS lookups for MX records.  It does *not* use any third-party email verification APIs, making it completely free to use without API keys or rate limits.

## Features

*   **Client-side format validation:** Provides instant feedback to the user if the email format is incorrect.
*   **Server-side validation:** Performs more in-depth checks, including verifying the domain's existence and checking for MX records (which indicate if the domain is set up to receive email).
*   **No third-party API dependencies:**  Completely free to use without API keys or usage limits.
*   **Easy to use:** Simple HTML form with clear instructions.
*   **Bootstrap 5 integration:** Uses Bootstrap 5 for styling, making it responsive and visually appealing.
*   **Open Source:**  Free to use, modify, and distribute under a permissive license (MIT License - see LICENSE file).

## How it Works

1.  The user enters an email address in the form.
2.  JavaScript performs a basic format check using a regular expression.
3.  If the format is valid, an AJAX request is sent to the server (the same HTML file).
4.  The server-side PHP code performs the following checks:
    *   More robust format validation.
    *   Checks if the domain exists (A record lookup).
    *   Checks for MX records (Mail Exchange records).
5.  The server sends a JSON response back to the client, indicating whether the email is valid or not.
6.  JavaScript displays the result to the user.

## Limitations

*   **No mailbox verification:** This tool only checks the *format* and *domain*. It does *not* verify if the specific email address (e.g., `user@example.com`) actually exists or is active.  It's possible for a domain to have MX records, but the specific user's mailbox might not exist.
*   **Basic checks:**  The checks are limited to format and DNS.  It does not check for disposable email addresses, spam traps, or other more advanced checks.

## Usage

1.  Copy the HTML code into a file named `index.html` (or any other `.html` file).
2.  Open the `index.html` file in your web browser.
3.  Enter an email address in the form and click the "Check Email" button.
4.  The result will be displayed on the page.

## Contributing

Contributions are welcome!  Please open an issue or submit a pull request if you have any suggestions or bug fixes.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Disclaimer

This email verification tool is provided "as is" without any warranty of any kind, express or implied. The authors are not liable for any damages or losses arising from the use of this tool.  It is recommended to use additional email verification methods (like double opt-in) for critical applications.
