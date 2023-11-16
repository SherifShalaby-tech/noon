//brand form
$("#create-brand-btn").click(function (e) {
    e.preventDefault();
    setTimeout(() => {
        $("#brand-form").submit();
        $("#quick_add_brand_form").submit();
    }, 500)
});
$(document).on("submit", "form#quick_add_brand_form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                Swal.fire({
                    title: `${result.msg}`,
                    type: 'success',
                    icon: 'success',
                    showConfirmButton: false,
                    // confirmButtonText:"حسنا",
                    // confirmButtonColor: '#3085d6',
                    timer: 1000
                });
                $("#createBrandModal").modal("hide");
                var brand_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/brands/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#brand_id").empty().append(data_html);
                        $("#brand_id").val(brand_id).trigger();
                    },
                });
            } else {
                Swal.fire("Error", result.msg, "error");
            }
        },
    });
});
//brand form
//unit form
var raw_index = 0;
var type = "";
$(document).on('click', '.add_unit_raw', function () {
    raw_index = $(this).data('index');
    type = $(this).data('type');
})
$("#create-unit-btn").click(function (e) {
    e.preventDefault();
    setTimeout(() => {
        $("#unit-form").submit();
        $("#quick_add_unit_form").submit();
    }, 500)
});
$(document).on("submit", "form#quick_add_unit_form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                Swal.fire({
                    title: `${result.msg}`,
                    type: 'success',
                    icon: 'success',
                    showConfirmButton: false,
                    // confirmButtonText:"حسنا",
                    // confirmButtonColor: '#3085d6',
                    timer: 1000
                });
                $("#create").modal("hide");
                var unit_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/units/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        if (type == "basic_unit") {
                            $(".basic_unit_id" + raw_index).empty().append(data_html);
                            $(".basic_unit_id" + raw_index).val(unit_id).change();
                        } else {
                            $(".unit_id" + raw_index).empty().append(data_html);
                            $(".unit_id" + raw_index).val(unit_id).change();
                        }

                    },
                });
            } else {
                // Swal.fire("Error", result.msg, "error");
                Swal.fire({
                    title: "Error",
                    text: response.status,
                    icon: "error",
                    timer: 1000, // Set the timer to 1000 milliseconds (1 second)
                    showConfirmButton: false // This will hide the "OK" button
                });
            }
        },
    });
});
//unit form

//store form
$("#create-store-btn").click(function (e) {
    e.preventDefault();
    setTimeout(() => {
        $("#add_store").submit();
        $("#quick_add_store_form").submit();
    }, 500)
});
$(document).on("submit", "form#quick_add_store_form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                // Swal.fire(`${result.msg}`, '', "success", {
                //     timer: 500,
                //     toast: true
                // });
                Swal.fire({
                    title: `${result.msg}`,
                    type: 'success',
                    icon: 'success',
                    showConfirmButton: false,
                    // confirmButtonText:"حسنا",
                    // confirmButtonColor: '#3085d6',
                    timer: 1000
                });
                $(".add-store").modal("hide");
                var store_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/stores/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#store_id").empty().append(data_html);
                        $("#store_id").val(store_id).trigger();
                    },
                });
            } else {
                // Swal.fire("Error", result.msg, "error");
                Swal.fire({
                    title: "Error",
                    text: response.status,
                    icon: "error",
                    timer: 1000, // Set the timer to 1000 milliseconds (1 second)
                    showConfirmButton: false // This will hide the "OK" button
                });
            }
        },
    });
});
$("#create-supplier-btn").click(function (e) {
    e.preventDefault();
    setTimeout(() => {
        $("#add_supplier").submit();
        $("#quick_add_supplier_form").submit();
    }, 500)
});
$(document).on("submit", "form#quick_add_supplier_form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                // Swal.fire("Success", result.msg, "success");
                Swal.fire({
                    title: `${result.msg}`,
                    type: 'success',
                    icon: 'success',
                    showConfirmButton: false,
                    // confirmButtonText:"حسنا",
                    // confirmButtonColor: '#3085d6',
                    timer: 1000
                });
                $(".add-supplier").modal("hide");
                var supplier_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/suppliers/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#supplier_id").empty().append(data_html);
                        $("#supplier_id").val(supplier_id).trigger();
                    },
                });
            } else {
                Swal.fire("Error", result.msg, "error");
            }
        },
    });
});
//store form

