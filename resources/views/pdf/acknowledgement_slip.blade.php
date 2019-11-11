<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Acknowledgement Slip</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/checkout/">

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<body class="bg-light">
<div  id="bill" class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="{{asset('images/land.jpeg')}}" alt="">
        <hr/>
        <h2>Lands Commission</h2>
        <p class="lead">Acknowledgement Slip</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form class="needs-validation" novalidate>
                <div class="row">
                    <div class="input-group col-md-8 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Service Type</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="{{$application->business_process_name}}" aria-describedby="inputGroup-sizing-default">

                    </div>
                </div>
                <div class="row">
                    <div class="input-group col-md-8 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Case Number</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="{{$application->case_number}}" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="row">
                    <div class="input-group col-md-8 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Client Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="{{$main_application->ar_name}}" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="row">
                    <div class="input-group col-md-8 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Job Number</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="{{$application->job_number}}" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="row">
                    <div class="input-group col-md-8 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nature of Instrument</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="{{$main_application->nature_of_instrument}}" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="row">
                    <div class="input-group col-md-8 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Location</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="{{$main_application->locality}}" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="row">
                    <div class="input-group col-md-8 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Date and Time</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="{{\Carbon\Carbon::parse($main_application->created_at)->format('l jS \\of F Y h:i:s A')}}" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="row">
                    <div class="input-group col-md-8 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Date of Collection</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="{{\Carbon\Carbon::parse($main_application->created_at)->addDays(4)->toDateString()}}" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
                <div class="row">
                    <div class="input-group col-md-8 mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Note</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Sizing example input" value="Date and Time for Collection is Subject to Change" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>

            </form>
        </div>

        <div class="col-md-12 ">
            <div class="input-group col-md-6 mb-3 float-right mr-0 pr-0" >
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Client Service Officer</span>
                </div>
                <input type="text" class="form-control" aria-label="Sizing example input" value="David Marfo" aria-describedby="inputGroup-sizing-default">
            </div>
        </div>

    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2019 ALIS</p>
        {{--<ul class="list-inline">--}}
        {{--<li class="list-inline-item"><a href="#">Privacy</a></li>--}}
        {{--<li class="list-inline-item"><a href="#">Terms</a></li>--}}
        {{--<li class="list-inline-item"><a href="#">Support</a></li>--}}
        {{--</ul>--}}
    </footer>


</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script>
    (function (){
        var restorepage = $('body').html();
        var printcontent = $('#bill').clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    })();
</script>
</body>
</html>
