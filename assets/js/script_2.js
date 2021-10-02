jQuery(document).ready(function ($) {


    $(".filter_list_installment").on("input change", function () {
        var data = new FormData;
        data.append("action", "return_installment");
        data.append("nonce", my_custom_script_nonce.sec_nonce);
        data.append("id_order", $("#id_order").val());
        data.append("name", $("#name").val());
        data.append("organ", $("#organ").val());
        data.append("from_d", $("#from_day").val());
        data.append("from_m", $("#from_month").val());
        data.append("from_y", $("#from_year").val());
        data.append("to_d", $("#to_day").val());
        data.append("to_m", $("#to_month").val());
        data.append("to_y", $("#to_year").val());

        data.append("code_melli", $("#code_melli").val());
        data.append("code_personnel", $("#code_personnel").val());
        data.append("mobile", $("#mobile").val());

        data.append("section", $("#section").val());
        $.ajax(
            {
                url: my_custom_script_nonce.ajaxurl,
                type: "POST",
                processData: false,
                contentType: false,

                data: data,

                success: function (response) {
                    $("#t-body").empty()
                        .append(response);

                },
                error: function (error) {
                    console.log(error);

                }
            }
        )
    });




    $(".filter_list_order").on("input change", function () {
        var data = new FormData;
        data.append("action", "return_order");
        data.append("nonce", my_custom_script_nonce.sec_nonce);
        data.append("id_order", $("#id_order").val());
        data.append("name", $("#name").val());
        data.append("organ", $("#organ").val());
        data.append("code_melli", $("#code_melli").val());
        data.append("code_personnel", $("#code_personnel").val());
        data.append("mobile", $("#mobile").val());
        $.ajax(
            {
                url: my_custom_script_nonce.ajaxurl,
                type: "POST",
                processData: false,
                contentType: false,

                data: data,

                success: function (response) {
                    $("#t-body").empty()
                        .append(response);

                },
                error: function (error) {
                    console.log(error);

                }
            }
        )
    });


    $(".filter_list_dokandar").on("input change", function () {
        var data = new FormData;
        data.append("action", "return_list_dokandar");
        data.append("nonce", my_custom_script_nonce.sec_nonce);
        data.append("id_order", $("#id_order").val());
        data.append("name", $("#name").val());
        data.append("organ", $("#organ").val());
        data.append("code_melli", $("#code_melli").val());
        data.append("code_personnel", $("#code_personnel").val());
        data.append("mobile", $("#mobile").val());
        $.ajax(
            {
                url: my_custom_script_nonce.ajaxurl,
                type: "POST",
                processData: false,
                contentType: false,

                data: data,

                success: function (response) {
                    $("#t-body").empty()
                        .append(response);

                },
                error: function (error) {
                    console.log(error);

                }
            }
        )
    });




    $(".filter_personnel").on("input", function () {
        var data = new FormData;
        data.append("action", "return_personnel");
        data.append("nonce", my_custom_script_nonce.sec_nonce);
        data.append("name", $("#name_personnel").val());
        data.append("family", $("#family_personnel").val());
        data.append("code_melli", $("#code_melli_personnel").val());
        data.append("mobile", $("#mobile_personnel").val());
        $.ajax(
            {
                url: my_custom_script_nonce.ajaxurl,
                type: "POST",
                processData: false,
                contentType: false,

                data: data,

                success: function (response) {
                    $("#t-body-personnel").empty()
                        .append(response);

                },
                error: function (error) {
                    console.log(error);

                }
            }
        )
    });

    $(".filter_tree").click(function () {
        var data = new FormData;
        data.append("action", "return_installment_tree");
        data.append("nonce", my_custom_script_nonce.sec_nonce);
        data.append("user", $(this).data("user"));
        data.append("product", $(this).data("product"));
        data.append("details", $(this).data("details"));
        $.ajax(
            {
                url: my_custom_script_nonce.ajaxurl,
                type: "POST",
                processData: false,
                contentType: false,

                data: data,

                success: function (response) {
                    $("#t-body").empty()
                        .append(response);

                },
                error: function (error) {
                    console.log(error);

                }
            }
        )
    });


    $(".filter_tree_order").click(function () {
        var data = new FormData;
        data.append("action", "return_order_tree");
        data.append("nonce", my_custom_script_nonce.sec_nonce);
        data.append("user", $(this).data("user"));
        data.append("product", $(this).data("product"));
        data.append("details", $(this).data("details"));
        $.ajax(
            {
                url: my_custom_script_nonce.ajaxurl,
                type: "POST",
                processData: false,
                contentType: false,

                data: data,

                success: function (response) {
                    $("#t-body").empty()
                        .append(response);

                },
                error: function (error) {
                    console.log(error);

                }
            }
        )
    });


});

