<?php
$max=100;
for($i=1;$i<=$max;$i++){
 //printf("[\033[32m%d\033[0m/%d] %d%%\r",$i,$max,$i/$max*100);
echo "$i\r";
sleep(1);
}

exit();
echo "\n\n";
echo "进度条======\n";
$total = 100;
for ($i = 1; $i <= $total; $i++) {
  printf("progress: [%-50s] %d%% Done\r", str_repeat('#',$i/$total*50), $i/$total*100);
  sleep(1);
}
echo "\n";
echo "Done!\n";
