<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=customersdb', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$statement = $pdo->prepare('SELECT * FROM customerInfo ORDER BY created_at DESC');
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);


$name = $address = $phone = $city = $postal_code = $country = $status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // collect field data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];
    $status = $_POST['status'];
    $date = date('Y-m-d H:i:s');
    if (!empty($name) && !empty($address) && !empty($phone) && !empty($city) && !empty($postal_code) && !empty($country) && !empty($status)) {
        $result = $pdo->prepare("INSERT INTO customerInfo (name, address, phone, city, postal_code, country, status, created_at)
        VALUES(:name, :address, :phone, :city, :postal_code, :country, :status, :date)");
        $result->bindValue(':name', $name);
        $result->bindValue(':address', $address);
        $result->bindValue(':phone', $phone);
        $result->bindValue(':city', $city);
        $result->bindValue(':postal_code', $postal_code);
        $result->bindValue(':country', $country);
        $result->bindValue(':status', $status);
        $result->bindValue(':date', $date);
        $result->execute();
        header('Location: index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- custom css / app.css -->
    <link rel="stylesheet" href="app.css">
    <title>CUSTOMER CRUD</title>
</head>

<body>
    <main class="container-fluid ps-3 pe-3 pt-5">
        <h2 class="text-center fw-bold">Customer Crud</h1>
            <p class="text-center">this project is store based which is any employee want customer data recevied, update, delete system etc.</p>
            <div>
                <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Create New Customer
                </button>
                <table class="table mt-3 table-striped">
                    <thead>
                        <tr>
                            <th scope="col">CustomerID</th>
                            <th scope="col">CustomerName</th>
                            <th scope="col">Address</th>
                            <th scope="col">PhoneNumber</th>
                            <th scope="col">City</th>
                            <th scope="col">PostalCode</th>
                            <th scope="col">Country</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($data) > 0) : ?>
                            <?php foreach ($data as $i => $customer) : ?>
                                <tr>
                                    <td>
                                        <?php echo $customer['id'] ?? '' ?>
                                    </td>
                                    <td>
                                        <?php echo $customer['name'] ?? ''; ?>
                                    </td>
                                    <td>
                                        <?php echo $customer['address'] ?? ''; ?>
                                    </td>
                                    <td>
                                        <?php echo $customer['phone'] ?? ''; ?>
                                    </td>
                                    <td>
                                        <?php echo $customer['city'] ?? ''; ?>
                                    </td>
                                    <td>
                                        <?php echo $customer['postal_code'] ?? ''; ?>
                                    </td>
                                    <td>
                                        <?php echo $customer['country'] ?? ''; ?>
                                    </td>
                                    <td>
                                        <?php echo $customer['status'] ?? ''; ?>
                                    </td>
                                    <td>
                                        <?php echo $customer['created_at'] ?? ''; ?>
                                    </td>
                                    <td>
                                        <a href="update.php?id=<?php echo $customer['id']; ?>" class="btn btn-sm btn-outline-success">Edit</a>
                                        <form style="display: inline-block;" action="delete.php" method="post">
                                            <input name="id" type="hidden" value="<?php echo $customer['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- modal -->
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Create New Customer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="mb-3">
                                    <input required type="text" name="name" class="form-control" placeholder="Name">
                                </div>
                                <div class="mb-3">
                                    <input required type="text" name="address" class="form-control" placeholder="Address">
                                </div>
                                <div class="mb-3">
                                    <input required type="number" name="phone" class="form-control" placeholder="Phone Number">
                                </div>
                                <div class="mb-3">
                                    <input required type="text" name="city" class="form-control" placeholder="City">
                                </div>
                                <div class="mb-3">
                                    <input required type="number" name="postal_code" class="form-control" placeholder="Postal Code">
                                </div>
                                <div class="mb-3">
                                    <input required type="text" name="country" class="form-control" placeholder="Country">
                                </div>
                                <div class="mb-3">
                                    <select name="status" required class="form-select" aria-label="Default select example">
                                        <option selected>Select Customer Status</option>
                                        <option value="Platinum">Platinum</option>
                                        <option value="Gold">Gold</option>
                                        <option value="Silver">Silver</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    <!-- bootstrap javascrip included -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>