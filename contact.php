<!DOCTYPE html>
<html>
<head>
    <title>Contact us</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
    <style>
        /* Original Styling and CSS */
        body{
            height: 100vh;
            width: 100%;
        }

        .container{
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 100px;
        }

        .container:after{
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            filter: blur(50px);
            z-index: -1;
        }
        .contact-box{
            max-width: 850px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            justify-content: center;
            align-items: center;
            text-align: center;
            background-color: #fff;
            box-shadow: 0px 0px 19px 5px rgba(0,0,0,0.19);
        }

        .left{
            background: url("bg.jpg") no-repeat center;
            background-size: cover;
            height: 100%;
        }

        .right{
            padding: 25px 40px;
        }

        h2{
            position: relative;
            padding: 0 0 10px;
            margin-bottom: 10px;
        }

        .field{
            width: 100%;
            border: 2px solid rgba(0, 0, 0, 0);
            outline: none;
            background-color: rgba(230, 230, 230, 0.6);
            padding: 0.5rem 1rem;
            font-size: 1.1rem;
            margin-bottom: 22px;
            transition: .3s;
        }

        .field:hover{
            background-color: rgba(0, 0, 0, 0.1);
        }

        textarea{
            min-height: 150px;
        }

        .btns{
            width: 100%;
            padding: 0.5rem 1rem;
            background-color: #333333;
            color: #fff;
            font-size: 1.1rem;
            border: none;
            outline: none;
            cursor: pointer;
            transition: .3s;
        }

        .btns:hover{
            background-color: #27ae60;
        }

        .field:focus{
            border: 2px solid rgba(30,85,250,0.47);
            background-color: #fff;
        }

        .animate {
            -webkit-animation: animatezoom 0.6s;
            animation: animatezoom 0.6s
        }

        @-webkit-keyframes animatezoom {
            from {-webkit-transform: scale(0)}
            to {-webkit-transform: scale(1)}
        }

        @keyframes animatezoom {
            from {transform: scale(0)}
            to {transform: scale(1)}
        }

        @media screen and (max-width: 880px){
            .contact-box{
                grid-template-columns: 1fr;
            }
            .left{
                height: 200px;
            }
        }

    </style>
</head>
<body>
    <?php 
    require 'header.php'; // Include the header
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Include the database connection file
        include('db.php'); 

        // Get form data and sanitize it
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $message = mysqli_real_escape_string($con, $_POST['message']);

        // SQL query to insert data into tbl_contact
        $query = "INSERT INTO tbl_contact (name, email, phone, message) 
                  VALUES ('$name', '$email', '$phone', '$message')";

        // Execute the query
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Your message has been sent successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
    ?>

    <form class="modal-content animate" action="contact.php" method="post">
        <div class="container">
            <div class="contact-box">
                <div class="left"></div>
                <div class="right">
                    <h2>Contact Us</h2>
                    <input type="text" class="field" name="name" placeholder="Your Name" required pattern="^[a-zA-Z\s]+$" title="Name should contain only letters and spaces">
                    <input type="email" class="field" name="email" placeholder="Your Email" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com)$">
                    <input type="number" class="field" name="phone" placeholder="Phone" required>
                    <textarea name="message" placeholder="Message" class="field" required></textarea>
                    <button class="btns" type="submit">Send</button>
                </div>
            </div>
        </div>
    </form>

    <?php require 'footer.php'; // Include the footer ?>
</body>
</html>
