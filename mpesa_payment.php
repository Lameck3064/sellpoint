<?php
// Your M-Pesa credentials
$shortcode = '174379';  // Replace with your Paybill number
$shortcode_passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';    // Replace with your Passkey
$shortcode_shortcode_key = 'Your API Key'; // Replace with your API key
$shortcode_shortcode_secret = 'Your API Secret'; // Replace with your API secret

// API endpoint for M-Pesa
$base_url = 'https://sandbox.safaricom.co.ke/mpesa/';

// Function to request payment from M-Pesa
function lipa_na_mpesa($phone_number, $amount) {
    global $shortcode, $shortcode_passkey, $shortcode_shortcode_key, $shortcode_shortcode_secret;
    
    $headers = array(
        'Authorization: Bearer ' . $shortcode_shortcode_key
    );

    $data = array(
        'Shortcode' => $shortcode,
        'ShortcodePasskey' => $shortcode_passkey,
        'PhoneNumber' => $phone_number,
        'Amount' => $amount
    );

    $url = $base_url . 'lipa_na_mpesa_online.php'; // Adjust URL for actual API

    $post_data = json_encode($data);

    // Initialize cURL and send the request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone_number = $_POST['phone'];
    $amount = $_POST['amount'];
    
    // Call M-Pesa API to initiate payment
    $paymentResponse = lipa_na_mpesa($phone_number, $amount);
    echo "Payment initiation request sent. Please complete the payment on your phone.";
}

// Callback handler for payment success
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $paymentStatus = $_GET['status'];
    $transactionId = $_GET['transaction_id'];
    $amountPaid = $_GET['amount'];
    $phoneNumber = $_GET['phone_number'];

    // Check payment status and update user subscription
    if ($paymentStatus == 'SUCCESS') {
        // Update the user's subscription in your database
        $conn = new mysqli("localhost", "username", "password", "database_name");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Update the user's subscription based on the amount and phone number
        $stmt = $conn->prepare("UPDATE users SET subscription_status = 'active' WHERE phone_number = ?");
        $stmt->bind_param("s", $phoneNumber);
        $stmt->execute();
        $stmt->close();
        
        echo "Subscription updated successfully!";
    } else {
        echo "Payment failed.";
    }
}
?>
