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
        <script src="kendoUI/js/angular.min.js"></script>
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

                        <div id="grid"  hidden="true"></div>
                        <div id="employeeGrid" hidden="true"></div>

                        <div class="demo-section-xx" id="split" style="height: 500px; width: 100%;">
                            <div class="box-col" >
                                <span class="k-textbox k-space-left">
                                    <input type="text" value="Input with icon left" />
                                    <a href="#" class="k-icon k-i-search">&nbsp;</a>
                                </span>
                                <div class="demo-section-tree-employee">
                                    <div id="treeview-employee-left"  ></div>
                                </div>

                            </div>
                            <div class="box-col">
                                <div class="demo-section-tree-employee">
                                    <div id="treeview-employee-right"  ></div>
                                </div>
                            </div>

                        </div>


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

            $("#split").kendoSplitter({
                orientation: "horizontal"

            });

            function onSelect(e) {
                selected = this.text(e.node).toString();
                var grid = $('#grid').data('kendoGrid');
                var employeeGrid = $('#employeeGrid').data('kendoGrid');
                var employeeTree = $('#treeview-employee').data('kendoTreeView');
                var dataSrc = grid.dataSource;
                var employeeSrc = employeeGrid.dataSource;
                // var employeeTreeSrc = employeeTree.dataSource;
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
                    $('#split').show();

                }

                var data = dataSrc.read();
                grid.refresh();

                var data = employeeSrc.read();
                employeeGrid.refresh();

            }

//            function onDrop(e) {
//                e.preventDefault();
//                var copy = this.dataItem(e.sourceNode).toJSON();
//                console(e.dropPosition);
//                if (e.dropPosition == "over") {
//
//                    $('#treeview-employee-left').append(copy, $(e.destinationNode));
//                }
//
//            }
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
                        }
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
                        }
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

                $("#treeview-employee-left").kendoTreeView({
                    dragAndDrop: true,
                    dataSource: [
                        {text: "นาวาอากาศตรี จิรเดช เกิดศรี"},
                        {text: "นาวาอากาศโท พันธุ์เทพ แก้วมงคล"},
                        {text: "นาวาอากาศตรี วิชัย แผ้วเกษม"},
                        {text: "นางสาวอุบล ธงสถาพรวัฒนา"},
                        {text: "นายชนาธิป ชื่นมนัส"},
                        {text: "ร้อยโท พันธุ์ศักดิ์ วงศ์อนุ"},
                        {text: "นายสมเกียรติ ไกรสินธุ์"},
                        {text: "นางสาวผกามาศ วงศ์สาย"},
                        {text: "นางสาวรุ้งจะวัน ลายเมฆ"}
                    ]
                });

                $("#treeview-employee-right").kendoTreeView({
                    dragAndDrop: true,
                    height: 550,
                    dataSource: [
                        {text: "นาวาอากาศตรี จิรเดช เกิดศรี", expanded: true, items: [
                                {text: "ผู้บีงคับบัญชาโดยตรง"},
                                {text: "ผู้บังคับบัญชาโดยอ้อม"},
                                {text: "เพื่อนร่วมงานคนที่ 1"},
                                {text: "เพื่อนร่วมงานคนที่ 2"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 1"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 2"}
                            ]},
                        {text: "นาวาอากาศโท พันธุ์เทพ แก้วมงคล", expanded: true, items: [
                                {text: "ผู้บีงคับบัญชาโดยตรง"},
                                {text: "ผู้บังคับบัญชาโดยอ้อม"},
                                {text: "เพื่อนร่วมงานคนที่ 1"},
                                {text: "เพื่อนร่วมงานคนที่ 2"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 1"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 2"}
                            ]},
                        {text: "นาวาอากาศตรี วิชัย แผ้วเกษม", expanded: true, items: [
                                {text: "ผู้บีงคับบัญชาโดยตรง"},
                                {text: "ผู้บังคับบัญชาโดยอ้อม"},
                                {text: "เพื่อนร่วมงานคนที่ 1"},
                                {text: "เพื่อนร่วมงานคนที่ 2"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 1"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 2"}]},
                        {text: "นางสาวอุบล ธงสถาพรวัฒนา", expanded: true, items: [
                                {text: "ผู้บีงคับบัญชาโดยตรง"},
                                {text: "ผู้บังคับบัญชาโดยอ้อม"},
                                {text: "เพื่อนร่วมงานคนที่ 1"},
                                {text: "เพื่อนร่วมงานคนที่ 2"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 1"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 2"}]},
                        {text: "นายชนาธิป ชื่นมนัส", expanded: true, items: [
                                {text: "ผู้บีงคับบัญชาโดยตรง"},
                                {text: "ผู้บังคับบัญชาโดยอ้อม"},
                                {text: "เพื่อนร่วมงานคนที่ 1"},
                                {text: "เพื่อนร่วมงานคนที่ 2"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 1"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 2"}]},
                        {text: "ร้อยโท พันธุ์ศักดิ์ วงศ์อนุ", expanded: true, items: [
                                {text: "ผู้บีงคับบัญชาโดยตรง"},
                                {text: "ผู้บังคับบัญชาโดยอ้อม"},
                                {text: "เพื่อนร่วมงานคนที่ 1"},
                                {text: "เพื่อนร่วมงานคนที่ 2"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 1"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 2"}]},
                        {text: "นายสมเกียรติ ไกรสินธุ์", expanded: true, items: [
                                {text: "ผู้บีงคับบัญชาโดยตรง"},
                                {text: "ผู้บังคับบัญชาโดยอ้อม"},
                                {text: "เพื่อนร่วมงานคนที่ 1"},
                                {text: "เพื่อนร่วมงานคนที่ 2"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 1"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 2"}]},
                        {text: "นางสาวผกามาศ วงศ์สาย", expanded: true, items: [
                                {text: "ผู้บีงคับบัญชาโดยตรง"},
                                {text: "ผู้บังคับบัญชาโดยอ้อม"},
                                {text: "เพื่อนร่วมงานคนที่ 1"},
                                {text: "เพื่อนร่วมงานคนที่ 2"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 1"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 2"}]},
                        {text: "นางสาวรุ้งจะวัน ลายเมฆ", expanded: true, items: [
                                {text: "ผู้บีงคับบัญชาโดยตรง"},
                                {text: "ผู้บังคับบัญชาโดยอ้อม"},
                                {text: "เพื่อนร่วมงานคนที่ 1"},
                                {text: "เพื่อนร่วมงานคนที่ 2"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 1"},
                                {text: "ผู้ใต้บังคับบัญชาคนที่ 2"}]}
                    ]
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
                        }
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
