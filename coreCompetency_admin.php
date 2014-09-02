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
            <div id="horizontal" style="height: 500px; width: 100%;" data-role="splitter">
                <div id="left-pane">
                    <div class="pane-content">
                        <div class="demo-section k-header">
                            <div id="treeview-left"></div>
                        </div>
                    </div>

                </div> 
                <div id="right-pane">
                    <div class="pane-content">
                        <div id="right-pane">
                            <div id="grid"  hidden="true"></div>
                            <div id="employeeGrid" hidden="true"></div>
                            <div id="treeview-employee" hidden="true"></div>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                var compentencyName = "";
                var crudServiceBaseUrl = "";
                var coreCompentency = "Core Competencies (สมรรถนะความสามารถหลัก)";
                var managerialCompentency = "Managerial Competencies (สมรรถนะความสามารถในการบริหาร)";
                var functionalCompentency = "Functional Competencies (สมรรถนะความสามารถตามสายงาน)";
                var selected = "";


                function onSelect(e) {
                    selected = this.text(e.node).toString();
                    var grid = $('#grid').data('kendoGrid');
                    var employeeGrid = $('#employeeGrid').data('kendoGrid');
                    var employeeTree = $('#treeview-employee').data('kendoTreeView');
                    var dataSrc = grid.dataSource;
                    var employeeSrc = employeeGrid.dataSource;
                    var employeeTreeSrc = employeeTree.dataSource;
                    // var dataItem = $("#treeview-left").data("kendoTreeView").dataSource.get(nodeId);
                    var dataItem = $("#treeview-left").data('kendoTreeView').dataItem(e.node);
                    console.log(dataItem.id);

                    if (selected == "Core Competencies") {
                        $('#grid').show();
                        $("#grid th[data-field=name]").html(coreCompentency);
                        dataSrc.transport.options.read.url = "http://localhost:8888/eCompetency/dataServing/coreCompetenciesData.php?function=read";
                        //dataSrc.transport.options.update.url = "http://localhost:8888/eCompetency/dataServing/coreCompetenciesData.php?function=update";
                    }
                    else if (selected == "Managerial Competencies") {
                        $('#grid').show();
                        $("#grid th[data-field=name]").html(managerialCompentency);
                        dataSrc.transport.options.read.url = "http://localhost:8888/eCompetency/dataServing/managerialCompetenciesData.php";
                    }
                    else if (selected == "AHD") {
                        $('#grid').show();
                        $("#grid th[data-field=name]").html(functionalCompentency);
                        dataSrc.transport.options.read.url = "http://localhost:8888/eCompetency/dataServing/funtionalCompetenciesData.php?function=" + selected;
                    }
                    else if (dataItem.id == "odc_info") {
                        $('#grid').hide();
                        $('#employeeGrid').show();
                        selected = "ODC";
                        employeeSrc.transport.options.read.url = "http://localhost:8888/eCompetency/dataServing/employeeData.php?employee_division=" + selected;
                    }

                    else if (dataItem.id == "occ_info") {
                        $('#grid').hide();
                        $('#employeeGrid').show();
                        selected = "OCC";
                        employeeSrc.transport.options.read.url = "http://localhost:8888/eCompetency/dataServing/employeeData.php?employee_division=" + selected;
                    }

                    else if (dataItem.id == "odc_evaluate") {
                        $('#grid').hide();
                        $('#employeeGrid').hide();
                        $('#treeview-employee').show;
                        selected = "ODC";
                        employeeSrc.transport.options.read.url = "http://localhost:8888/eCompetency/dataServing/employeeData.php?employee_division=" + selected;

                    }

                    var data = dataSrc.read();
                    grid.refresh();

                    var data = employeeSrc.read();
                    employeeGrid.refresh();

                }

                $(document).ready(function() {
                    //$("#verticalMenu").kendoMenu({orientation: "vertical" });

                    var serviceRootv = "http://localhost:8888/eCompetency/dataServing/divisionData.php";
                    homogeneousg = new kendo.data.HierarchicalDataSource({
                        transport: {
                            read: {
                                url: serviceRootv + "?perform=read",
                                dataType: "jsonp"
                            },
                            update: {
                                url: serviceRootv + "?perform=update",
                                dataType: "jsonp"
                            },
                            destroy: {
                                url: serviceRootv + "?perform=Destroy",
                                dataType: "jsonp"
                            },
                            create: {
                                url: serviceRootv + "?perform=Create",
                                dataType: "jsonp"
                            },
                        },
                        schema: {
                            model: {
                                id: "division_id",
                                hasChildren: "HasEmployees"
                            }
                        }
                    });

                    var serviceRoot = "http://localhost:8888/eCompetency/dataServing/employeeData.php?employee_division=";
                    homogeneous = new kendo.data.HierarchicalDataSource({
                        transport: {
                            read: {
                                url: serviceRoot + "ODC",
                                dataType: "json"
                            }
                        },
                        schema: {
                            model: {
                                id: "employee_division"
                            }
                        }
                    });

                    var employeeTreeSource = new kendo.data.DataSource({
                        transport: {
                            read: {
                                type: "POST",
                                url: crudServiceBaseUrl,
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
                    
                    var inlineDefault = new kendo.data.HierarchicalDataSource({
                        data: [
                            {text: "จัดการ Competencies", items: [
                                    {text: "Core Competencies"},
                                    {text: "Managerial Competencies"},
                                    {text: "Functional Competencies", items: [
                                            {text: "AHD"}
                                        ]}
                                ]},
                            {text: "กำหนดผู้ประเมิน", items: [
                                    {text: "SG"},
                                    {text: "TG"},
                                    {text: "AG"},
                                    {text: "OG", items: [
                                            {text: "OAE"},
                                            {text: "OCC"},
                                            {text: "ODC", id: "odc_evaluate"},
                                            {text: "OMM"},
                                            {text: "OMV"},
                                            {text: "ONE"},
                                            {text: "OPS"},
                                            {text: "OVS"},
                                            {text: "OEF"}
                                        ]}
                                ]},
                            {text: "ข้อมูลเจ้าหน้าที่", items: [
                                    {text: "SG"},
                                    {text: "TG"},
                                    {text: "AG"},
                                    {text: "OG", items: [
                                            {text: "OAE"},
                                            {text: "OCC", id: "occ_info"},
                                            {text: "ODC", id: "odc_info"},
                                            {text: "OMM"},
                                            {text: "OMV"},
                                            {text: "ONE"},
                                            {text: "OPS"},
                                            {text: "OVS"},
                                            {text: "OEF"}
                                        ]}
                                ]},
                            {text: "รายงาน"}
                        ]
                    });

                    $("#treeview-left").kendoTreeView({
                        dataSource: inlineDefault,
                        select: onSelect
                    });

                    $("#treeview-employee").kendoTreeView({
                        dataSource: employeeTreeSource,
                        dataTextField: "firstname"
                    });

                    $("#horizontal").kendoSplitter({
                        panes: [
                            {collapsible: true, size: "220px"},
                            {collapsible: false}
                        ]
                    });

                    var dataSource = new kendo.data.DataSource({
                        transport: {
                            read: {
                                type: "POST",
                                url: crudServiceBaseUrl,
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
                        dataSource: dataSource,
                        pageable: true,
                        height: 550,
                        toolbar: ["create"],
                        columns: [
                            {field: "name", title: compentencyName},
                            {field: "maxvalue", title: "ระดับที่คาดหวัง", width: "200px"},
                            {command: ["edit", "destroy"], title: "&nbsp;", width: "200px"}],
                        editable: "inline"
                    });

                    var employeeSource = new kendo.data.DataSource({
                        transport: {
                            read: {
                                type: "POST",
                                url: crudServiceBaseUrl,
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

                    $("#employeeGrid").kendoGrid({
                        dataSource: employeeSource,
                        pageable: true,
                        height: 550,
                        toolbar: ["create"],
                        columns: [
                            {field: "employee_id", title: "รหัสเจ้าหน้าที่", width: "100px"},
                            {field: "title", title: "คำนำหน้าชื่อ", width: "100px"},
                            {field: "firstname", title: "ชื่อ", width: "200px"},
                            {field: "lastname", title: "นามสกุล", width: "250px"},
                            {field: "division_code", title: "ส่วนงาน", width: "100px"},
                            {field: "level", title: "ระดับ", width: "100px"},
                            {command: ["edit", "destroy"], title: "&nbsp;"}],
                        editable: "inline"
                    });

//                      $("#evaluateGrid").kendoGrid({
//                        dataSource: employeeSource,
//                        pageable: true,
//                        height: 550,
//                        toolbar: ["create"],
//                        columns: [
//                            {field: "employee_id", title: "รหัสเจ้าหน้าที่", width: "100px"},
//                            {field: "title", title: "คำนำหน้าชื่อ", width: "100px"},
//                            {field: "firstname", title: "ชื่อ", width: "200px"},
//                            {field: "lastname", title: "นามสกุล", width: "250px"},
//                            {field: "division_code", title: "ส่วนงาน", width: "100px"},
//                            {field: "level", title: "ระดับ", width: "100px"},
//                            {command: ["edit", "destroy"], title: "&nbsp;"}],
//                        editable: "inline"
//                    });




//                    var dropDown = grid.find("#category").kendoDropDownList({
//                        dataTextField: "CategoryName",
//                        dataValueField: "CategoryID",
//                        autoBind: false,
//                        optionLabel: "All",
//                        dataSource: {
//                            type: "odata",
//                            severFiltering: true,
//                            transport: {
//                                read: "http://demos.telerik.com/kendo-ui/service/Northwind.svc/Categories"
//                            }
//                        },
//                        change: function() {
//                            var value = this.value();
//                            if (value) {
//                                grid.data("kendoGrid").dataSource.filter({ field: "CategoryID", operator: "eq", value: parseInt(value) });
//                            } else {
//                                grid.data("kendoGrid").dataSource.filter({});
//                            }
//                        }
//                    });
                });
            </script>
        </div>

    </body>
</html>
