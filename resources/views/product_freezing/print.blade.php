<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Product Freezing Slip</title>

    <style>

        body{
            font-family:Arial, Helvetica, sans-serif;
            margin:25px;
            color:#000;
        }

        .title{

            text-align:center;
            font-size:24px;
            font-weight:bold;
            margin-bottom:5px;

        }

        .subtitle{

            text-align:center;
            font-size:16px;
            margin-bottom:30px;

        }

        table{

            width:100%;
            border-collapse:collapse;

        }

        td{

            padding:10px;
            border:1px solid #000;

        }

        .heading{

            background:#efefef;
            font-weight:bold;
            width:180px;

        }

        .description{

            height:120px;
            vertical-align:top;

        }

        .signature{

            margin-top:80px;

        }

        .sign-box{

            width:220px;
            text-align:center;
            border-top:1px solid #000;
            padding-top:8px;
        }

        @media print{

            .no-print{

                display:none;

            }

        }

    </style>

</head>

<body>

<div class="title">

    YOUR COMPANY NAME

</div>

<div class="subtitle">

    PRODUCT FREEZING SLIP

</div>

<table>

    <tr>

        <td class="heading">
            Date
        </td>

        <td>

            {{ date('d-m-Y',strtotime($productFreezing->date)) }}

        </td>

        <td class="heading">

            Slip No

        </td>

        <td>

            {{ $productFreezing->slip_no }}

        </td>

    </tr>

    <tr>

        <td class="heading">

            Product Name

        </td>

        <td colspan="3">

            {{ $productFreezing->product->prod_name }}

        </td>

    </tr>

    <tr>

        <td class="heading">

            Status

        </td>

        <td colspan="3">

            {{ $productFreezing->product->status }}

        </td>

    </tr>

    <tr>

        <td class="heading">

            Description

        </td>

        <td colspan="3" class="description">

            {!! nl2br(e($productFreezing->description)) !!}

        </td>

    </tr>

</table>

<div class="signature">

    <table style="border:none;">

        <tr style="border:none;">

            <td style="border:none;text-align:left;">

                <div class="sign-box">

                    Prepared By

                </div>

            </td>

            <td style="border:none;text-align:center;">

                <div class="sign-box">

                    Checked By

                </div>

            </td>

            <td style="border:none;text-align:right;">

                <div class="sign-box">

                    Authorized Signature

                </div>

            </td>

        </tr>

    </table>

</div>

<div class="no-print" style="text-align:center;margin-top:40px;">

    <button onclick="window.print()"
            style="padding:10px 25px;">

        Print

    </button>

    <button onclick="window.close()"
            style="padding:10px 25px;">

        Close

    </button>

</div>

<script>

window.onload=function(){

    window.print();

};

</script>

</body>

</html>