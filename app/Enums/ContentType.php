<?php
namespace App\Enums;

enum ContentType: string
{
    case BLOG = 'blog';
    case SERVICE = 'service';
    case ARTICLE = 'article';
    case PAGE = 'page';
}