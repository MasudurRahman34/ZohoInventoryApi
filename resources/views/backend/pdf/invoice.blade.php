
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Invoice</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			font-size: 12px;
			margin: 0;
			padding: 0;
		}
		.container {
			width: 595px; /* A4 width */
			margin: 0 auto;
		}
		.header {
			padding: 20px;
		
			text-align: center;
			overflow: hidden;
		}
		.header h1 {
			font-size: 24px;
			margin: 0;
			float: right                  ;
		
		}
		.logo {
			float: left;
			margin-right: 20px;
			max-width: 200px;
			max-height: 100px;
		}
		.invoice-details {
			padding: 10px;
			background-color: #f9f9f9;
			text-align: right;
			margin-bottom: 20px;
		}
		.invoice-details p {
			margin: 0;
			line-height: 1.5;
		}
		.invoice-items {
			border-collapse: collapse;
			width: 100%;
			margin-bottom: 20px;
		
		}
		.invoice-items th,
		.invoice-items td {
			border-bottom: 1px solid #c4c4c4;
			padding: 10px;
			text-align: left;
		}
		.invoice-items th {
			background-color: #c4c4c4;
			
		}
		.invoice-total {
	
			min-width: 250px;
			display: inline-block;
			float: right;
			border: 1px solid #c4c4c4;
			margin-bottom: 100px;
		}
		.invoice-total h1 {
			text-align: right;
			font-size: medium;
		}.invoice-total div {
			background-color: #c4c4c4;
			padding: 5px;
			
		}
		.reciever-details {
			float: right;
		}
		.sender-details {
			float: left;
		}
		.invoice-total-counter {
			padding: 5px;
			text-align: right;
		}

	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<div class="logo">
				<img src="{{$invoice['sender_address']['company_logo']}}" alt="Your Company Logo">
			</div>
			<div>
		
				<h1><strong>Invoice Number:</strong>{{$invoice['invoice_number']}}</h1>
			</div>
			
		</div>
		<div class="invoice-details">
			
			<p><strong>Issue Date:</strong>{{$invoice['invoice_date']}}</p>
			<p><strong>Due Date:</strong> {{$invoice['due_date']}}</p>
		</div>
		<div class="information-section">
			<div class="">
				<h1><strong>From</strong></h1>
				<h4>{{$invoice['sender_address']['company_name']}}</h4>
				<h4>{{$invoice['sender_address']['first_name'] }} {{$invoice['sender_address']['first_name']}}</h4>
				<h4>{{$invoice['sender_address']['plain_address']}}</h4>
				<h4>{{$invoice['sender_address']['email']}}</h4>
				<h4>{{$invoice['sender_address']['mobile_country_code']}}{{$invoice['sender_address']['mobile']}}</h4>
				
			</div>
			<div class="">
				<h1><strong>To</strong></h1>
				<h4>{{$invoice['receiver_address']['company_name']}}</h4>
				<h4>{{$invoice['receiver_address']['first_name']}}  {{$invoice['receiver_address']['first_name']}}</h4>
				<h4>{{$invoice['receiver_address']['plain_address']}}</h4>
				<h4>{{$invoice['receiver_address']['email']}}</h4>
				<h4>{{$invoice['receiver_address']['mobile_country_code']}}{{$invoice['sender_address']['mobile']}}</h4>
				
			</div>
		</div>
		<table class="invoice-items">
			<thead>
				<tr>
					<th>Name</th>
					<th>Quantity</th>
					<th>Unit Price</th>
					<th>Tax</th>
					<th>Subtotal</th>
				</tr>
			</thead>
			<tbody style="border-bottom: 1px soli
			#ebebeb">
            @foreach ($invoice['invoice_items'] as $item)
                
           
				<tr>
					<td>
						<p>{{$item['product_name']}}</p>
						<p>{{$item['product_description']}}</p>
					</td>
					<td>{{$item['unit_price']}}</td>
					<td>{{$item['product_qty']}}</td>
					<td>{{$item['tax_rate']}}</td>
					
					<td>{{$item['whole_price']}}</td>
				</tr>
                @endforeach
				
				
				

			</tbody>
		</table>
		<div class="invoice-total">
			<div>
				<h1>Invoice Summary</h1>
			</div>
			<section class="invoice-total-counter">
				<p><strong>Subtotal:</strong> {{$invoice['total_amount']}}</p>
			<p><strong>Tax:</strong> {{$invoice['total_tax']}}</p>
			<p><strong>Total:</strong> {{$invoice['grand_total_amount']}}</p>
			<p><strong>Paid:</strong> {{$invoice['paid_amount']}}</p>
			<p><strong>Balance:</strong> {{$invoice['balance']}}</p>
			</section>
		</div>
	</div>
</body
