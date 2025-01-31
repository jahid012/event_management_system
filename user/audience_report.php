<?php include 'db_connect.php' ?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				Event Audience Report
			</div>
			<div class="card-body">
				<div class="col-md-12">
					<form action="" id="filter">
						<div class="row form-group">
							<div class="col-md-4">
								<label for="" class="control-label">Event</label>
								<select name="event_id" id="event_id" class="custom-select select2">
									<option></option>
									<?php
									$event = $conn->query("SELECT * FROM events where user_id = ".$_SESSION['login_id']." order by id asc");
									while ($row = $event->fetch_assoc()):
									?>
										<option value="<?php echo $row['id'] ?>" <?php echo isset($event_id) && $event_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
									<?php endwhile; ?>
								</select>
							</div>
							<div class="col-md-2">
								<label for="" class="control-label">&nbsp;</label>
								<button class="btn-primary btn-sm btn-block col-sm-12">Filter</button>
							</div>
							<div class="col-md-2">
								<label for="" class="control-label">&nbsp;</label>
								<button class="btn-primary btn-sm btn-block col-sm-12" id="csv-export" type="button"><i class="fa fa-file"></i> Export in CSV</button>
							</div>
						</div>
					</form>
					<hr>
					<div class="row" id="printable">
						<div id="onPrint">
							<p class="text-center">Audience List and Details</p>
							<hr>
							<p class="">Event: <span id="ename"></span></p>
							<p class="">Venue: <span id="evenue"></span></p>
						</div>
						<table class="table table-bordered">
							<thead>
								<th class="text-center">#</th>
								<th class="text-center">Name</th>
								<th class="text-center">Email</th>
								<th class="text-center">Phone</th>
								<th class="text-center">Address</th>
							</thead>
							<tbody>
								<tr>
									<th colspan="5">
										<center>Select Event First.</center>
									</th>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	#onPrint {
		display: none;
	}
</style>
<noscript>
	<style>
		table {
			width: 100%;
			border-collapse: collapse;
		}

		tr,
		td,
		th {
			border: 1px solid black;
		}

		.text-center {
			text-align: center;
		}

		p {
			font-weight: 600
		}
	</style>

</noscript>
<script>
	$('#filter').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=get_audience_report',
			method: 'POST',
			data: {
				event_id: $('#event_id').val()
			},
			success: function(resp) {
				if (resp) {
					resp = JSON.parse(resp)
					if (!!resp.event) {
						$('#ename').html(resp.event.event)
						$('#evenue').html(resp.event.venue)
					}
					if (!!resp.data && Object.keys(resp.data).length > 0) {
						$('table tbody').html('')
						var i = 1;
						console.log(resp.data);
						Object.keys(resp.data).map(k => {
							var tr = $('<tr class="item"></tr>')
							tr.append('<td class="text-center">' + (i++) + '</td>')
							tr.append('<td class="">' + resp.data[k].name + '</td>')
							tr.append('<td class="">' + resp.data[k].email + '</td>')
							tr.append('<td class="">' + resp.data[k].phone + '</td>')
							tr.append('<td class="">' + resp.data[k].address + '</td>')
							$('table tbody').append(tr)
						})

					} else {
						$('table tbody').html('<tr><th colspan="5"><center>No Data.</center></th></tr>')
					}
				}
			},
			complete: function() {
				end_load()
			}
		})
	})

	$('#csv-export').click(function() {

		start_load()
		$.ajax({
			url: 'ajax.php?action=download_audience_report',
			method: 'POST',
			data: {
				event_id: $('#event_id').val()
			},
			success: function(response) {
				if (response) {

					var blob = new Blob([response], {
						type: "text/csv"
					});
					var link = document.createElement("a");
					var name = formatDate() + "_audience_report.csv";

					link.href = URL.createObjectURL(blob);
					link.download = name;
					link.click();
				}
			},
			complete: function() {
				end_load()
			}
		})
	})

	function formatDate(date = new Date()) {
		let {
			day,
			month,
			year
		} = new Intl.DateTimeFormat('en', {
			day: '2-digit',
			month: 'short',
			year: 'numeric'
		}).formatToParts(date).reduce((acc, part) => {
			if (part.type != 'literal') {
				acc[part.type] = part.value;
			}
			return acc;
		}, Object.create(null));
		return `${day}_${month}_${year}`;
	}
</script>