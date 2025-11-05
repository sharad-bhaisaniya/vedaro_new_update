<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        @font-face {
					font-family: "MyCustomFont";
					src: url("{{ asset('fonts/myfont.ttf') }}") format("truetype");
					font-weight: normal;
					font-style: normal;
					}
        body {
            font-family: "MyCustomFont", sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .status-info {
            margin-top: 20px;
        }
        .status-info p {
            font-size: 18px;
            color: #333;
        }
        .status-info .tracking-link {
            color: #007bff;
            text-decoration: none;
        }
        .input-group {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .input-group input {
            padding: 10px;
            font-size: 16px;
            width: 60%;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .input-group button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .input-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Track Your Order</h1>
        <div class="input-group">
            <input type="text" id="awb_no" placeholder="Enter AWB number" />
            <button onclick="trackOrder()">Track</button>
        </div>

        <div class="status-info" id="status-info"></div>
    </div>

    <script>
        function trackOrder() {
            const awbNo = document.getElementById('awb_no').value;
            if (!awbNo) {
                alert('Please enter an AWB number');
                return;
            }

            fetch(`/track-order/${awbNo}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const statusInfo = document.getElementById('status-info');
                    if (data.success) {
                        const shipmentTrack = data.shipment_track[0];

                        const shippingDetails = `
                            <strong>AWB Number:</strong> ${shipmentTrack.awb_code || 'N/A'}<br>
                            <strong>Order ID:</strong> ${shipmentTrack.order_id || 'N/A'}<br>
                            <strong>Courier Name:</strong> ${shipmentTrack.courier_name || 'N/A'}<br>
                            <strong>Origin:</strong> ${shipmentTrack.origin || 'N/A'}<br>
                            <strong>Destination:</strong> ${shipmentTrack.destination || 'N/A'}<br>
                            <strong>Consignee Name:</strong> ${shipmentTrack.consignee_name || 'N/A'}<br>
                            <strong>Weight:</strong> ${shipmentTrack.weight || 'N/A'} kg<br>
                            <strong>Packages:</strong> ${shipmentTrack.packages || 'N/A'}<br>
                            <strong>Delivered To:</strong> ${shipmentTrack.delivered_to || 'N/A'}<br>
                            <strong>Pickup Date:</strong> ${shipmentTrack.pickup_date || 'N/A'}<br>
                            <strong>Delivered Date:</strong> ${shipmentTrack.delivered_date || 'N/A'}<br>
                            <strong>Estimated Delivery Date:</strong> ${shipmentTrack.edd || 'N/A'}<br>
                            <strong>POD Status:</strong> ${shipmentTrack.pod_status || 'N/A'}<br>
                            <strong>ETD:</strong> ${shipmentTrack.etd || 'N/A'}<br>
                            <strong>RTO Delivered Date:</strong> ${shipmentTrack.rto_delivered_date || 'N/A'}<br>
                            <strong>Return AWB Code:</strong> ${shipmentTrack.return_awb_code || 'N/A'}<br>
                            <strong>Tracking Link:</strong> <a href="${data.track_url}" target="_blank">Track Order</a><br>
                            <strong>Current Status:</strong> ${shipmentTrack.current_status || 'N/A'}<br>
                        `;

                        statusInfo.innerHTML = `
                            <p><strong>Track Status:</strong> ${data.track_status || 'Status not available'}</p>
                            <p><strong>Shipment Status:</strong> ${data.shipment_status || 'Status not available'}</p>
                            ${shippingDetails}
                        `;
                    } else {
                        statusInfo.innerHTML = `<p>Error: ${data.message}</p>`;
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Error fetching order status. Please try again.');
                });
        }
    </script>
</body>
</html>
