<?php
namespace App\enum;
enum PackageStatus : string
{
    case AANGEMELD = 'Aangemeld';
    case UITGEPRINT =  'Uitgeprint';
    case SORTEERCENTRUM = 'Sorteercentrum';
    case VERZONDEN = 'Verzonden';
    case AFGELEVERD = 'Afgeleverd';
}

?>
