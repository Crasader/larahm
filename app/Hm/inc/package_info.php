<?php

/*
 * This file is part of the entimm/hm.
 *
 * (c) entimm <entimm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

$id = sprintf('%d', app('data')->frm['id']);
  $q = 'select * from types where id = '.$id;
  $sth = db_query($q);
  $flag = 0;
  while ($row = mysql_fetch_array($sth)) {
      view_assign('package', $row);
      $flag = 1;
  }

  if ($flag == 0) {
      view_assign('no_such_plan', 1);
  }

  view_execute('package_info.blade.php');
