<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 2/14/15
 * Time: 10:18 PM
 */
?>
<div style="padding-top: 120px;">
    <form method="post" enctype="multipart/form-data">
        <table class="table">
            <thead>
            <tr>
                <th>Paper ID</th>
                <th>Paper Title</th>
                <th>Attendance on Desk</th>
                <th>Attendance on Track</th>
                <th>Certificate Outward Number</th>
            </tr>
            </thead>
            <?php
            foreach($papers as $paper)

            ?>

        </table>
    </form>
</div>
