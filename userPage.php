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
            <div id="grid"></div>

            <script type="text/x-kendo-template" id="template">
                <div class="toolbar">
                    <label class="category-label">บุคคลที่ต้องการประเมิน:</label>
                    <input id="person" style="width: 150px"/>
                </div>
            </script>

            <script>
                var compentencyName = "";
                var crudServiceBaseUrl = "";
                var coreCompentency = "Core Competencies (สมรรถนะความสามารถหลัก)";
                var managerialCompentency = "Managerial Competencies (สมรรถนะความสามารถในการบริหาร)";
                var functionalCompentency = "Functional Competencies (สมรรถนะความสามารถตามสายงาน)";
                var grid = $('#grid').data('kendoGrid');

//
//                function onSelect(e) {
//                    var selected = this.text(e.node).toString();
//
//                    var dataSrc = grid.dataSource;
//
//                    if (selected == "Core Competencies") {
//                        $("#grid th[data-field=name]").html(coreCompentency);
//                        dataSrc.transport.options.read.url = "http://localhost:8888/eCompetency/dataServing/coreCompetenciesData.php";
//                    }
//                    else if (selected == "Managerial Competencies") {
//                        $("#grid th[data-field=name]").html(managerialCompentency);
//                        dataSrc.transport.options.read.url = "http://localhost:8888/eCompetency/dataServing/managerialCompetenciesData.php";
//                    }
//                    else if (selected == "AHD") {
//                        $("#grid th[data-field=name]").html(functionalCompentency);
//                        dataSrc.transport.options.read.url = "http://localhost:8888/eCompetency/dataServing/funtionalCompetenciesData.php?function=" + selected;
//                    }
//                    var data = dataSrc.read();
//                    grid.refresh();
//
//
//                }

                $(document).ready(function() {
                    //$("#verticalMenu").kendoMenu({orientation: "vertical" });

                    var dataSource = new kendo.data.DataSource({
                        transport: {
                            read: {
                                type: "POST",
                                url: "http://localhost:8888/eCompetency/dataServing/competenciesData.php?function=read",
                                contentType: "application/json; charset=utf-8",
                                dataType: "json"
                            }
                        },
                        schema: {
                            data: "data",
                            model: {
                                id: "id",
                                fields: {
                                  
                                    name: {validation: {required: true}},
                                    maxvalue: {type: "number", validation: {min: 0, required: true}},
                                    competency_group: {type: "number", title: "Competency"}
                                }

                            }
                        },
                        group: {
                            field: "competency_group"
                        }
                        
                        
                    });

                    $("#grid").kendoGrid({
                        dataSource: dataSource,
                        toolbar: kendo.template($("#template").html()),
                        pageable: true,
                        height: 550,
                        columns: [
                            {field: "competency_group", title:"Competency",groupHeaderTemplate: "#if(value==1){# Core Competency #} else if(value==2) {# Managerial Competency #} else if(value==3) {# Functional Competency #}#"},
                            {field: "name", title: "Competencies",headerAttributes: {style: "text-align: center;"}},
                            {field: "maxvalue", title: "ระดับที่คาดหวัง", width: "100px", attributes: {style: "text-align: center;"}, headerAttributes: {style: "text-align: center;"}},
                            {
                                headerAttributes: {style: "text-align: center;"},
                                width: "35px",
                                field: "0.5",
                                title: "0.5",
                                template: '<input type="checkbox" name="0.5checkbox" value="enable" />'
                            },
                            {
                                headerAttributes: {style: "text-align: center;"},
                                width: "35px",
                                field: "1",
                                title: "1",
                                template: '<input type="checkbox" name="1checkbox" value="enable" />'
                            },
                            {
                                headerAttributes: {style: "text-align: center;"},
                                width: "35px",
                                field: "1.5",
                                title: "1.5",
                                template: '<input type="checkbox" name="1.5checkbox" value="enable" />'
                            },
                            {
                                headerAttributes: {style: "text-align: center;"},
                                width: "35px",
                                field: "2",
                                title: "2",
                                template: '<input type="checkbox" name="2checkbox" value="enable"" />'
                            },
                            {
                                headerAttributes: {style: "text-align: center;"},
                                width: "35px",
                                field: "2.5",
                                title: "2.5",
                                template: '<input type="checkbox" name="2.5checkbox" value="enable" />'
                            },
                            {
                                headerAttributes: {style: "text-align: center; background: yellow"},
                                attributes: { style:"text-align: center; background: yellow"},
                                width: "35px",
                                field: "3",
                                title: "3",
                                template: '<input type="checkbox" name="3checkbox" value="enable" />',
                                
                            },
                            {
                                headerAttributes: {style: "text-align: center;"},
                                width: "35px",
                                field: "3.5",
                                title: "3.5",
                                template: '<input type="checkbox" name="3.5checkbox"  value="enable" />'
                            },
                            {
                                headerAttributes: {style: "text-align: center;"},
                                width: "35px",
                                field: "4",
                                title: "4",
                                template: '<input type="checkbox" name="4checkbox" value="enable" />'
                            },
                            {
                                headerAttributes: {style: "text-align: center;"},
                                width: "35px",
                                field: "4.5",
                                title: "4.5",
                                template: '<input type="checkbox" name="4.5checkbox" value="enable" />'
                            },
                            {
                                headerAttributes: {style: "text-align: center;"},
                                width: "35px",
                                field: "5",
                                title: "5",
                                template: '<input type="checkbox" name="5checkbox" value="enable" />'
                            },
                            {field: "comment", title: "ความเห็นเพิ่มเติม Comments *", width: "320px", headerAttributes: {style: "text-align: center;"}, template: '<input type="text" style="min-width:300px;"/>'}]
                     
                    });
                    $("#grid").data("kendoGrid").hideColumn("competency_group");
                    
                    var personData = [
                        { text: "Black", value: "1" },
                        { text: "Orange", value: "2" },
                        { text: "Grey", value: "3" }
                    ];
                    
                    $("#person").kendoDropDownList();
                    $("#person").kendoDropDownList({
                        dataTextField: "text",
                        dataValueField: "value",
                        dataSource: personData,
               
                        change: onChange
                    });
                });
            </script>
            
            
        </div>


    </body>
</html>
