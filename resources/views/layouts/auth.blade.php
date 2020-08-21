<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
    <style>
body{
    background:white;
}
</style>
<style>
        .form-container input{
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

    </style>
</head>

<body class="page-header-fixed">

    <div style="margin-top: 5%;"></div>

    <div class="container-fluid">
        @yield('content')
    </div>

    <div class="scroll-to-top"
         style="display: none;">
        <i class="fa fa-arrow-up"></i>
    </div>

    @include('partials.javascripts')

</body>
</html>