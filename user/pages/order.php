<?php
    include_once '../include/user.php';

    if (!$user_logged_in) {
        header("Location: /user/pages/login.php?ref=/user/pages/order.php");
        die();
    }
    
    $user_id = $user['id']; // Current user's ID

    $query = "
        SELECT 
            o.id AS order_id,
            o.order_num,
            DATE_FORMAT(o.created_at, '%d : %m : %Y') AS order_date,
            (SELECT SUM(qty) FROM order_details WHERE order_id = o.id) AS total_items,
            o.sub_total,
            o.status
        FROM orders o
        WHERE o.customer_id = ?
        ORDER BY o.created_at DESC
    ";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $orders = [];

    while ($order = mysqli_fetch_assoc($result)) {
        $orders[] = $order;
    }
?>

<!DOCTYPE html>
<html lang="en" class="js no-touch cssanimations csstransitions">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wpOceans">
    <link rel="shortcut icon" type="image/png" href="https://wpocean.com/html/tf/pengu/assets/images/favicon.png">
    <title>My Orders - Draftsy</title>
    <?php
        include('../include/styles.php');
    ?>
    <style type="text/css">.fancybox-margin{margin-right:17px;}</style>
</head>

<body>

    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <!-- start preloader -->
        <div class="preloader" style="display: none;">
            <div class="vertical-centered-box">
                <div class="content">
                    <div class="loader-circle"></div>
                    <div class="loader-line-mask">
                        <div class="loader-line"></div>
                    </div>
                    <img src="./order_files/preloader.png" alt="">
                </div>
            </div>
        </div>
        <!-- end preloader -->

        <!-- Start header -->
        <?php
        include('../include/header.php');
        ?>
        <br>
        <br>
        <br>
        <br>
        <!-- end of header -->

        <!-- start wpo-page-title -->
        <section class="wpo-page-title">
            <div class="container">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="wpo-breadcumb-wrap">
                            <h2>Orders</h2>
                            <ol class="wpo-breadcumb-wrap">
                                <li><a href="/user/pages/index.php">Home</a></li>
                                <li>Orders</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- cart-area start -->
        <div class="cart-area section-padding">
            <div class="container">
                <?php if (!$orders) { ?>
                    <div class="container text-center py-5">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="card shadow-sm p-4">
                                    <h3 class="text-muted">No Orders Yet</h3>
                                    <p class="text-secondary">Looks like you haven't placed any orders yet.</p>
                                    <a href="/user/pages/shop.php" class="btn btn-primary">Go to Store</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="form" style="display: <?= (!$orders) ? 'none' : 'auto' ?>">
                    <div class="cart-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <form action="">
                                    <table class="table-responsive cart-wrap">
                                        <thead>
                                            <tr>
                                                <th class="images images-b">Order ID</th>
                                                <th class="product">Date</th>
                                                <th class="ptice">Total Items</th>
                                                <th class="ptice">Ship To</th>
                                                <th class="">Total Price</th>
                                                <th class="remove">Status</th>
                                                <th class="action remove-b">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orders as $order) { ?>
                                                <?php
                                                    $status = strtolower($order['status']) ?? null;
                                                    $status_code = ['delivered' => 'Del', 'pending' => 'stocks', 'cancelled' => 'can', 'processing' => 'pro', 'shipped' => 'pro',];
                                                ?>
                                                <tr>
                                                    <td class="images"># <?= htmlspecialchars($order['order_num']); ?></td>
                                                    <td class="product"><?= htmlspecialchars($order['order_date']); ?></td>
                                                    <td class="qty"><?= htmlspecialchars($order['total_items']); ?></td>
                                                    <td class="name"><?= htmlspecialchars($user['name']); ?></td>
                                                    <td class="price">$ <?= number_format($order['sub_total'], 2); ?></td>
                                                    <td class="text-capitalize <?= $status_code[$status] ?? '' ?>">
                                                        <span><?= htmlspecialchars($status) ?></span>
                                                    </td>

                                                    <td class="action">
                                                        <ul>
                                                            <li class="w-btn-view"><a data-bs-toggle="tooltip" data-bs-html="true" title="" href="/user/pages/order_details.php?order_id=<?= $order['order_id'] ?>" data-bs-original-title="View" aria-label="View"><i class="fi ti-eye"></i></a></li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <!-- <tr>
                                                <td class="images"># 8976A</td>
                                                <td class="product">05 : 08 : 2023</td>
                                                <td class="ptice">06</td>
                                                <td class="name">Alex Genderia</td>
                                                <td class="">$ 450</td>
                                                <td class="Del"><span>Delivered</span></td>
                                                <td class="action">
                                                    <ul>
                                                        <li class="w-btn-view"><a data-bs-toggle="tooltip" data-bs-html="true" title="" href="https://wpocean.com/html/tf/pengu/order.html#" data-bs-original-title="View" aria-label="View"><i class="fi ti-eye"></i></a></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="images"># 8976A</td>
                                                <td class="product">05 : 08 : 2023</td>
                                                <td class="ptice">06</td>
                                                <td class="name">Alex Genderia</td>
                                                <td class="">$ 450</td>
                                                <td class="stock"><span>Pending</span></td>
                                                <td class="action">
                                                    <ul>
                                                        <li class="w-btn-view"><a data-bs-toggle="tooltip" data-bs-html="true" title="" href="https://wpocean.com/html/tf/pengu/order.html#" data-bs-original-title="View" aria-label="View"><i class="fi ti-eye"></i></a></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="images"># 8976A</td>
                                                <td class="product">05 : 08 : 2023</td>
                                                <td class="ptice">06</td>
                                                <td class="name">Alex Genderia</td>
                                                <td class="">$ 450</td>
                                                <td class="stocks"><span>Pending</span></td>
                                                <td class="action">
                                                    <ul>
                                                        <li class="w-btn-view"><a data-bs-toggle="tooltip" data-bs-html="true" title="" href="https://wpocean.com/html/tf/pengu/order.html#" data-bs-original-title="View" aria-label="View"><i class="fi ti-eye"></i></a></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="images"># 8976A</td>
                                                <td class="product">05 : 08 : 2023</td>
                                                <td class="ptice">06</td>
                                                <td class="name">Alex Genderia</td>
                                                <td class="">$ 450</td>
                                                <td class="can"><span>Canceled</span></td>
                                                <td class="action">
                                                    <ul>
                                                        <li class="w-btn-view"><a data-bs-toggle="tooltip" data-bs-html="true" title="" href="https://wpocean.com/html/tf/pengu/order.html#" data-bs-original-title="View" aria-label="View"><i class="fi ti-eye"></i></a></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="images"># 8976A</td>
                                                <td class="product">05 : 08 : 2023</td>
                                                <td class="ptice">06</td>
                                                <td class="name">Alex Genderia</td>
                                                <td class="">$ 450</td>
                                                <td class="pro"><span>Processing</span></td>
                                                <td class="action">
                                                    <ul>
                                                        <li class="w-btn-view"><a data-bs-toggle="tooltip" data-bs-html="true" title="" href="https://wpocean.com/html/tf/pengu/order.html#" data-bs-original-title="View" aria-label="View"><i class="fi ti-eye"></i></a></li>
                                                    </ul>
                                                </td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-area end -->

        <!-- start of wpo-site-footer-section -->
        <?php
    include('../include/footer.php');
    ?>
        <!-- end of wpo-site-footer-section -->


    </div>
    <!-- end of page-wrapper -->

    <?php
    include('../include/scripts.php');
    ?>


</body></html>