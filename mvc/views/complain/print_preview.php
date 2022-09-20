<!DOCTYPE html5>
<html lang="en">
<head>
    <title><?php echo $panel_title; ?></title>

    <style type="text/css">
        #page-wrap {
            width: 700px;
            margin: 0 auto;
        }

        .page-break {
            page-break-after: always;
        }

        table.print-friendly tr td, table.print-friendly tr th {
            page-break-inside: avoid;
        }

        .center-justified {
            text-align: justify;
            margin: 0 auto;
            width: 30em;
        }
        /*ini starts here*/
        .list-group {
            padding-left: 0;
            margin-bottom: 15px;
            width: auto;
        }
        .list-group-item {
            position: relative;
            display: block;
            padding: 7.5px 10px;
            margin-bottom: -1px;
            background-color: #fff;
            border: 1px solid #ddd;
            /*margin: 2px;*/
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
            font-size: 12px;
        }
        th {
            background-color: #721220;
            color: #000000;
        }
        td,
        th {
            padding: 2px;
        }
        @media print {
            * {
                color: #000 !important;
                text-shadow: none !important;
                background: transparent !important;
                box-shadow: none !important;
            }
            a,
            a:visited {
                text-decoration: underline;
            }
            a[href]:after {
                content: " (" attr(href) ")";
            }
            abbr[title]:after {
                content: " (" attr(title) ")";
            }
            a[href^="javascript:"]:after,
            a[href^="#"]:after {
                content: "";
            }
            pre,
            blockquote {
                border: 1px solid #999;

                page-break-inside: avoid;
            }
            thead {
                display: table-header-group;
            }
            tr,
            img {
                page-break-inside: avoid;
            }
            img {
                max-width: 100% !important;
            }
            p,
            h2,
            h3 {
                orphans: 3;
                widows: 3;
            }
            h2,
            h3 {
                page-break-after: avoid;
                color: #721220;
            }
            select {
                background: #fff !important;
            }
            .navbar {
                display: none;
            }
            .table td,
            .table th {
                background-color: #fff !important;
            }
            .btn > .caret,
            .dropup > .btn > .caret {
                border-top-color: #000 !important;
            }
            .label {
                border: 1px solid #000;
            }
            .table {
                border-collapse: collapse !important;
            }
            .table-bordered th,
            .table-bordered td {
                border: 1px solid #ddd !important;
            }
        }
        table {
            max-width: 100%;
            background-color: transparent;
            font-size: 12px;
        }
        th {
            text-align: left;
        }
        .table {
            width: 100%;
            margin-bottom: 20px;
        }
        .table h4 {
            font-size: 15px;
            padding: 0px;
            margin: 0px;
        }
        .head {
            border-top: 0px solid #e2e7eb;
            border-bottom: 0px solid #e2e7eb;
        }
        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td {
            padding: 8px;
            line-height: 1.428571429;
            vertical-align: top;
            /*border-top: 1px solid #e2e7eb; */
        }
        /*ini edit default value : border top 1px to 0 px*/
        .table > thead > tr > th {
            font-size: 15px;
            font-weight: 500;
            vertical-align: bottom;
            /*border-bottom: 2px solid #e2e7eb;*/
            color: #242a30;


        }

        .table > caption + thead > tr:first-child > th,
        .table > colgroup + thead > tr:first-child > th,
        .table > thead:first-child > tr:first-child > th,
        .table > caption + thead > tr:first-child > td,
        .table > colgroup + thead > tr:first-child > td,
        .table > thead:first-child > tr:first-child > td {
            border-top: 0;
        }
        .table > tbody + tbody {
            border-top: 2px solid #e2e7eb;
        }
        .table .table {
            background-color: #fff;
        }
        .table-condensed > thead > tr > th,
        .table-condensed > tbody > tr > th,
        .table-condensed > tfoot > tr > th,
        .table-condensed > thead > tr > td,
        .table-condensed > tbody > tr > td,
        .table-condensed > tfoot > tr > td {
            padding: 5px;
        }
        .table-bordered {
            border: 1px solid #e2e7eb;
        }
        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > th,
        .table-bordered > tfoot > tr > th,
        .table-bordered > thead > tr > td,
        .table-bordered > tbody > tr > td,
        .table-bordered > tfoot > tr > td {
            border: 1px solid #e2e7eb;
        }
        .table-bordered > thead > tr > th,
        .table-bordered > thead > tr > td {
            border-bottom-width: 2px;
        }
        .table-striped > tbody > tr:nth-child(odd) > td,
        .table-striped > tbody > tr:nth-child(odd) > th {
            background-color: #f0f3f5;
        }
        .panel-title {
            margin-top: 0;
            margin-bottom: 0;
            font-size: 20px;
            color: #fff;
            padding: 0;
        }
        .panel-title > a {
            color: #707478;
            text-decoration: none;
        }
        .text-center {
            text-align: center;
        }
        a {
            background: transparent;
            color: #707478;
            text-decoration: none;
        }
        strong {
            color: #707478;
        }
        td > p > span
        {
            display: block;
        }
    </style>
</head>
<body>
<div id="page-wrap">
    <table width="100%" style="margin: 50px 0 20px 0;" >
        <tr>
            <td width="10%" style="vertical-align: top; text-align: left;" >
                <?php
                    if($siteinfos->photo) {
                        $array = array(
                            "src" => base_url('uploads/images/'.$siteinfos->photo),
                            'width' => '75px',
                            'height' => '68px',
                            "style" => "margin-right:0px;"
                        );
                        echo img($array)."<br>";
                    }
                ?>
            </td>
            <td width="75%" style="vertical-align: top; padding-top: 5px; text-align: left;">
                <h2>
                    <?php
                        echo $siteinfos->sname;
                    ?>
                </h2>
                <p>
                    <span><?=$siteinfos->address;?></span><br>
                    <span><?=$siteinfos->phone;?></span><br>
                    <span><?=$siteinfos->email;?></span>
                </p>
            </td>
        </tr>
    </table>
    <table width="100%" style="margin: 0px 0 20px 0;" class="table table-responsive table-bordered">
        <tbody>
        <?php if ($complain->attachment!=null) { ?>
            <tr>
                <td colspan="2">
                    <img style="display:block; width: 100px; height: 100px;" src="<?=base_url("uploads/attach/".$complain->attachment);
                    ?>" class="img-thumbnail" alt="" />
                </td>

            </tr>
        <?php } ?>
        <tr>
            <td><?=$this->lang->line("complain_usertypeID")?></td>
            <td><?php echo $usertype->usertype; ?></td>
        </tr>
        <tr>
            <td><?=$this->lang->line("complain_userID")?></td>
            <td><?php echo $user->name; ?></td>
        </tr>
        <tr>
            <td><?=$this->lang->line("complain_title")?></td>
            <td><?php echo $complain->title; ?></td>
        </tr>
        <tr>
            <td><?=$this->lang->line("complain_description")?></td>
            <td><?php echo $complain->description; ?></td>
        </tr>
        </tbody>
    </table>

    <!--mark new -->

    <!--mark new end-->
    <div id="page-footer">
        <table width="100%">
            <tr width="100%">
                <td class="text-center">
                    <strong><?=$siteinfos->footer?></strong>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
