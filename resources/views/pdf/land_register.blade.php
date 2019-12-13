<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Land Register</title>

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
        <p class="lead">Land Register</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th scope="col">Administrative district</th>
                    <td scope="col">Tema Metropolitan Area</td>
                    <th scope="col">Vol</th>
                    <td scope="col">1</td>
                    <th scope="col">Fol</th>
                    <td scope="col">1</td>
                </tr>
                <tr>
                    <th scope="col">Nature of Interest</th>
                    <td colspan="5">Sublease</td>
                </tr>
                <tr>
                    <th scope="col">Date of Registration</th>
                    <td colspan="5">{{Carbon\Carbon::today()->toDateString()}}</td>
                </tr>
                <tr>
                    <th scope="col" colspan="6">Description of Land</th>
                </tr>
                <tr>
                    <td colspan="6">
                        <p style="text-align: justify;">All that piece or parcel of land in extent 0.10 hectares (6.25 acres) more or less being Parcel No.
                        6887 Block 48 Section 086 situated at Adenta in the Greater Accra Region of the Republic of Ghana as
                        delineated on the Registry Map No. 019/086/1995 in the Land Registration Division. Cantonments,
                            Accra and being the piece or parcel of land shown and edged with pink colour on Plan No. 102/2019
                        annexed to the Land Certificate.</p>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th colspan="2">Reservation. etc.</th>
                </tr>
                <tr>
                    <td width="20%">05-11-2012</td>
                    <td>
                        <p>
                            Subject to the reservation; exceptions; restrictions; restrictive covenants and conditions
                            contained or referred to a lease (a true copy of which is annexed to the Land Certificate)
                            made between (State Housing Company Limited) of the one part and (Maxwell Adofo) of the other part.
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th colspan="5">Land Certificate/Provisional Certificate</th>
                </tr>
                <tr>
                    <th>Date of issue</th>
                    <th>To whom issued</th>
                    <th>Serial No.</th>
                    <th>Lodgement No.</th>
                    <th>Official Notes</th>
                </tr>
                <tr>
                    <td>{{\Carbon\Carbon::today()->toDateString()}}</td>
                    <td>Maxwell Adofo</td>
                    <td>GA6900315</td>
                    <td>LCGARGACN4020</td>
                    <td>Land Certificate</td>
                </tr>

            </table>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th colspan="10">Proprietorship</th>
                </tr>
                <tr>
                    <th rowspan="2">Entry No.</th>
                    <th rowspan="2">Reg No.</th>
                    <th rowspan="2">Proprietors (names addresses and descriptions)</th>
                    <th colspan="5">Instruments Relevant to the Title</th>
                    <th rowspan="2">Remarks</th>
                    <th rowspan="2">Signature of Registrar</th>
                </tr>
                <tr>
                    <th>Date of Instrument</th>
                    <th>Nature of Instrument</th>
                    <th>Date of Registration</th>
                    <th>Parties</th>
                    <th>Price Paid</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>086/025/3</td>
                    <td>STATE HOUSING COMPANY LIMITED (N/A)</td>
                    <td>07/08/1996</td>
                    <td>LEASE</td>
                    <td>02/01/2019</td>
                    <td>GOVERNMENT OF GHANA (1) STATE HOUSING COMPANY LIMITED (2)</td>
                    <td></td>
                    <td></td>
                    <td>Cynthia Musah</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2017-2019 ALIS</p>
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
