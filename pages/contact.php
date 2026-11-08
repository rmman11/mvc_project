


<?php



if ($_SERVER['REQUEST_METHOD'] === 'POST') {



  global $db;
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (
        $name === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        $subject === '' ||
        $message === ''
    ) {
        $_SESSION['error'] = "Please fill in all fields correctly.";
        header("Location: index.php?page=contact");
        exit;
    }

    try {

        $sql = "INSERT INTO contacts
                (name, email, subject, message)
                VALUES (:name, :email, :subject, :message)";

        $stmt = $db->prepare($sql);

        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':subject' => $subject,
            ':message' => $message
        ]);

        $_SESSION['success'] = "Your message was sent successfully!";

    } catch (PDOException $e) {

        $_SESSION['error'] = "Something went wrong. Please try again.";

    }
    header("Location: index.php?page=contact");
    exit;
}


?>

    <style>
        .contact-form {
            max-width: 500px;
        
            background: #f5f5f5;
            border-radius: 10px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            cursor: pointer;
        }
    </style>


<div class="contact-form">

    <h2>Contact Us</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <p style="color:green">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <p style="color:red">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="" method="POST">

        <input type="text" name="name"
               placeholder="Your Name" required>

        <input type="email" name="email"
               placeholder="Your Email" required>

        <input type="text" name="subject"
               placeholder="Subject" required>

        <textarea name="message"
                  placeholder="Your Message"
                  rows="6" required></textarea>

        <button type="submit" name="send">
            Send Message
        </button>

    </form>

</div>

