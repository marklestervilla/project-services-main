<?php
include('../admin/authentication.php');
include('config/function.php');

if(isset($_POST['saveAdmin']))
{
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) && $_POST['is_ban'] ? 1 : 0;

    if($name != '' && $email != '' && $password != '' ){
        $emailCheck = mysqli_query($con, "SELECT * FROM admins WHERE email='$email'");
        if($emailCheck){
            if(mysqli_num_rows($emailCheck) > 0){
                redirect('admin.php', 'Email is Already Used.'); 
            }
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrypt_password,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];
        $result = insert('admins', $data);

        if($result){
            redirect('admin.php', 'Admin Created Successfully');
        }else{
            redirect('admin.php', 'Something Went Wrong');
        }

    }
    else
    {
        redirect('admin.php', 'Please fill the required fields');
    }
   
}

if(isset($_POST['updateAdmin']))
{
    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins',$adminId);
    if($adminData['status'] != 200){
        redirect('admin-edit.php?id='.$adminId, 'Please fill the required fields');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1:0;
    
    if($password != ''){
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    }
    else
    {
        $hashedPassword = $adminData['data']['password'];
    }

    if($name != '' && $email != '')
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];
        $result = update('admins', $adminId, $data);

        if($result){
            redirect('admin-edit.php?id='.$adminId.'&success=1', 'Admin Updated Successfully');
        }else{
            redirect('admin-edit.php?id='.$adminId.'&success=0', 'Something Went Wrong');
        }
    }
    else
    {
        redirect('admin-edit.php?id='.$adminId, 'Please fill the required fields');
    }
}

if (isset($_POST['savePOSCategory'])) {
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0;

    // Validate form fields
    if (empty($name) || empty($description)) {
        redirect('category-create.php', 'All fields are mandatory');
        exit();
    }

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    $result = insert('poscategories', $data);

    if ($result) {
        redirect('category.php', 'Category Created Successfully');
    } else {
        redirect('category-create.php', 'Something Went Wrong');
    }
}


if(isset($_POST['updatePOSCategory']))
{
    $categoryId = validate($_POST['categoryId']);

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    $result = update('poscategories', $categoryId, $data);

    if($result){
        redirect('category-edit.php?id='.$categoryId, 'Category Updated Successfully');
    } else {
        redirect('category-edit.php?id='.$categoryId, 'Something Went Wrong');
    }
}


// Category - material id edit modal

if(isset($_GET['category_id']))
{
    $category_id = mysqli_real_escape_string($con, $_GET['category_id']);

    $query = "SELECT * FROM poscategories WHERE id='$category_id' ";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $category = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'message' => 'Category fetch successfully',
            'data' => $category
        ];
        echo json_encode($res);
        return false;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Category ID not Found.'
        ];
        echo json_encode($res);
        return false;
    }
}

// Category - material update modal

if (isset($_POST['update_category'])) {
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $status = isset($_POST['status']) ? 1 : 0;

    if (empty($name) || empty($description)) {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return false;
    }

    $query = "UPDATE poscategories SET name=?, description=?, status=? WHERE id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $description, $status, $category_id);

    if (mysqli_stmt_execute($stmt)) {
        $res = [
            'status' => 200,
            'message' => 'Category Updated Successfully',
            'data' => [
                'id' => $category_id,
                'name' => $name,
                'description' => $description,
                'status' => $status
            ]
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Category Not Updated'
        ];
        echo json_encode($res);
        return false;
    }
}

// Category - material delete modal

if (isset($_GET['delete_category'])) {
    $category_id = mysqli_real_escape_string($con, $_GET['delete_category']);
    
    $query = "DELETE FROM poscategories WHERE id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $category_id);
    
    if (mysqli_stmt_execute($stmt)) {
        redirect('category.php', 'Category Deleted Successfully');
    } else {
        redirect('category.php', 'Failed to Delete Category');
    }
}

