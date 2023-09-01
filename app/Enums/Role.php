<?php

namespace App\Enums;

enum Role: int
{
    const ADMIN = 1;
    const CONTENT_CREATOR = 2;
    const MARKETER = 3;
}