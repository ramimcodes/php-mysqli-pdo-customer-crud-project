<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=customersdb', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}
$result = $pdo->prepare('SELECT * FROM customerInfo WHERE id = :id');
$result->bindValue(':id', $id);
$result->execute();
$data = $result->fetch(PDO::FETCH_ASSOC);

$name = $data['name'];
$address = $data['address'];
$phone = $data['phone'];
$city = $data['city'];
$postal_code = $data['postal_code'];
$country = $data['country'];
$status = $data['status'];;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // collect field data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];
    $status = $_POST['status'];
    if (!empty($name) && !empty($address) && !empty($phone) && !empty($city) && !empty($postal_code) && !empty($country) && !empty($status)) {
        $result = $pdo->prepare("UPDATE customerInfo SET name = :name, address = :address, phone = :phone, city = :city, postal_code = :postal_code, country = :country, status = :status WHERE id = :id");
        $result->bindValue(':name', $name);
        $result->bindValue(':address', $address);
        $result->bindValue(':phone', $phone);
        $result->bindValue(':city', $city);
        $result->bindValue(':postal_code', $postal_code);
        $result->bindValue(':country', $country);
        $result->bindValue(':status', $status);
        $result->bindValue(':id', $id);
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
    <main class="container p-5">
        <h2 class="text-center fw-bold">Update : <?php echo $data['name']; ?> </h1>
            <div class="d-flex justify-content-center">
                <form class="w-50 mt-3" action="" method="POST">
                    <div class="mb-3">
                        <input required type="text" name="name" class="form-control" placeholder="Name" value="<?php echo $name; ?>">
                    </div>
                    <div class="mb-3">
                        <input required type="text" name="address" class="form-control" placeholder="Address" value="<?php echo $address; ?>">
                    </div>
                    <div class="mb-3">
                        <input required type="number" name="phone" class="form-control" placeholder="Phone Number" value="<?php echo $phone; ?>">
                    </div>
                    <div class="mb-3">
                        <input required type="text" name="city" class="form-control" placeholder="City" value="<?php echo $city; ?>">
                    </div>
                    <div class="mb-3">
                        <input required type="number" name="postal_code" class="form-control" placeholder="Postal Code" value="<?php echo $postal_code; ?>">
                    </div>
                    <div class="mb-3">
                        <input required type="text" name="country" class="form-control" placeholder="Country" value="<?php echo $country; ?>">
                    </div>
                    <div class="mb-3">
                        <select name="status" required class="form-select" aria-label="Default select example">
                            <option selected value="<?php echo $status; ?>"><?php echo $data['status']; ?></option>
                            <option value="Platinum">Platinum</option>
                            <option value="Gold">Gold</option>
                            <option value="Silver">Silver</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
    </main>
    <!-- bootstrap javascrip included -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>