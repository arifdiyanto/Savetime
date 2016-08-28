<?=($q == '' ? '' : "Anda mencari <code>$q</code>")?>
    <?php
if (!isset($data['data'][0])):
	echo "<div class='text-red'>Data tidak ditemukan</div>";
else:
?>
        <table class="table table-condensed table-bordered table-hover table-striped pointer">
            <thead>
                <tr>
                    <?php
$i = 0;
foreach ($data['data'][0] as $k => $v):
	if ($i == 0) {
		$pk = $v;
	}
	$i++;
	echo "<th>$k</th>";
endforeach
?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['data'] as $k => $v): ?>
                <tr class="pointer" onclick="oShow('<?=$pk?>')">
                    <?php foreach ($v as $key => $value): ?>
                    <td>
                        <?=$value?>
                    </td>
                    <?php endforeach;?>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php endif?>
        <?=$pager?>