if(isset($_POST['saveProduct']))
{
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1:0;

    if($_FILES['image']['size'] > 0)
    {
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); // Fixed typo here

        $filename = time().'.'.$image_ext;

        move_uploaded_file($_FILES['image']['tmp_name'], $path."/".$filename);
        $finalImage = "assets/uploads/products/".$filename;
    }
    else
    {
        $finalImage = '';
    }

    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status
        
    ];
    $result = insert('products', $data);

    if($result){
        redirect('products.php', 'Product Created Successfully');
    }else{
        redirect('products.php', 'Something Went Wrong');
    }
}

if(isset($_POST['updateProduct']))
{
    $product_id = validate($_POST['product_id']);

    $productData = getById('products', $product_id);
    if(!$productData){
        redirect('products.php','No Such Product Found');
    }

    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);

    // Remove non-numeric characters from price
    $price = preg_replace('/[^\d.]/', '', $_POST['price']);
    $price = validate($price);

    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    // Check if a new image file is uploaded
    if ($_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); // Fixed typo here

        $filename = time() . '.' . $image_ext;

        move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $filename);

        $finalImage = "assets/uploads/products/" . $filename;

        // Delete the old image file
        $deleteImage = "../" . $productData['data']['image'];
        if (file_exists($deleteImage)) {
            unlink($deleteImage);
        }
    } else {
        // If no new image file is uploaded, keep the existing image file
        $finalImage = $productData['data']['image'];
    }

    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status
    ];
    $result = update('products', $product_id, $data);

    if ($result) {
        redirect('products-edit.php?user_id=' . $product_id, 'Product Updated Successfully');
    } else {
        redirect('products-edit.php?user_id=' . $product_id, 'Something Went Wrong');
    }
}

// Customer id edit modal
if (isset($_GET['customer_id'])) {
    $customer_id = mysqli_real_escape_string($con, $_GET['customer_id']);

    $query = "SELECT * FROM customers WHERE id='$customer_id' ";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $customer = mysqli_fetch_array($query_run);
        $res = [
            'status' => 200,
            'message' => 'Customer fetched successfully',
            'data' => $customer
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 404,
            'message' => 'Customer ID not found.'
        ];
        echo json_encode($res);
        return;
    }
}

// Customer update modal
if (isset($_POST['update_customer'])) {
    $customer_id = mysqli_real_escape_string($con, $_POST['customer_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $status = isset($_POST['status']) ? 1 : 0;

    if (empty($name) || empty($email) || empty($phone)) {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE customers SET name=?, email=?, phone=?, status=? WHERE id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sssii", $name, $email, $phone, $status, $customer_id);

    if (mysqli_stmt_execute($stmt)) {
        $res = [
            'status' => 200,
            'message' => 'Customer updated successfully',
            'data' => [
                'id' => $customer_id,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'status' => $status
            ]
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Customer not updated'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_POST['saveCustomer']))
{
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1:0;

    if($name != '')
    {
        $emailCheck = mysqli_query($con, "SELECT * FROM customers WHERE email='$email'");
        if($emailCheck){
            if(mysqli_num_rows($emailCheck) > 0){
                redirect('customers.php', 'Email Already used by another user');
            }
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status
        ];

        $result = insert('customers', $data);
        if($result){
	 redirect('customers.php', 'Customer Created Successfully');
        }else{
            redirect('customers.php', 'Something Went Wrong');
 }

    }
    else
    {
        redirect('customers.php', 'Please fill required fields');
    }
}

if(isset($_POST['updateCustomer']))
{
    $customerId = validate($_POST['customerId']);

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1 : 0;

    if($name != '')
    {
        $emailCheck = mysqli_query($con, "SELECT * FROM customers WHERE email='$email' AND id!='$customerId' ");
        if($emailCheck){
            if(mysqli_num_rows($emailCheck) > 0){
                redirect('customers-edit.php?id='.$customerId, 'Email Already used by another user');
            }
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status
        ];

        $result = update('customers', $customerId, $data);
        if($result){
            $_SESSION['status'] = "Customer Updated Successfully";
        } else {
            session_start();
            $_SESSION['status'] = "Customer Update Failed!";
            header("Location: customers.php");
        }
    }
    else
    {
        redirect('customers-edit.php?id='.$customerId, 'Please fill required fields');
    }
}

?>