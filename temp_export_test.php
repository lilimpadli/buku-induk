<?php
require __DIR__ . '/vendor/autoload.php';
use App\Exports\NilaiRaportTemplateByFilters;
$e = new NilaiRaportTemplateByFilters([2], [8], ['XI']);
var_export($e->columnWidths());
