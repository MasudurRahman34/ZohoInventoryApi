<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
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
			max-width: 200px;
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
			width: 50%;
			
		}
		.sender-details {
			width: 50%;
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
				<img src="your-logo.jpg" alt="Your Company Logo">
			</div>
			<div>
		
				<h1><strong>Invoice Number:</strong> 123456</h1>
			</div>
			
		</div>
		<div class="invoice-details">
			
			<p><strong>Issue Date:</strong> February 14, 2023</p>
			<p><strong>Due Date:</strong> March 14, 2023</p>
		</div>
		<div class="information-section">
			<div class="sender-details">
				<h1><strong>From</strong></h1>
				<h4>Company Name</h4>
				<h4>sender name</h4>
				<h4>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Possimus, ex corrupti earum sed error assumenda est ipsum? Odit laudantium ipsum ad fuga quo iusto dolore expedita quisquam. Officiis, quasi possimus? </h4>
				<h4>demo@example.com</h4>
				<h4>015825485495</h4>
				
			</div>
			<div class="reciever-details">
				<h1><strong>To</strong></h1>
				<h4>Company Name</h4>
				<h4>sender name</h4>
				<h4>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ullam cupiditate cumque nam eos facere quae nemo, enim laudantium vitae magni quidem ad dolores quisquam, similique aspernatur modi molestiae, ducimus corporis.</h4>
				<h4>demo@example.com</h4>
				<h4>015825485495</h4>
				
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
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				<tr>
					<td>
						<p>Item 1</p>
						<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Tempore sit tenetur quis dolor ea quibusdam consectetur, ad non similique ullam rerum </p>
					</td>
					<td>2</td>
					<td>$50.00</td>
					<td>15</td>
					<td>$100.00</td>
				</tr>
				
				

			</tbody>
		</table>
		<div class="invoice-total">
			<div>
				<h1>Invoice Summary</h1>
			</div>
			<section class="invoice-total-counter">
				<p><strong>Subtotal:</strong> $175.00</p>
			<p><strong>Tax:</strong> $17.50</p>
			<p><strong>Total:</strong> $192.50</p>
			</section>
		</div>
	</div>
</body