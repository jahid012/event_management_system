<?php
include 'user/db_connect.php';
?>
<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <form role="search" method="get" class="search-form form" action="">
                    <label>
                        <span class="screen-reader-text">Search for...</span>
                        <input type="search" class="search-field" placeholder="Type Here..." value="<?php echo isset($_GET['s']) ? trim($_GET['s']) : ''; ?>" name="s" title="" />
                    </label>
                    <input type="submit" class="search-submit button" value="Search" />
                </form>
                <div class="col-md-12 mb-2 justify-content-center">
                </div>
            </div>

        </div>
    </div>
</header>
<div class="container mt-3 pt-2">
    <h4 class="text-center">Latest Events</h4>
    <hr class="divider">
    <?php
    $limit = 3; // Number of events per page
    $search = isset($_GET['s']) ? trim($_GET['s']) : '';
    $page = isset($_GET['p']) ? (int) $_GET['p'] : 1;
    $offset = ($page - 1) * $limit;

    // Base query
    $sql = "SELECT * FROM events WHERE DATE_FORMAT(schedule, '%Y-%m-%d') >= ? AND type = 1";
    $params = [date('Y-m-d')];
    $types = "s";

    // Search condition
    if (!empty($search)) {
        $sql .= " AND (name LIKE ? OR address LIKE ? OR description LIKE ? OR venue_name LIKE ?)";
        $searchTerm = "%$search%";
        array_push($params, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        $types .= "ssss";
    }

    //Count total events for pagination
    $count_sql = str_replace("SELECT *", "SELECT COUNT(*) as total", $sql);
    $count_stmt = $conn->prepare($count_sql);
    $count_stmt->bind_param($types, ...$params);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $total_events = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_events / $limit);

    //for pagination
    $sql .= " ORDER BY UNIX_TIMESTAMP(schedule) ASC LIMIT ? OFFSET ?";
    array_push($params, $limit, $offset);
    $types .= "ii";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
            $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
            unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
            $desc = strtr(html_entity_decode($row['description']), $trans);
            $desc = str_replace(array("<li>", "</li>"), array("", ","), $desc);
    ?>
            <div class="card event-list mt-3" data-id="<?php echo $row['id'] ?>">
                <div class='banner'>
                    <?php if (!empty($row['banner'])): ?>
                        <img src="assets/uploads/<?php echo ($row['banner']) ?>" alt="">
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="row align-items-center justify-content-center p-4 h-100">
                        <div class="">
                            <h3>
                                <b class="filter-txt"><?php echo ucwords($row['name']) ?></b>
                            </h3>
                            <div>
                                <small>
                                    <p><b><i class="fa fa-calendar"></i> <?php echo date("F d, Y h:i A", strtotime($row['schedule'])) ?></b></p>
                                </small>
                            </div>
                            <hr>
                            <p><b>📍 Venue:</b> <?php echo ucwords($row['venue_name']); ?></p>
                            <p><b>📌 Address:</b> <?php echo $row['address']; ?></p>
                            <p><b>👥 Audience Capacity:</b> <?php echo number_format($row['audience_capacity']); ?></p>
                            <p><b>💰 Payment Type:</b>
                                <?php echo ($row['payment_type'] == 1) ? "Free" : "Payable"; ?>
                            </p>
                            <?php if ($row['payment_type'] == 2): ?>
                                <p><b>🎟️ Attendance Fees:</b> $<?php echo number_format($row['attendance_fees'], 2); ?></p>
                            <?php endif; ?>
                            <larger class="filter-txt"><?php echo substr(strip_tags($desc), 0, 300) . '...' ?></larger>
                            <div class="mt-3">
                                <button class="btn btn-primary float-right book-event" data-id="<?php echo $row['id'] ?>">Register Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>
        <?php endwhile; ?>
        <?php if ($total_pages > 1): ?>
            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?p=<?php echo ($page - 1) . '&s=' . urlencode($search); ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?p=<?php echo $i . '&s=' . urlencode($search); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?p=<?php echo ($page + 1) . '&s=' . urlencode($search); ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            <h4>No events found</h4>
        </div>
    <?php endif; ?>

</div>


<script>
    $('.book-event').click(function() {
        uni_modal("Submit Booking Request", "booking.php?event_id=" + $(this).attr('data-id'))
    })

    $('.banner img').click(function() {
        viewer_modal($(this).attr('src'))
    })
    $('#filter').keyup(function(e) {
        var filter = $(this).val()

        $('.card.event-list .filter-txt').each(function() {
            var txto = $(this).html();
            txt = txto
            if ((txt.toLowerCase()).includes((filter.toLowerCase())) == true) {
                $(this).closest('.card').toggle(true)
            } else {
                $(this).closest('.card').toggle(false)

            }
        })
    })
</script>