$(document).ready(function() {
    const getUsers = async () => {
        const usersMainContainer = $('#users-main-content');
        try {
            const data = await fetch('/users', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const users = await data.json();
            
            if(users && users.length > 0) {
                users.map(item => {
                    usersMainContainer.append(`
                    <div class="col mb-5">
                        <div class="card h-100">
                            <img class="card-img-top" src="https://user-images.githubusercontent.com/11250/39013954-f5091c3a-43e6-11e8-9cac-37cf8e8c8e4e.jpg" alt="imange_generic" />
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h5 class="fw-bolder">${item.userName ?? ''} ${item.firstName ?? ''} ${item.lastName ?? ''}</h5>
                                    ${item.email}
                                </div>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent" style="display: flex; justify-content: space-around;">
                                <div class="text-center open-modal-edit-user" id="edit-${item.id}"><a class="btn btn-outline-dark mt-auto" href="#">Edit</a></div>
                                <div class="text-center open-modal-drop-user" id="${item.id}"><a class="btn btn-danger mt-auto" href="#">Delete</a></div>
                            </div>
                        </div>
                    </div>
                    `);

                });
            } else {
                usersMainContainer.html('<h1>No users found</h1>');
            }
        } catch(err) {
            usersMainContainer.html('<h1>Something went wrong</h1>');
        }
    }
    
    getUsers();

    let idChagesGlobal = null;

    // DROP Modal
    $(document).on('click', '.open-modal-drop-user', function(e) {
        $('#dropModal').modal('show');
        const elementId = $(this).attr('id'); 
        idChagesGlobal = elementId;
    });
    
    $('#close-modal-drop-user').click(function() {
        $('#dropModal').modal('hide');
        idChagesGlobal = null;
    });

    $('#button-drop-modal').click(async function() {
        if(idChagesGlobal) {
            try {
                const request = await fetch(`/users/${idChagesGlobal}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                const response = await request.json();
                if(response) {
                    $('#dropModal').modal('hide');
                    window.location.reload();
                }
            } catch(err) {
            }
        }
    });

    // Create Modal
    $('#open-modal-create-user').click(function() {
        dropFormValues();
        $('#modal-add-edit-title').html('Create User');
        $('#addModal').modal('show');
    });

    $('#close-modal-create-user').click(function() {
        $('#addModal').modal('hide');
    });

    $('#button-create-user').click(async function() {
        const userName = $('#name').val();
        const firstName = $('#firstName').val();
        const lastName = $('#lastName').val();
        const email = $('#email').val();
        const data = {
            username: `${userName}`.toUpperCase(),
            firstName: `${firstName}`.toUpperCase(),
            lastName: `${lastName}`.toUpperCase(),
            email
        }

        const label = $('#modal-add-edit-title').html();
        const isOk = validateAddForm(data);
        if(isOk) {
            const formData = new FormData();
            formData.append('username', data.username);
            formData.append('firstName', data.firstName);
            formData.append('lastName', data.lastName);
            formData.append('email', data.email);

            try {
                let request = null;

                if(label === 'Create User') {
                    request = await fetch('/users', {
                        method: 'POST',
                        headers: {
                        },
                        body: formData
                    });
                } else {
                    request = await fetch(`/users/update/${idChagesGlobal}`, {
                        method: 'POST',
                        headers: {
                        },
                        body: formData
                    });
                }
                const response = await request.json();
                if(response) {
                    $('#addModal').modal('hide');
                    window.location.reload();
                }
            } catch(err) {
            }
        }
    });

    $(document).on('click', '.open-modal-edit-user', async function(e) {
        $('#modal-add-edit-title').html('Edit User');
        $('#addModal').modal('show');
        let elementId = $(this).attr('id');
        elementId = `${elementId}`.split('-')[1];
        idChagesGlobal = elementId;
        const user = await getUserById(elementId);
        if(user) {
            $('#name').val(user.userName);
            $('#firstName').val(user.firstName);
            $('#lastName').val(user.lastName);
            $('#email').val(user.email);
        }
    });
    
    $('#logout-button').click(async function() {
        try {
            const request = await fetch('/auth/logout', {
                method: 'POST',
                headers: {
                }
            });
            const response = await request.json();
            if(response) {
                window.location.href = '/';
            }
        } catch(err) {
        }
    });
});

const validateAddForm = (data) => {
    const { username, firstName, lastName, email } = data;
    let msgError = '';
    let isOk = true;
    if(!username) {
        isOk = false;
        msgError = 'The user name is required';
    }

    if(!firstName) {
        isOk = false;
        msgError = 'The first name is required';
    }

    if(!lastName) {
        isOk = false;
        msgError = 'The last name is required';
    }

    if(!email) {
        isOk = false;
        msgError = 'The email is required';
    }

    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if(email && !emailRegex.test(email)) {
        isOk = false;
        msgError = 'The email is not valid';
    }

    if(!isOk) {
        $('#alert-add-form').css('display', 'block');
        $('#alert-add-form-content').html(`<p>${msgError}</p>`);
        setTimeout(() => {
            $('#alert-add-form').css('display', 'none');
        }, 1000);
        return false;
    }
    return isOk;
}

const getUserById = async (id) => {
    try {
        const request = await fetch(`/users/${id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        const response = await request.json();
        if(request.status === 200) {
            if(response.length > 0) {
                return response[0];
            } else {
                return null;
            }
        } else {
            return null;
        }
    } catch(err) {
        return null;
    }
}

const dropFormValues = () => {
    $('#name').val('');
    $('#firstName').val('');
    $('#lastName').val('');
    $('#email').val('');
}