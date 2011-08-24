<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>style/fullcalendar.css' />
<script type='text/javascript' src='<?php echo base_url(); ?>scripts/jquery-ui-1.8.6.custom.min.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>scripts/fullcalendar.min.js'></script>
<script type='text/javascript'>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaDay'
			},
			editable: true,
			events: <?php echo $Reservas; ?>,
			eventDrop: function(event, delta) {
				alert(event.title + ' was moved ' + delta + ' days\n' +
					'(should probably update your database)');
			},
			loading: function(bool) {
				if (bool) $('#loading').show();
				else $('#loading').hide();
			}
		});
	});
</script>
<style type='text/css'>
	body {
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		}
	#calendar {
		width: 900px;
		margin: 0 auto;
		}
</style>
<br /><br /><br /><br /><br />
<div id='calendar'></div>