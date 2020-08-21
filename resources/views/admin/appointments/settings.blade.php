@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.appointments.title')</h3>
    {!! Form::open()->route("appointments.store")->method("post") !!}

    <div class="panel panel-default">
        <div class="panel-heading">
           Appointment Settings
        </div>
        
        <div class="panel-body">
            <div class="row">
			
	<label class="col col-lg-12 panel-heading">Select Interviews Starting and Ending Dates</label>
			<div class="col col-lg-6 col-sm-12">
					{!!Form::text("from_date","From")->type("date")!!}
			</div>
			<div class="col col-lg-6 col-sm-12">
					{!!Form::text("to_date","To")->type("date")!!}
			</div>

	<label class="col col-lg-12 panel-heading">Select Interview Starting and Ending Time</label>
			<div class="col col-lg-6 col-sm-12">
					{!!Form::text("from_time","From")->type("time")!!}
			</div>
			<div class="col col-lg-6 col-sm-12">
					{!!Form::text("to_time","To")->type("time")!!}
			</div>
            </div>
	

			<div class="col col-lg-12 col-sm-12">
			
					{!!Form::text("hours","Select Interview duration per person in minutes")->type("number")!!}
			</div>
            </div>
		</div>


<input type="submit" value="SAVE" class="btn btn-primary">
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    <script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>    <script>
        $('.datetime').datetimepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            timeFormat: "HH:mm:ss"
        });
    </script>
	<script>
	$('.date').datepicker({
		autoclose: true,
		dateFormat: "{{ config('app.date_format_js') }}"
	}).datepicker("setDate", "0");
    </script>
	<script>
		$("#service_id").on("change", function() {
			$("#price").val($('option:selected', this).attr('data-price'));
			var date = $("#date").val();
			var service_id = $("#service_id").val();
			UpdateEmployees(service_id, date);
		});
	
		$("#date").change(function() {
			var service_id = $("#service_id").val();
			var date = $("#date").val();
			UpdateEmployees(service_id, date);
		});
		
		$("#starting_hour, #finish_hour, #starting_minute, #finish_minute").on("change", function () {
			CountPrice();		
		});
		
		$('body').on("change", "input[type=radio][name=employee_id]", function() {
			var employee_id = $(this).val();
			var starting_hour = parseInt($(".starting_hour_"+employee_id).text());
			var starting_minute = $(".starting_minute_"+employee_id).text();
			var finish_hour = starting_hour+1;
			if(finish_hour < 10) {
				finish_hour = "0"+finish_hour;
			}
			if(starting_hour < 10) {
				starting_hour = "0"+starting_hour;
			}
			$('#starting_hour option[value='+starting_hour+']').prop('selected','true');
			$('#starting_minute option[value='+starting_minute+']').prop('selected','true');
			$('#finish_hour option[value='+finish_hour+']').prop('selected','true');
			$('#finish_minute option[value='+starting_minute+']').prop('selected','true');
			$("#start_time, #finish_time").show();
			CountPrice();
		});
		
		function CountPrice() {
			var start_hour = parseInt($("#starting_hour").val());
			var start_minutes = parseInt($("#starting_minute").val());
			var finish_hour = parseInt($("#finish_hour").val());
			var finish_minutes = parseInt($("#finish_minute").val());
			var total_hours = (((finish_hour*60+finish_minutes)-(start_hour*60+start_minutes))/60);
			var price = parseFloat($("#price").val());
			$("#price_total").html(price*total_hours);
			$("#time").html(total_hours);
			if(start_hour != -1 && start_minutes != -1 && finish_hour != -1 && finish_minutes != -1) {
				$("#results").show();
			}
		}
		
		function UpdateEmployees(service_id, date)
		{
			if(service_id != "" && date != "") {
				$.ajax({
					url: '{{ url("admin/get-employees") }}',
					type: 'GET',
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: {service_id:service_id, date:date},
					success:function(option){
						//alert(option);
						$(".employees").remove();
						$("#date").closest(".row").after(option);
						$("#start_time, #finish_time").hide();
						$("#results").hide();
					}
				});
			}
		}
	</script>

@stop