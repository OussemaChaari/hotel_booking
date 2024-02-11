<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <?php require('inc/links.php'); ?>
    <title>
        <?= $data_settings['site_title']; ?> - Confirmation
    </title>
    <style>
        .line {
            width: 150px !important;
            margin: 0 auto !important;
            height: 1.7px;
        }
    </style>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">
                    Complete the payment procedure
                </h2>
                <div style="font-size:14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary">></span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">Rooms</a>
                    <span class="text-secondary">></span>
                    <a href="" class="text-secondary text-decoration-none">Payement</a>
                </div>
            </div>
            <div class="col-12">
                <form action="" id="payement_form">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <i class="bi bi-bank me-2"></i> Payment procedure
                        </h5>
                    </div>
                    <div class="modal-body">
                        <span class="badge bg-light text-dark mb-3 text-wrap">
                            Note: Make sure that Account verification Number is true.
                        </span>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment method :</label>
                            <select id="payment_method" name="payment_method" class="form-control shadow-none" required>
                                <option value="paypal">Paypal</option>
                                <option value="payoneer">Payoneer</option>
                                <option value="credit_card">Carte de Crédit</option>
                            </select>
                        </div>
                        <input type="hidden" name="booking_id" value="<?= $_GET['booking_id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Number of bank accounts :</label>
                            <input type="text" id="account_number" name="account_number"
                                class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Money to Payer :</label>
                            <input type="number" name="money_payer" value="<?= $_SESSION['room']['payement']; ?>"
                                class="form-control shadow-none" required disabled>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <button type="submit" name="pay_money" class="btn btn-dark shadow-none">Transfer the amount</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <?php require('inc/footer.php'); ?>
    <script>
        let payement_form = document.getElementById('payement_form');
        payement_form.addEventListener('submit', (e) => {
            e.preventDefault();
            let data = new FormData();
            data.append('account_number', payement_form.elements['account_number'].value);
            data.append('payment_method', payement_form.elements['payment_method'].value);
            data.append('money_payer', payement_form.elements['money_payer'].value);
            data.append('booking_id', payement_form.elements['booking_id'].value);

            data.append('pay_money', '');
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/confirm_booking.php", true);
            xhr.onload = function () {
                if (this.responseText == 'success') {
                    showToast('Successfuly payment', 'success');      
                    payement_form.reset();   
                } else {
                    showToast('Payement Failed', 'danger');
                }
            }
            xhr.send(data);
        });
    </script>

</body>

</html>