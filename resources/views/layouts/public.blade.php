<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.public-head')
    <style>
        .form-container input,.form-container .data-input{
            border: 1px solid #2680EB;
            border-radius: 5px 5px 5px 5px!important;
        }
        .form-container label{
            font-weight: 600!important;
        }
        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            
          }
        .form-container .show-password{
/*            float: right;
            margin-top: -42px;
            margin-right: 13px;
            cursor: pointer;*/
            float: right;
                margin-top: 30px;
                position: absolute;
                cursor: pointer;
                right: 30px;
        }
        .form-container .form-heading{
            font-size: 48px;
            font-weight: bolder;
        }
        .form-container .location-container{
            background:#F5F5F5;
            border-radius:5px 5px 5px 5px!important;
            padding:11px;
            text-align: center;
        }
        .invalid-feedback{
            color:red;
            padding-left:10px;
        }
        #radioBtn .notActive{
            color: #3276b1;
            background-color: #fff;
        }
        .disable-label label{
          display:none;
        }

         .btn-primary.occupied{
          color:white!important;
          background-color:#2d6ca2!important;
        }
    </style>
</head>

<body class="page-header-fixed" >
    <div style="margin-top: 5%;"></div>

    <div class="container-fluid">
        @yield('content')
    </div>

    <div class="scroll-to-top"
         style="display: none;">
        <i class="fa fa-arrow-up"></i>
    </div>

    @include('partials.public-javascripts')

<script>
 $(document).ready(function(){
  $('#radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);
    
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
})
            initialize();
            $('#password-check').click(function(){
                $(this).is(':checked') ? $('#password').attr('type', 'text') : $('#password').attr('type', 'password');
                $(this).is(':checked') ? $(".password-span").html('Hide Password') : $(".password-span").html('Show Password') ;
            });
        });
</script>

<!-- <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyBXGgj1Yig6kDntDzZ99K2bGtlgZ8bmH8c"></script>  -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyBXGgj1Yig6kDntDzZ99K2bGtlgZ8bmH8c"></script>
 
<script type="text/javascript"> 
    
  var geocoder;
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
            } 
//Get the latitude and the longitude;
function successFunction(position) {
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    codeLatLng(lat, lng)
}

function errorFunction(){
    alert("Geocoder failed");
}

google.maps.event.addDomListener(window, 'load', initialize);

  function initialize() {
    
  var input = document.getElementById('autocompleteAddress1');
  var autocomplete=new google.maps.places.Autocomplete(input);

  google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
               
                document.getElementById('city_town').value = place.address_components[2].long_name;
                document.getElementById('states').value = place.address_components[4].short_name;
                document.getElementById('zipcode').value = place.address_components[6].short_name;
            });
    geocoder = new google.maps.Geocoder();
  }

  function codeLatLng(lat, lng) {

    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
//      console.log(results)
        if (results[1]) {
         //formatted address
//         alert(results[0].formatted_address)
        //find country name
             for (var i=0; i<results[0].address_components.length; i++) {
            for (var b=0;b<results[0].address_components[i].types.length;b++) {
            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                if (results[0].address_components[i].types[b] == "administrative_area_level_2") {
                    //this is the object you are looking for
                    city= results[0].address_components[i];
                    break;
                }
            }
        }
        //city data
//        alert(city.short_name + " " + city.long_name)
        $("body .location-city").html(city.long_name);
        } else {
          alert("No results found");
        }
      } else {
        alert("Geocoder failed due to: " + status);
      }
    });
  }
</script> 
</body>
</html>