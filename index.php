<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
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
            <div class="centeredImage"><img src="styles/dtiLogo .png" width="150" height="150" ></div>

            
            <div id="window">
            <div>            
                <form id="loginForm" data-role="validator" novalidate="novalidate">
                    <ul>
                        <li>
                            <label for="Username">Username </label>
                            <input type="text" class="k-textbox" name="Username" id="username" required="required" />
                        </li> 
                        <li>
                            <label for="Password">Password </label>
                            <input type="password" class="k-textbox" name="Password" id="password" required="required" />
                        </li>   

                        <li class="actions">
                            <button type="button" id="btnLogin">Login</button>
                            <!--                        <button type="button" data-role="button" data-sprite-css-class="k-icon k-i-tick" data-click='login'>Login</button>-->
                            <button type="button" id="btnCancel" data-click='Cancel'>Cancel</button>

                        </li>       
                    </ul>
                </form>
            </div>                      
            </div>    
            <script type="text/javascript">
                function loginClick(e) {
                    var validator = $("#loginForm").data("kendoValidator");
                    if (validator.validate()) {

                        $.ajax({
                            type: "POST",
                            url: 'dataServing/authentication.php',
                            data: {
                                user: $("#username").val(),
                                pwd: $("#password").val()
                            },
                            success: function(data) {
                                console.log(data);
                                //history.pushState(null, "page 2", "coreCompetency_admin.php");
                                if(data.success==1) {
                                    window.location = "coreCompetency_admin.php";
                                } else {
                                    //alert(data.error);
                                    $("#loginForm").prepend('<span class="k-widget k-tooltip k-tooltip-validation k-invalid-msg" role="alert"><span class="k-icon k-warning"> </span>'+data.error+'</span>');
                                }
                            },
                            dataType: 'json'
                        });
                    }
                }

                function cancelClick(e) {
                    $("#username").val("");
                    $("#password").val("");

                    $('#loginForm').find("span.k-tooltip-validation").hide();
                }

                $(document).ready(function() {//javascript start
                    $("#btnLogin").kendoButton({// id is btnLogin
                        click: loginClick //call event onclick
                    });

                    $("#btnCancel").kendoButton({// id is btnLogin
                        click: cancelClick //call event onclick
                    });
                    var loginWindow = $('#window');
                    if(!loginWindow.data("kendoWindow")) {
                        loginWindow.kendoWindow({
                           width: "500px",
                           height: "200px",
                           title: "Please Log In",
                           resizable: false,
                           pinned: true,
                           draggable: false,
                           position :{
                                top: 175,
                                left: 350
                           }
                          
                        });
                        var dialog = loginWindow.data("kendoWindow");
                        dialog.center();
                    }
                    var loginForm = $('#loginForm');
                    kendo.init(loginForm);
                    loginForm.kendoValidator();
                    var dataSource = new kendo.data.DataSource({//call database
                        transport: {
                            read: {
                                type: "POST",
                                //url: crudServiceBaseUrl,
                                contentType: "application/json; charset=utf-8",
                                dataType: "json"
                            },
                            parameterMap: function(data, operation) {
                                //return JSON.stringify({})
                            },
                        },
                        schema: {
                            data: "data"//,
//                                    model: {
//                                        id: "id",
//                                        fields: {
//                                            name: {validation: {required: true}},
//                                            maxvalue: {type: "number", validation: {min: 0, required: true}}
//
//                                        }
//
//                                    }
                        }
                    });


                });
            </script>    

            
        </div>


    </body>
</html>
