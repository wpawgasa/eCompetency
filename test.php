<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="styles/kendo.common.min.css" rel="stylesheet" />
    <link href="styles/kendo.default.min.css" rel="stylesheet" />
    <link href="styles/kendo.dataviz.min.css" rel="stylesheet" />
    <link href="styles/kendo.dataviz.default.min.css" rel="stylesheet" />
    <script src="js/jquery.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/kendo.all.min.js"></script>
</head>
<body>
    
        <div id="example">
            <div id="grid"></div>
            <script>
                $(document).ready(function() {
                    $("#grid").kendoGrid({
                        dataSource: {
                            type: "odata",
                            transport: {
                                read: "http://demos.telerik.com/kendo-ui/service/Northwind.svc/Products"
                            },
                            schema:{
                                model: {
                                    fields: {
                                        UnitsInStock: { type: "number" },
                                        ProductName: { type: "string" },
                                        UnitPrice: { type: "number" },
                                        UnitsOnOrder: { type: "number" },
                                        UnitsInStock: { type: "number" }
                                    }
                                }
                            },
                            pageSize: 7,
                            group: {
                                     field: "UnitsInStock", aggregates: [
                                        { field: "ProductName", aggregate: "count" },
                                        { field: "UnitPrice", aggregate: "sum"},
                                        { field: "UnitsOnOrder", aggregate: "average" },
                                        { field: "UnitsInStock", aggregate: "count" }
                                     ]
                                   },

                            aggregate: [ { field: "ProductName", aggregate: "count" },
                                          { field: "UnitPrice", aggregate: "sum" },
                                          { field: "UnitsOnOrder", aggregate: "average" },
                                          { field: "UnitsInStock", aggregate: "min" },
                                          { field: "UnitsInStock", aggregate: "max" }]
                        },
                        sortable: true,
                        scrollable: false,
                        pageable: true,
                        columns: [
                            { field: "ProductName", title: "Product Name", footerTemplate: "Total Count: #=count#", groupFooterTemplate: "Count: #=count#" },
                            { field: "UnitPrice", title: "Unit Price" },
                            { field: "UnitsOnOrder", title: "Units On Order", footerTemplate: "Average: #=average#",
                                groupFooterTemplate: "Average: #=average#" },
                            { field: "UnitsInStock", title: "Units In Stock", footerTemplate: "<div>Min: #= min #</div><div>Max: #= max #</div>",
                                groupHeaderTemplate: "Units In Stock: #= value # (Count: #= count#)" }
                        ]
                    });
                });
            </script>
        </div>


</body>
</html>