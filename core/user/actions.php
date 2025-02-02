<?php
session_start();
class Actions
{
    private $db;

    public function __construct()
    {
        ob_start();
        include 'db_connect.php';
        $this->db = $conn;
    }

    function __destruct()
    {
        $this->db->close();
        ob_end_flush();
    }

    // LOGIN
    function login()
    {

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            return 3;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 3;
        }

        $hashed_password = md5($password);

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $hashed_password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            foreach ($row as $key => $value) {
                if ($key != 'passwors' && !is_numeric($key))
                    $_SESSION['login_' . $key] = $value;
            }
            $stmt->close();
            return 1;
        } else {
            $stmt->close();
            return 3;
        }
    }

    // LOGOUT
    function logout()
    {
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location:../../");
    }

    // REGISTER
    function register()
    {

        $name       = trim($_POST['name'] ?? '');
        $email      = trim($_POST['email'] ?? '');
        $phone      = trim($_POST['phone'] ?? '');
        $address    = trim($_POST['address'] ?? '');
        $password   = trim($_POST['password'] ?? '');
        $c_password = trim($_POST['c_password'] ?? '');

        if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($password) || empty($c_password)) {
            return 4; // Required fields missing
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 5; // Invalid email format
        }
        if ($password != $c_password) {
            return 3; // Password mismatch
        }

        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? OR phone = ?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return 2; // User already exists
        }
        $stmt->close();

        $hashed_password = md5($password);
        $type = 2; // User type as in original code

        $stmt = $this->db->prepare("INSERT INTO users (name, email, phone, address, password, type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $name, $email, $phone, $address, $hashed_password, $type);
        if ($stmt->execute()) {
            $stmt->close();

            // Auto-login the user after registration
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
            $stmt->bind_param("ss", $email, $hashed_password);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                foreach ($row as $key => $value) {
                    if ($key != 'passwors' && !is_numeric($key))
                        $_SESSION['login_' . $key] = $value;
                }
            }
            $stmt->close();
            return 1;
        } else {
            $stmt->close();
            return 0; // Database error
        }
    }

    // SAVE BOOKING
    function save_booking()
    {
        $event_id = trim($_POST['event_id'] ?? '');
        $name     = trim($_POST['name'] ?? '');
        $address  = trim($_POST['address'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $status   = isset($_POST['status']) ? trim($_POST['status']) : 1;
        $id       = trim($_POST['id'] ?? '');

        if (empty($event_id) || empty($name) || empty($address) || empty($email) || empty($phone)) {
            return 0;
        }

        $stmt = $this->db->prepare("SELECT * FROM audience where event_id = ?");
        $stmt->bind_param("i",$event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $registered_audience = $result->num_rows;


        $stmt = $this->db->prepare("SELECT * FROM events where id = ?");
        $stmt->bind_param("i",$event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        $audience_capacity =  $row['audience_capacity'];

        if ($registered_audience >= $audience_capacity) {
            return 2;
        }


        if (empty($id)) {
            $stmt = $this->db->prepare("INSERT INTO audience (event_id, name, address, email, phone, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssss", $event_id, $name, $address, $email, $phone, $status);
        } else {
            $stmt = $this->db->prepare("UPDATE audience SET event_id = ?, name = ?, address = ?, email = ?, phone = ?, status = ? WHERE id = ?");
            $stmt->bind_param("isssssi", $event_id, $name, $address, $email, $phone, $status, $id);
        }
        $result = $stmt->execute();
        $stmt->close();
        return $result ? 1 : 0;
    }

    // SAVE REGISTER
    function save_register()
    {
        $event_id       = trim($_POST['event_id'] ?? '');
        $name           = trim($_POST['name'] ?? '');
        $address        = trim($_POST['address'] ?? '');
        $email          = trim($_POST['email'] ?? '');
        $contact        = trim($_POST['contact'] ?? '');
        $status         = isset($_POST['status']) ? trim($_POST['status']) : '';
        $payment_status = isset($_POST['payment_status']) ? trim($_POST['payment_status']) : '0';
        $id             = trim($_POST['id'] ?? '');

        if (empty($event_id) || empty($name) || empty($address) || empty($email) || empty($contact)) {
            return 0;
        }

        if (empty($id)) {
            $stmt = $this->db->prepare("INSERT INTO audience (event_id, name, address, email, contact, status, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssss", $event_id, $name, $address, $email, $contact, $status, $payment_status);
        } else {
            $stmt = $this->db->prepare("UPDATE audience SET event_id = ?, name = ?, address = ?, email = ?, contact = ?, status = ?, payment_status = ? WHERE id = ?");
            $stmt->bind_param("issssssi", $event_id, $name, $address, $email, $contact, $status, $payment_status, $id);
        }
        $result = $stmt->execute();
        $stmt->close();
        return $result ? 1 : 0;
    }

    // SAVE EVENT
    function save_event()
    {
        $id                = trim($_POST['id'] ?? '');
        $user_id           = trim($_SESSION['login_id'] ?? '');
        $name              = trim($_POST['name'] ?? '');
        $venue_name        = trim($_POST['venue_name'] ?? '');
        $address           = trim($_POST['address'] ?? '');
        $schedule          = trim($_POST['schedule'] ?? '');
        $audience_capacity = trim($_POST['audience_capacity'] ?? '');
        $payment_type      = isset($_POST['payment_status']) ? trim($_POST['payment_status']) : '2';
        $type              = isset($_POST['type']) ? trim($_POST['type']) : '1';
        $attendance_fees   = trim($_POST['attendance_fees'] ?? '');
        $description       = htmlentities(str_replace("'", "&#x2019;", $_POST['description'] ?? ''));
        $banner            = '';

        // Handle banner file upload if available
        if (isset($_FILES['banner']) && $_FILES['banner']['tmp_name'] != '') {
            $_FILES['banner']['name'] = str_replace(array("(", ")", " "), '', $_FILES['banner']['name']);
            $fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['banner']['name'];
            if (move_uploaded_file($_FILES['banner']['tmp_name'], '../../assets/uploads/' . $fname)) {
                $banner = $fname;
            }
        }

        // Insertion
        if (empty($id)) {
            $stmt = $this->db->prepare("INSERT INTO events ( user_id, name, venue_name, address, schedule, audience_capacity, payment_type, type, attendance_fees, description, banner) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssisssss", $user_id, $name, $venue_name, $address, $schedule, $audience_capacity, $payment_type, $type, $attendance_fees, $description, $banner);
            $save = $stmt->execute();
            $stmt->close();

            if ($save) {
                $id = $this->db->insert_id;
                $this->handle_event_images($id);
            }
        } else {
            if ($banner != '') {
                $stmt = $this->db->prepare("UPDATE events SET name = ?, venue_name = ?, address = ?, schedule = ?, audience_capacity = ?, payment_type = ?, type = ?, attendance_fees = ?, description = ?, banner = ? WHERE id = ? AND user_id = ?");
                $stmt->bind_param("ssssisssssii", $name, $venue_name, $address, $schedule, $audience_capacity, $payment_type, $type, $attendance_fees, $description, $banner, $id, $user_id);
            } else {
                $stmt = $this->db->prepare("UPDATE events SET name = ?, venue_name = ?, address = ?, schedule = ?, audience_capacity = ?, payment_type = ?, type = ?, attendance_fees = ?, description = ? WHERE id = ? AND user_id = ?");
                $stmt->bind_param("ssssissssii", $name, $venue_name, $address, $schedule, $audience_capacity, $payment_type, $type, $attendance_fees, $description, $id, $user_id);
            }
            $save = $stmt->execute();
            $stmt->close();
            if ($save) {
                $this->handle_event_images($id);
            }
        }   
        return $save ? 1 : 0;
    }

    // Helper function to process event image uploads
    private function handle_event_images($id)
    {
        $folder = "../../assets/uploads/event_" . $id;
    
        // Create folder if not exists
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        } else {
            $files = scandir($folder);
            foreach ($files as $file) {
                if (!in_array($file, array('.', '..'))) {
                    unlink($folder . "/" . $file);
                }
            }
        }
    
        if (isset($_POST['img']) && isset($_POST['imgName'])) {
            $imgs = $_POST['img'];
            $imgNames = $_POST['imgName'];

            $allowedTypes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp'
            ];
    
            for ($i = 0; $i < count($imgs); $i++) {
                $imgData = str_replace('data:image/jpeg;base64,', '', $imgs[$i]);
                $imgData = base64_decode($imgData);
    
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_buffer($finfo, $imgData);
                finfo_close($finfo);
    
                $originalExt = strtolower(pathinfo($imgNames[$i], PATHINFO_EXTENSION));
    
                if (!array_key_exists($mimeType, $allowedTypes) || $allowedTypes[$mimeType] !== $originalExt) {
                    continue;
                }
    
                $fname = $id . "_" . time() . "_" . bin2hex(random_bytes(5)) . "." . $originalExt;
    
                file_put_contents($folder . "/" . $fname, $imgData);
            }
        }
    }
    

    // DELETE EVENT
    function delete_event()
    {
        $id = trim($_POST['id'] ?? '');
        $stmt = $this->db->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result ? 1 : 0;
    }

    // GET AUDIENCE REPORT
    function get_audience_report()
    {
        $event_id = trim($_POST['event_id'] ?? '');
        $data = array();
        $stmt = $this->db->prepare("SELECT * FROM audience WHERE event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $data['data'][] = $row;
        }
        $stmt->close();
        return json_encode($data);
    }

    // DOWNLOAD AUDIENCE REPORT AS CSV
    function download_audience_report()
    {
        $event_id = trim($_POST['event_id'] ?? '');
        $data = [];
        $stmt = $this->db->prepare("SELECT * FROM audience WHERE event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="audience_report.csv"');
        $output = fopen('php://output', 'w');
        if (!empty($data)) {
            fputcsv($output, array_keys($data[0])); // Column headers
        }
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }
}
