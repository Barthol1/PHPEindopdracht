<?php 
namespace App\enum;
enum PackageSorting : string
{
    case NAAM = 'name';
    case STATUS = 'status';
    case DATUM = 'created_at';
}
?>