<?php
    include_once __DIR__.'/../config.php';
?>

<ul class="sidebar-menu" id="sidebar-menu">
  <!-- Dashboard -->
  <li>
    <a href="<?php echo ADMIN_BASE_URL; ?>/pages/dashboard.php">
      <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
      <span>Dashboard</span>
    </a>
  </li>

  <!-- Management Group -->
  <li class="sidebar-menu-group-title">Management</li>

  <!-- Contacts -->
<li>
    <a href="<?php echo ADMIN_BASE_URL; ?>/pages/contacts/index.php">
      <iconify-icon icon="mdi:account-box" class="menu-icon"></iconify-icon>
      <span>Contacts</span>
    </a>
</li>

  <!-- Categories -->
  <li class="dropdown">
    <a href="javascript:void(0)">
      <iconify-icon icon="mdi:shape" class="menu-icon"></iconify-icon>
      <span>Categories</span>
    </a>
    <ul class="sidebar-submenu">
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/categories/index.php">
          <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
          List Categories
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/categories/create.php">
          <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
          Create Category
        </a>
      </li>
      <!-- <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/categories/edit.php">
          <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
          Edit Category
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/categories/delete.php">
          <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
          Delete Category
        </a>
      </li> -->
    </ul>
  </li>


  <!-- <li class="dropdown">
    <a href="javascript:void(0)">
      <iconify-icon icon="mdi:account-box" class="menu-icon"></iconify-icon>
      <span>Contacts</span>
    </a>
    <ul class="sidebar-submenu">
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/contacts/index.php">
          <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
          List Contacts
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/contacts/create.php">
          <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
          Create Contact
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/contacts/edit.php">
          <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
          Edit Contact
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/contacts/delete.php">
          <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
          Delete Contact
        </a>
      </li>
    </ul>
  </li> -->

  <!-- Products Group Title -->
  <li class="sidebar-menu-group-title">Products</li>

  <!-- Main Products -->
  <li class="dropdown">
    <a href="javascript:void(0)">
      <iconify-icon icon="mdi:shopping" class="menu-icon"></iconify-icon>
      <span>Products</span>
    </a>
    <ul class="sidebar-submenu">
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/products/index.php">
          <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
          List Products
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/products/create.php">
          <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
          Create Product
        </a>
      </li>
      <!-- <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/products/edit.php">
          <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
          Edit Product
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/products/delete.php">
          <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
          Delete Product
        </a>
      </li> -->
    </ul>
  </li>

  <!-- Product Details -->
  <li class="dropdown">
    <a href="javascript:void(0)">
      <span>Product Details</span>
    </a>
    <ul class="sidebar-submenu">
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/product_details/index.php">
          <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
          List Details
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/product_details/create.php">
          <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
          Create Detail
        </a>
      </li>
      <!-- <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/product_details/edit.php">
          <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
          Edit Detail
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/product_details/delete.php">
          <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
          Delete Detail
        </a>
      </li> -->
    </ul>
  </li>

  <!-- Product Images -->
  <li class="dropdown">
    <a href="javascript:void(0)">
      <span>Product Images</span>
    </a>
    <ul class="sidebar-submenu">
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/product_images/index.php">
          <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
          List Images
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/product_images/create.php">
          <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
          Create Image
        </a>
      </li>
      <!-- <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/product_images/edit.php">
          <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
          Edit Image
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/product_images/delete.php">
          <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
          Delete Image
        </a>
      </li> -->
    </ul>
  </li>

  <!-- Product Reviews (single link) -->
  <li>
    <a href="<?php echo ADMIN_BASE_URL; ?>/pages/product_reviews/index.php">
      <iconify-icon icon="mdi:star-outline" class="menu-icon"></iconify-icon>
      <span>Product Reviews</span>
    </a>
  </li>

  <!-- Management Group -->
  <li class="sidebar-menu-group-title">Orders</li>

<!-- Customers -->
  
<li>
    <a href="<?php echo ADMIN_BASE_URL; ?>/pages/customers/index.php">
        <iconify-icon icon="mdi:account-multiple" class="menu-icon"></iconify-icon>
        <span>Customers</span>
    </a>
</li>

<li>
  <a href="<?php echo ADMIN_BASE_URL; ?>/pages/orders/index.php">
    <iconify-icon icon="mdi:cart-outline" class="menu-icon"></iconify-icon>
    <span>Orders</span>
  </a>
</li>

<li>
    <a href="<?php echo ADMIN_BASE_URL; ?>/pages/shipping_details/index.php">
        <iconify-icon icon="mdi:note" class="menu-icon"></iconify-icon>
        <span>Shipping Details</span>
    </a>
</li>

  <!-- <li class="dropdown">
    <a href="javascript:void(0)">
      <iconify-icon icon="mdi:account-multiple" class="menu-icon"></iconify-icon>
      <span>Customers</span>
    </a>
    <ul class="sidebar-submenu">
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/customers/index.php">
          <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
          Customers
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/customers/create.php">
          <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
          Create Customer
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/customers/edit.php">
          <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
          Edit Customer
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/customers/delete.php">
          <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
          Delete Customer
        </a>
      </li>
    </ul>
  </li> -->

  <!-- Orders -->
  <!-- <li class="dropdown">
    <a href="javascript:void(0)">
      <iconify-icon icon="mdi:cart-outline" class="menu-icon"></iconify-icon>
      <span>Orders</span>
    </a>
    <ul class="sidebar-submenu">
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/orders/index.php">
          <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
          List Orders
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/orders/create.php">
          <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
          Create Order
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/orders/edit.php">
          <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
          Edit Order
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/orders/delete.php">
          <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
          Delete Order
        </a>
      </li>
    </ul>
  </li> -->

  <!-- Order Details -->
  <!-- <li class="dropdown">
    <a href="javascript:void(0)">
      <iconify-icon icon="mdi:details" class="menu-icon"></iconify-icon>
      <span>Order Details</span>
    </a>
    <ul class="sidebar-submenu">
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/order_details/index.php">
          <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
          List Details
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/order_details/create.php">
          <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
          Create Detail
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/order_details/edit.php">
          <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
          Edit Detail
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/order_details/delete.php">
          <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
          Delete Detail
        </a>
      </li>
    </ul>
  </li> -->

  <!-- Shipping Details -->
  <!-- <li class="dropdown">
    <a href="javascript:void(0)">
      <iconify-icon icon="mdi:truck-outline" class="menu-icon"></iconify-icon>
      <span>Shipping Details</span>
    </a>
    <ul class="sidebar-submenu">
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/shipping_details/index.php">
          <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
          List Shipping
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/shipping_details/create.php">
          <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
          Create Shipping
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/shipping_details/edit.php">
          <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
          Edit Shipping
        </a>
      </li>
      <li>
        <a href="<?php echo ADMIN_BASE_URL; ?>/pages/shipping_details/delete.php">
          <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
          Delete Shipping
        </a>
      </li>
    </ul>
  </li> -->

  <!-- Management Group -->
  <li class="sidebar-menu-group-title">Settings</li>

  <!-- Settings -->
  <li>
    <a href="<?php echo ADMIN_BASE_URL; ?>/pages/settings/setting.php">
      <iconify-icon icon="mdi:cog-outline" class="menu-icon"></iconify-icon>
      <span>Settings</span>
    </a>
  </li>


</ul>