<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Land Certificate</title>

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
        <p class="lead">Land Certificate</p>
    </div>

    <div class="row jumbotron">
       <div class="col-md-12">
           <p style="text-align: justify">
                THIS IS To CERTIFY THAT <b><u>DAVID MARFO</u></b> of Accra in the Greater Accra Region of the republic of Ghana
               is a registered tenant or lessee (with an option to renew for a further term of 1 year) subject to reservations,
               restrictions, encumbrances, liens and interests as are notified by memorial underwritten or endorsed hereon,
               of and in ALL THAT piece or parcel of land in extent 0.10 hectare (0.25 of an acre) more or less being
               GLPIN GA49406310001 Block 025 Section 086, situate at Adentan in the Greater Accra Region of the Republic of Ghana
               which said piece or parcel of land is more particularly delineated on Registry Map No. 019/086/2019 in the
               Lands Commission, Cantonments, Accra and being the piece or parcel of land shown and edged with colour on
               Plan No. GA/019/8/19 annexed to this Certificate except and reserved all minerals, oils, precious stones and
               timber whatsoever upon or under the said piece or parcel of land.

           </p>

           <p class="my-5">
               IN WHITNESS WHEREOF I have  hereinto signed my name and affixed the seal of the Lands Commission this
               {{\Carbon\Carbon::today()->format('l, j  F, Y')}}.
           </p>
           <p style="text-align: center">
               ..................................<br>
               CHIEF REGISTRAR OF LANDS
           </p>
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
