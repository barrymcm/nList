<!-- #!/usr/bin/php -->
<?php
$projectName = basename(getcwd()); // get the name of your app

echo PHP_EOL;
echo '+ Starting unit tests'.PHP_EOL;
exec('vendor/bin/phpunit', $output, $returnCode); // command to run tests with any testing framework you like

if ($returnCode !== 0) {
  $testSummary = $output;
  printf("%s Test Summary: ", $projectName);
  echo PHP_EOL;
  printf("( %s ) %s%2\$s", $testSummary[14], PHP_EOL);
  printf("ABORTING COMMIT!\n");
  exit(1); // git halts
}

exit(0); // git continues with push event