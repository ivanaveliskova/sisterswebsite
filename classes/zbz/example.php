<?php
/*ZBZ5 Simple Localizing tool example file */

include 'zbz5.php';

//variable
$number_of_apples = 5 ;


echo 'ZBZ5 Example file:<br/>';
echo '********************************************<br />';
//english
echo 'English: <br />';
$english = new zbz5Localizer('en_EN');
echo 'simple:<br />';
echo $english->zbz5('this is a car');
echo '<br />advanced<br />';
echo $english->zbz5('there are %s apples in the basket', $number_of_apples);
echo '<br />********************************************<br />';

//Norwegian
echo 'Norwegian:<br />';
$norwegian = new zbz5Localizer('no_NB');
echo 'simple:<br />';
echo $norwegian->zbz5('this is a car');
echo '<br />advanced<br />';
echo $norwegian->zbz5('there are %s apples in the basket', $number_of_apples);
echo '<br />********************************************<br />';

//German
echo 'German:<br />';
$german = new zbz5Localizer('de_DE');
echo 'simple:<br />';
echo $german->zbz5('this is a car');
echo '<br />advanced<br />';
echo $german->zbz5('there are %s apples in the basket', $number_of_apples);
echo '<br />********************************************<br />';

//portuguese (Brazilian)
echo 'portuguese (Brazilian):<br />';
$german = new zbz5Localizer('pt_BR');
echo 'simple:<br />';
echo $german->zbz5('this is a car');
echo '<br />advanced<br />';
echo $german->zbz5('there are %s apples in the basket', $number_of_apples);
echo '<br />********************************************<br />';

//fallback example
echo 'English as a fallback language:<br />';
$german = new zbz5Localizer('de_DE');
echo 'simple:<br />';
echo $german->zbz5('this is a car');
echo '<br />advanced:<br />';
echo $german->zbz5('there are %s apples in the basket', $number_of_apples);
echo '<br />this phrase does not exist in the german language file:<br />';
echo $german->zbz5('only in english');
echo '<br />********************************************<br />';

//example of phrase that is not in any language file
echo 'Example of phrase that does not exist in any language files:<br />';
$norwegian = new zbz5Localizer('no_NB');
echo 'simple:<br />';
echo $norwegian->zbz5('this is a car');
echo '<br />advanced:<br />';
echo $norwegian->zbz5('there are %s apples in the basket', $number_of_apples);
echo '<br />this phrase does not exist in the Norwegian language file:<br />';
echo $norwegian->zbz5('only in english');
echo '<br />this phrase does not exist in any of the language files, and will not be translated:<br />';
echo $norwegian->zbz5('phrase that does not exist, it interpets variables though, %s for example',  $number_of_apples);
echo '<br />********************************************';

?>

