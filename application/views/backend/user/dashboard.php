<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2
    }

</style>
<?php
$factions = array();
$factions = $this->db->get('faction')->result_array();

?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('dashboard'); ?>
                </div>
            </div>
            <div class="panel-body">

                <table id="faction_table" class="cell-border" style="width:100%">
                    <thead class="cell-border">
                    <tr>
                        <th>Faction</th>
                        <?php
                        foreach ($factions as $faction) {
                            ?>
                            <th><?php echo $faction['name'] ?></th>
                            <?php
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($factions as $faction) {
                        ?>
                        <tr>
                            <td><?php echo $faction['name']; ?></td>
                            <?php
                            foreach ($factions as $faction) {
                                ?>
                                <td style="text-align-last: center"><?php echo '1/1' ?></td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div><!-- end col-->
</div>

<script>
    $(document).ready(function () {
        $('#faction_table').DataTable({
            "scrollY": 300,
            "scrollX": true,
            "ordering": false,
            "paging": false
        });
    });
</script>