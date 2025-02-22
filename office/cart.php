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
                                <h3>Total: $<span id="grand-total">0.00</span></h3>
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
        loadCart();
        function loadCart() {
        renderCart(); // Load cart from localStorage when page refreshes
    }

        $("#barcode").on("keypress", function (e) {
            if (e.which == 13) {
                let barcode = $(this).val();
                fetchProduct(barcode);
                $(this).val("");
            }
        });

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
                            suggestions.append(`<a href="#" class="list-group-item product-item" 
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

        $(document).on("click", ".product-item", function (e) {
            e.preventDefault();
            let id = $(this).data("id");
            let name = $(this).data("name");
            let price = $(this).data("price");

            addToCart(id, name, price);
            $("#search_product").val("");
            $("#suggestions").empty();
        });

        function fetchProduct(barcode) {
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
        }

        function addToCart(product_id, product_name, price) {
            let cart = getCart();
            let existingItem = cart.find(item => item.product_id == product_id);

            if (existingItem) {
                existingItem.qty++;
               
            } else {
                cart.push({ product_id:product_id,
                     product_name: product_name, 
                     price: price, qty: 1 
                    });
            }

            saveCart(cart);
            renderCart();
        }

        function renderCart() {
            let cart = getCart();
            $("#cart-body").empty();

            cart.forEach(item => {
                let row = `<tr data-id="${item.product_id}">
                    <td>${item.product_name}</td>
                    <td>${item.price}</td>
                    <td><input type="number" class="qty" value="${item.qty}" min="1"></td>
                    <td class="subtotal">${(item.price * item.qty).toFixed(2)}</td>
                    <td><button class="remove btn btn-danger">X</button></td>
                </tr>`;
                $("#cart-body").append(row);
            });
            updateTotal(); // Call function to update grand total
        }

        function getCart() {
            return JSON.parse(localStorage.getItem("cart")) || [];
        }

        function saveCart(cart) {
            localStorage.setItem("cart", JSON.stringify(cart));
        }

        renderCart();

        $(document).on("input", ".qty", function () {
            let cart = getCart();
            let id = $(this).closest("tr").data("id");
            let qty = parseInt($(this).val());

            let item = cart.find(item => item.product_id == id);
            if (item) {
                item.qty = qty;
            }

            saveCart(cart);
            renderCart();
        });

        $(document).on("click", ".remove", function () {
            let cart = getCart();
            let id = $(this).closest("tr").data("id");

            cart = cart.filter(item => item.product_id != id);
            saveCart(cart);
            renderCart();
        });

        $("#checkout").click(function () {
            let cart = getCart();

            $.post("checkout.php", { cart: JSON.stringify(cart) }, function (response) {
                alert(response.success || response.error);
                localStorage.removeItem("cart");
                renderCart();
            }, "json");
        });

function updateTotal() {
    let cart = getCart();
    let total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    $("#grand-total").text(total.toFixed(2));
}

    });
   


</script>