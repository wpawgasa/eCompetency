<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="kendoUI/styles/kendo.common.min.css" rel="stylesheet"/>
        <link href="kendoUI/styles/kendo.default.min.css" rel="stylesheet"/>
        <link href="kendoUI/styles/kendo.dataviz.min.css" rel="stylesheet"/>
        <link href="kendoUI/styles/kendo.dataviz.default.min.css" rel="stylesheet"/>
        <link href="styles/default.css" rel="stylesheet"/>
        <script src="kendoUI/js/jquery.min.js"></script>
        <script src="js/angular.min.js"></script>
        <script src="kendoUI/js/kendo.all.min.js"></script>
    </head>
    <body>
        <div id="example">
            <div class="leftImage"><img src="styles/header.png" height="110" ></div>
            <div class="myName" id="myName" style="text-align: left;">Name: Roongtawan Laimek &nbsp;&nbsp;&nbsp;&nbsp; ID : 571012 &nbsp;&nbsp;&nbsp;&nbsp; Position : ODC1</div>
            
            <div id="grid"></div>

             <script type="text/x-kendo-template" id="template">
                <div class="toolbar">
                    <label class="header-label">รายชื่อผู้ที่จะทำการประเมิน:</label>
                </div>
            </script>
            <script>
                var selected = "ODC";
                var grid = $('#grid').data('kendoGrid');
                //var employeeSrc = grid.dataSource;
                //employeeSrc.transport.options.read.url = "http://localhost:8888/eCompetency/dataServing/employeeData.php?employee_division=" + selected;
                //var data = employeeSrc.read();
                //grid.refresh();


//
//                

                $(document).ready(function() {
                    //$("#verticalMenu").kendoMenu({orientation: "vertical" });



                    var employeeSource = new kendo.data.DataSource({
                        transport: {
                            read: {
                                type: "POST",
                                url: "http://localhost:8888/eCompetency/dataServing/employeeData.php?employee_division=" + selected,
                                contentType: "application/json; charset=utf-8",
                                dataType: "json"
                            },
                        },
                        schema: {
                            data: "data",
                            model: {
                                id: "id",
                                fields: {
                                    name: {validation: {required: true}},
                                    maxvalue: {type: "number", validation: {min: 0, required: true}}

                                }

                            }
                        }
                    });

                    $("#grid").kendoGrid({
                        dataSource: employeeSource,
                        toolbar: kendo.template($("#template").html()),
                        pageable: true,
                        height: 550,
                        columns: [
                            {field: "employee_id", title: "รหัสเจ้าหน้าที่", width: "100px"},
                            {field: "title", title: "คำนำหน้าชื่อ", width: "100px"},
                            {field: "firstname", title: "ชื่อ", width: "200px"},
                            {field: "lastname", title: "นามสกุล", width: "250px"},
                            {field: "maxvalue", title: "ฐานะผู้ประเมิน", width: "200px"}]
                    });

                });

            </script>


        </div>


    </body>
</html>
