<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EventIntel - Payment Confirmation</title>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: #f9f9f9;
    margin: 0;
  }

  .payment-popup {
    width: 450px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    padding: 30px;
    text-align: center;
    margin: 80px auto;
  }

  h1 { color: #f3c547; font-size: 28px; margin-bottom: 10px; }
  h2 { font-size: 22px; margin-bottom: 8px; }
  p { font-size: 15px; color: #555; margin-bottom: 20px; }

  .qr-box {
    width: 220px; height: 220px;
    margin: 0 auto 20px;
    border: 2px solid #f3c547;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    background: #fff;
  }
  .qr-box img { width: 200px; height: 200px; border-radius: 10px; }

  .btn-group { display: flex; justify-content: center; gap: 15px; margin-top: 10px; }
  .btn {
    padding: 10px 20px;
    border-radius: 10px;
    border: 2px solid #f3c547;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
  }
  .btn:hover { transform: scale(1.05); }
  .btn-sent { background: #fff; color: #f3c547; }
  .btn-received { background: #f3c547; color: #fff; }

  /* Confirmation Modal */
  .modal {
    display: none;
    position: fixed; top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    justify-content: center; align-items: center;
  }
  .modal-content {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    width: 350px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
  }
  .modal-content h3 { margin-bottom: 15px; color: #222; }
  .modal-btns { display: flex; justify-content: center; gap: 15px; margin-top: 20px; }
  .modal-btn {
    padding: 8px 18px;
    border-radius: 8px;
    border: 2px solid #f3c547;
    cursor: pointer;
    font-weight: 600;
  }
  .modal-cancel { background: #fff; color: #f3c547; }
  .modal-confirm { background: #f3c547; color: #fff; }

  /* Success Popup */
  .success-popup {
    display: none;
    margin-top: 25px;
    padding: 20px;
    border-radius: 12px;
    background: #f3c547;
    color: #fff;
    font-weight: 600;
  }
</style>
</head>
<body>

<div class="payment-popup">
  <h1>EventIntel</h1>
  <h2>Pay with GCash</h2>
  <p>Scan the QR code below to complete your payment.</p>

  <div class="qr-box">
    <img src="GCASHQR.jpg" alt="GCash QR Code">
  </div>

  <div class="btn-group">
    <button class="btn btn-sent" id="payerBtn">Payment Sent</button>
    <button class="btn btn-received" id="receiverBtn">Payment Received</button>
  </div>

  <div class="success-popup" id="successPopup">
    ✅ Payment Confirmed! Both parties have verified the transaction.
  </div>
</div>

<!-- Confirmation Modal -->
<div class="modal" id="confirmationModal">
  <div class="modal-content">
    <h3>Confirm Payment</h3>
    <p>Are you sure you want to confirm that payment has been received?</p>
    <div class="modal-btns">
      <button class="modal-btn modal-cancel" id="cancelBtn">Cancel</button>
      <button class="modal-btn modal-confirm" id="confirmBtn">Confirm</button>
    </div>
  </div>
</div>

<script>
  let payerConfirmed = false;
  let receiverConfirmed = false;

  const payerBtn = document.getElementById('payerBtn');
  const receiverBtn = document.getElementById('receiverBtn');
  const modal = document.getElementById('confirmationModal');
  const cancelBtn = document.getElementById('cancelBtn');
  const confirmBtn = document.getElementById('confirmBtn');
  const successPopup = document.getElementById('successPopup');

  payerBtn.addEventListener('click', () => {
    payerConfirmed = true;
    checkConfirmation();
  });

  receiverBtn.addEventListener('click', () => {
    modal.style.display = 'flex';
  });

  cancelBtn.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  confirmBtn.addEventListener('click', () => {
    receiverConfirmed = true;
    modal.style.display = 'none';
    checkConfirmation();
  });

  function checkConfirmation() {
    if (payerConfirmed && receiverConfirmed) {
      successPopup.style.display = 'block';
    }
  }
</script>

</body>
</html>
