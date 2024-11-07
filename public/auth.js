$(document).ready(function() {
    $('#login-form').submit(async function(e) {
        e.preventDefault();
        $('#login-failed').css('display', 'none');
        const user = $('#user').val();
        const password = $('#password').val();

        if(user && password) {
            const formData = new FormData();
            formData.append('user', user);
            formData.append('password', password);
            const response = await fetch('/auth/login', {
                method: 'POST',
                headers: {
                },
                body: formData
            });

            const result = await response.json();
            if(result && result.message == 'Login success') {
                window.location.href = '/';
            } else {
                $('#login-failed').css('display', 'block');
            }
        }
    });
    
});