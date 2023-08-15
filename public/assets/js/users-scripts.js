/**
 * Function to populate a form.
 * Fetches data from the selected user option to populate the fields
 * of a form: including the username, password, email and admin status.
 */
function populateForm() {
    // Fetch the selected option from the 'users' dropdown.
    const selectedUser = document.getElementById('users').selectedOptions[0];

    // Get the form fields: username, password, email, and admin status.
    const usernameField = document.getElementById('username');
    const deleteUsernameField = document.getElementById('delete-username'); // Get the hidden input field
    const passwordField = document.getElementById('password');
    const emailField = document.getElementById('email');
    const adminCheckbox = document.getElementById('admin');

    // Extract the user's data from the selected option.
    // The data is contained in the option's 'data-' attributes.
    const username = selectedUser.dataset.username;
    const password = selectedUser.dataset.password;
    const email = decodeURIComponent(selectedUser.dataset.email);
    const admin = selectedUser.dataset.admin;

    // Populate the form fields with the user's data or set to default values if not specified.
    usernameField.value = username || '';
    deleteUsernameField.value = username || ''; // Set the hidden input field value
    passwordField.value = 'PASSWORD'; // Set password field to a static value 'PASSWORD'.
    emailField.value = email || '';
    adminCheckbox.checked = admin === 'true' ? true : false; // Set checkbox status depending on the user's admin status.
}
