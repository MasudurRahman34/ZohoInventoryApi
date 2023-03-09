
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
			box-sizing: border-box;
		}
		.container {
			width: 595px; /* A4 width */
			margin: 0 auto;
		}
		.header {
			padding: 20px;
			text-align: center;
	
		}
		.header h1 {
			font-size: 24px;
			margin: 0;
			float: right                  ;
		
		}
		.logo {
			float: left;
			margin-right: 20px;
			max-width: 100px;
			max-height: 100px;
		}
		.invoice-details {
			padding: 10px;
			margin-top: 20px;
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
		.information_section {
			display: inline;
		}
		.reciever-details {
			width: 40%;
			
		}
		.sender-details {
			width: 40%;
			float: right;
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
				<img src="{{asset($invoice['sender_address']['company_logo'])}}" alt="Your Company Logo">
			</div>
			<div>
		
				<h1><strong>Invoice Number:</strong>{{$invoice['invoice_number']}}</h1>
			</div>
			
		</div>
		<div class="invoice-details">
			
			<p><strong>Issue Date:</strong>{{$invoice['invoice_date']}}</p>
			<p><strong>Due Date:</strong> {{$invoice['due_date']}}</p>
			<p><strong>PO Number:</strong>@if (!is_null($invoice['order_number']))
				{{json_encode($invoice['order_number'])}}
			@endif </p>
		</div>
		<div class="information-section">
			<div class="sender-details">
				<h1><strong>From</strong></h1>
				@if (!is_null($invoice['sender_address']['company_name']))
					<h4>{{$invoice['sender_address']['company_name']}}</h4>
				@endif
				@if (!is_null($invoice['sender_address']['first_name']))
					<h4>{{$invoice['sender_address']['first_name'] }} {{$invoice['sender_address']['last_name']}}</h4>
				@endif
				
				@if (!is_null($invoice['sender_address']['plain_address']))
					<h4>{{$invoice['sender_address']['plain_address']}}</h4>
				@endif

				@if (!is_null($invoice['sender_address']['email']))
					<h4>{{$invoice['sender_address']['email']}}</h4>
				@endif
				@if (!is_null($invoice['sender_address']['mobile']))
					<h4>{{$invoice['sender_address']['mobile_country_code']}}{{$invoice['sender_address']['mobile']}}</h4>
				@endif
				
				
				
				
			</div>
			<div class="reciever-details">
				<h1><strong>To</strong></h1>
				@if (!is_null($invoice['receiver_address']['company_name']))
					<h4>{{$invoice['receiver_address']['company_name']}}</h4>
				@endif
				@if (!is_null($invoice['receiver_address']['first_name']))
					<h4>{{$invoice['receiver_address']['first_name'] }} {{$invoice['receiver_address']['last_name']}}</h4>
				@endif
				
				@if (!is_null($invoice['receiver_address']['plain_address']))
					<h4>{{$invoice['receiver_address']['plain_address']}}</h4>
				@endif

				@if (!is_null($invoice['receiver_address']['email']))
					<h4>{{$invoice['receiver_address']['email']}}</h4>
				@endif
				@if (!is_null($invoice['receiver_address']['mobile']))
					<h4>{{$invoice['receiver_address']['mobile_country_code']}}{{$invoice['receiver_address']['mobile']}}</h4>
				@endif
				
			</div>
		</div>
		<table class="invoice-items">
			<thead>
				<tr>
					<th>Service Date</th>
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
					<td>{{$item['service_date']}}</td>
					<td>
						
						<p>{{$item['product_name']}}</p>
						<p>{{$item['product_description']}}</p>
					</td>
					<td>{{$item['product_qty']}}</td>
					<td>{{$invoice['invoice_currency']}}{{$item['unit_price']}}</td>
					
					<td>{{$item['tax_rate']}}</td>
					
					<td>{{$invoice['invoice_currency']}}{{$item['whole_price']}}</td>
				</tr>
                @endforeach
				
				
				

			</tbody>
		</table>
		<div class="invoice-total">
			<div>
				<h1>Invoice Summary</h1>
			</div>
			<section class="invoice-total-counter">
				<p><strong>Subtotal: </strong>{{$invoice['invoice_currency']}} {{$invoice['total_whole_amount'],2}}</p>
				@if (($invoice['total_tax']>0))
					<p><strong>Total tax: </strong>{{$invoice['invoice_currency']}} {{ $invoice['total_tax']}}</p>
				@endif
				@if (($invoice['total_product_discount']>0))
					<p><strong>Total Product Discount:  </strong>{{$invoice['invoice_currency']}} -{{$invoice['total_product_discount']}}</p>
				@endif
				<hr>
				<p><strong>Total : </strong>{{$invoice['invoice_currency']}} {{ $invoice['total_amount']}}</p>
				

				@if (($invoice['shipping_charge']>0))
					<p><strong>Shipping Charge: </strong>{{$invoice['invoice_currency']}} {{ $invoice['shipping_charge']}}</p>
				@endif

				@if (($invoice['order_adjustment']>0))
					<p><strong>Order Adjustment: </strong>{{$invoice['invoice_currency']}} {{ $invoice['order_adjustment']}}</p>
				@endif
				@if (($invoice['discount_amount']>0))
					<p><strong>Order Discount: </strong>{{$invoice['invoice_currency']}} -{{ $invoice['discount_amount']}}</p>
				@endif
				<hr>
				
			{{-- <p><strong>Tax:</strong> {{$invoice['total_tax']}}</p> --}}
			<p><strong>Grand Total: </strong>{{$invoice['invoice_currency']}} {{$invoice['grand_total_amount']}}</p>
			
			@if (($invoice['paid_amount']>0))
					<p><strong>Paid: </strong>{{$invoice['invoice_currency']}} {{ -$invoice['paid_amount']}}</p>
					<hr>
					<p><strong>Balance: </strong>{{$invoice['invoice_currency']}} {{$invoice['balance']}}</p>
			@endif
			</section>
		</div>
	</div>
</body
