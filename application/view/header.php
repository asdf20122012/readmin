<div class="header">
    <div class="span-5 logo">
        <h1><a href="">Re:admin</a></h1>
    </div>
    <div class="right span-4 last ui-widget">
        <label for="">Database:</label>
        <select id="database" name="database">
            <?php

                for ($i = 0; $i < Config::get('databases'); $i++) {
                    $selected = ($i == (int)$currentdb) ? " selected='selected' " : '';
                    echo "<option {$selected} value='{$i}'>{$i}</option>";
                }
            ?>
        </select>
    </div>
</div>
