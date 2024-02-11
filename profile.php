<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php require('inc/links.php'); ?>
    <title>
        <?= $data_settings['site_title']; ?> - Facilities
    </title>
    <style>
        .pop:hover {
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }

        .line {
            width: 150px !important;
            margin: 0 auto !important;
            height: 1.7px;
        }
    </style>
</head>

<body class="bg-light">
    <?php require('inc/header.php');
    if (!isset($_SESSION['login'])) {
        redirect('index.php');
    }

    $u_exist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['user_id']], "i");
    if (mysqli_num_rows($u_exist) == 0) {
        redirect('index.php');
    }
    $u_fecth = mysqli_fetch_assoc($u_exist);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5 px-4">
                <h2 class="fw-bold">
                    Profile
                </h2>
                <div style="font-size:14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary">></span>
                    <a href="profile.php" class="text-secondary text-decoration-none">Profile</a>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 my-5">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form action="" enctype="multipart/form-data" id="info_form">
                        <h5>Basic Informations</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="<?= $u_fecth['name']; ?>"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="number" name="phone" value="<?= $u_fecth['phone']; ?>"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">date of birth</label>
                                <input type="date" name="dob" value="<?= $u_fecth['dob']; ?>"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="<?= $u_fecth['email']; ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">adresse</label>
                                <textarea name="adresse" id="adresse" class="form-control shadow-none" rows="1"
                                    required><?= $u_fecth['adresse']; ?></textarea>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-dark shadow-none">Save Changes</button>
                    </form>

                </div>

            </div>

        </div>

    </div>

    <?php require('inc/footer.php'); ?>
    <script>
        let info_form = document.getElementById('info_form');
        info_form.addEventListener('submit', (e) => {
            e.preventDefault();
            let data = new FormData();
            data.append('name', info_form.elements['name'].value);
            data.append('email', info_form.elements['email'].value);
            data.append('phone', info_form.elements['phone'].value);
            data.append('adresse', info_form.elements['adresse'].value);
            data.append('dob', info_form.elements['dob'].value);
            data.append('update_profile', '');
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/profile.php", true);
            xhr.onload = function () {
                if (this.responseText == 'phone_already') {
                    showToast('Phone is already exist', 'danger');
                } else if(this.responseText == 0) {
                    showToast('No Changes Made!', 'danger');
                }else{
                    showToast('Profile Changed Successfuly', 'success');

                }
            }
            xhr.send(data);
        });
    </script>



</body>

</html>