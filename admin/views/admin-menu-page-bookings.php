<div class="wrap">
    <h2>Bookings</h2>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2" style="display: flex; width:100%;">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                        <?php $bookingsListTable->search_box('Search by this email', 'search_id'); ?>
                        <?php $bookingsListTable->display(); ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>
</div>