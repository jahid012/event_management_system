<?php
include 'user/db_connect.php';
?>
<style>
    #portfolio .img-fluid {
        width: calc(100%);
        height: 30vh;
        z-index: -1;
        position: relative;
        padding: 1em;
    }

    .event-list {
        cursor: pointer;
    }

    span.hightlight {
        background: yellow;
    }

    .banner {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 26vh;
        width: calc(30%);
    }

    .banner img {
        width: calc(100%);
        height: calc(100%);
        cursor: pointer;
    }

    .event-list {
        cursor: pointer;
        border: unset;
        flex-direction: inherit;
    }

    .event-list .banner {
        width: calc(30%)
    }

    .event-list .card-body {
        width: calc(70%)
    }

    .event-list .banner img {
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        min-height: 30vh;
    }

    span.hightlight {
        background: yellow;
    }

    .banner {
        min-height: calc(100%)
    }
</style>
<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <form role="search" method="get" class="search-form form" action="">
                    <label>
                        <span class="screen-reader-text">Search for...</span>
                        <input type="search" class="search-field" placeholder="Type something..." value="" name="s" title="" />
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
    $event = $conn->query("SELECT e.* FROM events e where date_format(e.schedule,'%Y-%m%-d') >= '" . date('Y-m-d') . "' and e.type = 1 order by unix_timestamp(e.schedule) asc");

    while ($row = $event->fetch_assoc()):
        $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
        $desc = strtr(html_entity_decode($row['description']), $trans);
        $desc = str_replace(array("<li>", "</li>"), array("", ","), $desc);
    ?>
        <div class="card event-list" data-id="<?php echo $row['id'] ?>">
            <div class='banner'>
                <?php if (!empty($row['banner'])): ?>
                    <img src="assets/uploads/<?php echo ($row['banner']) ?>" alt="">
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="row  align-items-center justify-content-center p-4 h-100">
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
                        <larger class="truncate filter-txt"><?php echo strip_tags($desc) ?></larger>
                        <div class="mt-3">
                            <button class="btn btn-primary float-right book-event" data-id="<?php echo $row['id'] ?>">Register Now</button>
                        </div>

                    </div>
                </div>


            </div>
        </div>
        <br>
    <?php endwhile; ?>

</div>


<script>
    $('.book-event').click(function(){
        uni_modal("Submit Booking Request","booking.php?event_id="+$(this).attr('data-id'))
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