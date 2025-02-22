<?php
include('../config/function.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
?>
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                     <!--cart start--> 
                     <div class="card">
                                <div class="card-header">
                                <input type="text" id="barcode" class="form-control" placeholder="Scan or enter barcode">
                                <br>
                                <input type="text" id="search_product" class="form-control" placeholder="Search product by name">
                                <div id="suggestions" class="list-group"></div> 
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cart-body">
                                        <!-- Cart items will be added here -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                            <button id="checkout" class="btn btn-success">Checkout</button>
                            </div>
                        </div>
                        </div>
                     <!--cart end-->
                </div>
            </section>
        </div>
        
<?php include('includes/footer.php'); ?>

<script>
       $(document).ready(function () {
    $("#barcode").on("keypress", function (e) {
        if (e.which == 13) { // Enter key pressed
            let barcode = $(this).val();
            $.ajax({
                url: "fetch_product.php",
                method: "POST",
                data: { barcode: barcode },
                dataType: "json",
                success: function (response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        addToCart(response.product_id, response.product_name, response.price);
                    }
                }
            });
            $(this).val(""); // Clear input
        }
    });

    //search start
         // Product search with suggestions
    $("#search_product").on("keyup", function () {
        let query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: "search_product.php",
                method: "POST",
                data: { query: query },
                dataType: "json",
                success: function (response) {
                    let suggestions = $("#suggestions");
                    suggestions.empty();
                    response.forEach(product => {
                        suggestions.append(`<a href="#" class="list-group-item list-group-item-action product-item" 
                            data-id="${product.product_id}" 
                            data-name="${product.product_name}" 
                            data-price="${product.price}">${product.product_name} - ${product.price}</a>`);
                    });
                }
            });
        } else {
            $("#suggestions").empty();
        }
    });

    // Select product from search results
    $(document).on("click", ".product-item", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        let name = $(this).data("name");
        let price = $(this).data("price");
        
        addToCart(id, name, price);
        $("#search_product").val("");
        $("#suggestions").empty();
    });
    //search end

    function addToCart(product_id, product_name, price) {
        let row = `<tr data-id="${product_id}">
            <td>${product_name}</td>
            <td>${price}</td>
            <td><input type="number" class="qty" value="1" min="1"></td>
            <td class="subtotal">${price}</td>
            <td><button class="remove btn btn-danger">X</button></td>
        </tr>`;
        $("#cart-body").append(row);
    }

    // Update subtotal when quantity changes
    $(document).on("input", ".qty", function () {
        let qty = $(this).val();
        let price = $(this).closest("tr").find("td:nth-child(2)").text();
        $(this).closest("tr").find(".subtotal").text((qty * price).toFixed(2));
    });

    // Remove item from cart
    $(document).on("click", ".remove", function () {
        $(this).closest("tr").remove();
    });


    // SUBMIT CART
    $("#checkout").click(function () {
    let cart = [];

    $("#cart-body tr").each(function () {
        let id = $(this).data("id");
        let name = $(this).find("td:nth-child(1)").text();
        let price = parseFloat($(this).find("td:nth-child(2)").text());
        let qty = parseInt($(this).find(".qty").val());
        let subtotal = parseFloat($(this).find(".subtotal").text());

        cart.push({ id, name, price, qty, subtotal });
    });

    $.ajax({
        url: "checkout.php",
        method: "POST",
        data: { cart: cart },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                alert(response.success);
                $("#cart-body").empty(); // Clear cart
            } else {
                alert(response.error);
            }
        }
    });
});

});

</script>