//category form
var select_category = 0;
var main_category_id = 0;
$(".openCategoryModal").click(function (e) {
    select_category = $(this).data('select_category');
    if (select_category == "0") {
        main_category_id = 0;
    }
    else if (select_category == "1") {
        main_category_id = $("#categoryId").val();
    }
    else if (select_category == "2") {
        main_category_id = $("#subcategory_id1").val();
    }
    else if (select_category == "3") {
        main_category_id = $("#subCategoryId2").val();
    }
    console.log(select_category, main_category_id)

    if ((main_category_id !== '' && select_category != 0) || main_category_id === 0) {
        $(this).addClass('btn-modal');
    } else {
        // Swal.fire("warning", LANG.no_parent_category, "warning");
        Swal.fire({
            title: "warning",
            text: LANG.no_parent_category,
            icon: "warning",
            timer: 1000, // Set the timer to 1000 milliseconds (1 second)
            showConfirmButton: false // This will hide the "OK" button
        });
    }
});
$("#create-category-btn").click(function (e) {
    e.preventDefault();
    setTimeout(() => {
        $("#create-category-form").submit();
    }, 500)
});
$(document).on("submit", "#create-category-form", function (e) {
    e.preventDefault();
    var dataArray = $(this).serializeArray();
    var data = {};
    var name = $('.category-name').val();
    // Convert the serialized array into an object
    $.each(dataArray, function (index, field) {
        data[field.name] = field.value;
    });
    console.log(select_category)
    console.log(data);
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: {
            data: data,
            parent_id: main_category_id,
            name: name
        },
        success: function (result) {
            if (result.success) {
                Swal.fire({
                    title: `${result.msg}`,
                    type: 'success',
                    icon: 'success',
                    showConfirmButton: false,
                    // confirmButtonText:"حسنا",
                    // confirmButtonColor: '#3085d6',
                    timer: 1000
                });
                $("#createCategoryModal").modal("hide");
                $(".createSubCategoryModal").modal("hide");
                console.log(main_category_id);
                var category_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/categories/get-dropdown/" + main_category_id,
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        if (select_category == "0") {
                            $("#categoryId").empty().append(data_html);
                            $("#categoryId").val(category_id).change();
                        } else if (select_category == "2") {
                            console.log(data_html);

                            $("#subCategoryId2").empty().append(data_html);
                            $("#subCategoryId2").val(category_id).change();
                            // $("#subCategoryId2").val(category_id).trigger();
                        } else if (select_category == "3") {
                            $("#subCategoryId3").empty().append(data_html);
                            $("#subCategoryId3").val(category_id).change();
                            // $("#subCategoryId3").val(category_id).trigger();
                        }
                        else if (select_category == "1") {
                            $("#subcategory_id1").empty().append(data_html);
                            $("#subcategory_id1").val(category_id).change();

                            // $("#subcategory_id1").val(category_id).trigger();
                        }
                    }
                });
            } else {
                // Swal.fire("Error", result.msg, "error");
                Swal.fire({
                    title: "Error",
                    text: response.status,
                    icon: "error",
                    timer: 1000, // Set the timer to 1000 milliseconds (1 second)
                    showConfirmButton: false // This will hide the "OK" button
                });
            }
        },
    });
});

$(document).ready(function () {
    $("#create-product-tax-btn").click(function (e) {
        e.preventDefault();
        setTimeout(() => {
            $("#quick_add_product_tax_form").submit();
        }, 500);
    });
});

// $("#create-product-tax-btn").click(function (e){
//     e.preventDefault();
//     setTimeout(()=>{
//         $("#add_product_tax").submit();
//     },500)
// });
$(document).on("submit", "#quick_add_product_tax_form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                Swal.fire({
                    title: `${result.msg}`,
                    type: 'success',
                    icon: 'success',
                    showConfirmButton: false,
                    // confirmButtonText:"حسنا",
                    // confirmButtonColor: '#3085d6',
                    timer: 1000
                });
                $("#add_product_tax_modal").modal("hide");
                var product_tax_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/product-tax/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        console.log(data_html)
                        $("#product_tax").empty().append(data_html);
                        $("#product_tax").val(product_tax_id).change();
                    },
                });
            } else {
                Swal.fire("Error", result.msg, "error");
            }
        },
    });
});
$(document).ready(function () {
    $("#create-customer-btn").click(function (e) {
        e.preventDefault();
        setTimeout(() => {
            $("#quick_add_customer_form").submit();
        }, 500);
    });
});

$(document).on("submit", "#quick_add_customer_form", function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success: function (result) {
            if (result.success) {
                // Swal.fire("Success", result.msg, "success");
                Swal.fire({
                    title: "Success",
                    text: response.status,
                    icon: "success",
                    timer: 1000, // Set the timer to 1000 milliseconds (1 second)
                    showConfirmButton: false // This will hide the "OK" button
                });

                $("#add_customer").modal("hide");
                var customer_id = result.id;
                $.ajax({
                    method: "get",
                    url: "/customer/get-dropdown",
                    data: {},
                    contactType: "html",
                    success: function (data_html) {
                        $("#client_id").empty().append(data_html[0]);
                        $("#client_id").val(data_html[1]).trigger();
                    },
                });
            } else {
                // Swal.fire("Error", result.msg, "error");
                Swal.fire({
                    title: "Error",
                    text: response.status,
                    icon: "error",
                    timer: 1000, // Set the timer to 1000 milliseconds (1 second)
                    showConfirmButton: false // This will hide the "OK" button
                });

            }
        },
    });
});

//category form
