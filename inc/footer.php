<div class="container-fluid bg-white mt-5">
    <div class="row">
        <div class="col-lg-4 p-4">
            <a href="index.php" class="fs-3 mb-2 text-decoration-none">
                <?= $data_settings['site_title']; ?>
            </a>
            </h3>
            <p>
                <?= $data_settings['site_about']; ?>
            </p>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Links</h5>
            <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a> <br>
            <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a> <br>
            <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilities</a> <br>
            <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact us</a> <br>
            <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About</a> <br>


        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Follow us</h5>
            <?php
            if ($data_contact['tw'] != '') {
                echo <<<data
                <a href="{$data_contact['tw']}" class="d-inline-block mb-2 text-dark text-decoration-none">

                    <i class="bi bi-twitter me-1"></i> twitter
                </a>
                data;
            }
            ?>
            <br />
            <?php
            if ($data_contact['fb'] != '') {
                echo <<<data
            <a href="{$data_contact['fb']}" class="d-inline-block mb-2 text-dark text-decoration-none">

                <i class="bi bi-facebook me-1"></i> facebook
            </a>
            data;
            }
            ?>
            <br />
            <?php
            if ($data_contact['insta'] != '') {
                echo <<<data
            <a href="{$data_contact['insta']}" class="d-inline-block mb-2 text-dark text-decoration-none">

                <i class="bi bi-instagram me-1"></i> instagram
            </a>
            data;
            }
            ?>
            <br />
            <br />
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function setActive() {
        let navbar = document.getElementById('nav-bar');
        let tag_a = navbar.getElementsByTagName('a');
        for (let i = 0; i < tag_a.length; i++) {
            let file = tag_a[i].href.split('/').pop();
            let file_name = file.split('.')[0];
            if (document.location.href.indexOf(file_name) >= 0) {
                tag_a[i].classList.add('active');
            }
        }
    }


    setActive();
    function showToast(message, alertType) {
        document.getElementById('toastMessage').innerText = message;
        document.getElementById('toastAlert').classList.add('bg-' + alertType);
        var toast = new bootstrap.Toast(document.getElementById('toastAlert'));
        toast.show();
        toast._element.addEventListener('hidden.bs.toast', function () {
            document.getElementById('toastAlert').classList.remove('bg-' + alertType);
        });
    }
    let register_form = document.getElementById('register_form');
    register_form.addEventListener('submit', (e) => {
        e.preventDefault();
        let data = new FormData();
        data.append('name', register_form.elements['name'].value);
        data.append('email', register_form.elements['email'].value);
        data.append('phone', register_form.elements['phone'].value);
        data.append('profile', register_form.elements['profile'].files[0]);
        data.append('adresse', register_form.elements['adresse'].value);
        data.append('dob', register_form.elements['dob'].value);
        data.append('pass', register_form.elements['pass'].value);
        data.append('register', '');
        var myModal = document.getElementById('registerModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);
        xhr.onload = function () {
            if (this.responseText == 'ins_failed') {
                showToast('Failed insert', 'danger');
            } else if (this.responseText == 'user_exist' || this.responseText == 'phone_exist') {
                showToast('User Exist', 'danger');
            } else if (this.responseText == 'inv_img') {
                showToast('Image Not Valid', 'danger');
            } else if (this.responseText == 'upl_failed') {
                showToast('Image Failed to upload', 'danger');
            } else {
                showToast('Insertion Successfully', 'success');
                register_form.reset();
            }
        }
        xhr.send(data);
    });

    let login_form = document.getElementById('login_form');
    login_form.addEventListener('submit', (e) => {
        e.preventDefault();
        let data = new FormData();
        data.append('email_mobile', login_form.elements['email_mobile'].value);
        data.append('pass', login_form.elements['pass'].value);
        data.append('login', '');
        var myModal = document.getElementById('loginModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);
        xhr.onload = function () {
            if (this.responseText == 'invalid_email_mobile') {
                showToast('Email Or Phone number is Invalid', 'danger');
            } else if (this.responseText == 'inv_pass') {
                showToast('Invalid Password', 'danger');
            } else {
                // let fileUrl = window.location.href.split('/').pop().split('?').shift();
                // if (fileUrl == 'details_room.php') {
                //     window.location = window.location.href;
                // } else {
                    window.location = window.location.pathname;
                    showToast('Login Successfully', 'success');
                    login_form.reset();
                // }

            }
        }
        xhr.send(data);
    });

    let forget_form = document.getElementById('forget_form');
    forget_form.addEventListener('submit', (e) => {
        e.preventDefault();
        let data = new FormData();
        data.append('email', forget_form.elements['email'].value);
        data.append('verify_email', '');
        var myModal = document.getElementById('ForgetModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);
        xhr.onload = function () {
            if (this.responseText == 'invalid_email') {
                showToast('Email is Invalid', 'danger');
            } else {
                showToast('You can choose Password', 'success');
                var passwordModal = new bootstrap.Modal(document.getElementById('PasswordModal'));
                document.getElementById('password_email').value = forget_form.elements['email'].value;
                passwordModal.show();
                forget_form.reset();
            }
        }
        xhr.send(data);
    });
    let password_form = document.getElementById('password_form');
    password_form.addEventListener('submit', (e) => {
        e.preventDefault();
        let data = new FormData();
        data.append('password', password_form.elements['password'].value);
        data.append('email', password_form.elements['email'].value);
        data.append('save_password', '');
        var myModal = document.getElementById('PasswordModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);
        xhr.onload = function () {
            if (this.responseText == 'failed_password') {
                showToast('Failed To Save Password', 'danger');
            } else {
                showToast('Password Saved Successfuly', 'success');
                password_form.reset();
            }
        }
        xhr.send(data);
    });
    function checkLoginToBook(status, room_id) {
        if (status == 1) {
            window.location.href = 'confirm_booking.php?id=' + room_id;
        } else {
            showToast('Please Login To Book Room', 'danger');

        }

    }


</script>