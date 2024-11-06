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
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Edit</a></div>
                                <div class="text-center open-modal-drop-user"><a class="btn btn-danger mt-auto" href="#">Delete</a></div>
                            </div>
                        </div>
                    </div>
                    `);

                });
            } else {
                usersMainContainer.html('<h1>No users found</h1>');
            }
        } catch(err) {
            console.log(err);
            usersMainContainer.html('<h1>Something went wrong</h1>');
        }
    }
    
    getUsers();


    $(document).on('click', '.open-modal-drop-user', function() {
        $('#dropModal').modal('show');
    });
    $('#close-modal-drop-user').click(function() {
        $('#dropModal').modal('hide');
    });


});